<?php

namespace Shaun\LightflowsSuchcloudSdk;

use Exception;
use Shaun\LightflowsSuchcloudSdk\Contracts\AuthentificationInterface;
use Shaun\LightflowsSuchcloudSdk\Contracts\DocumentsInterface;
use Shaun\LightflowsSuchcloudSdk\Contracts\ValidatorInterface;
use PDO;

final class DbDocuments implements DocumentsInterface
{
	private PDO $db;
	private AuthentificationInterface $authenticate;
	private ValidatorInterface $validator;

	public function __construct(PDO $db, AuthentificationInterface $authenticate, ValidatorInterface $validator)
	{
		$this->db = $db;
		$this->authenticate = $authenticate;
		$this->validator = $validator;
	}

	public function authenticate(string $apiKey): void
	{
		$this->authenticate->setApiKey($apiKey);
	}

	/**
	 * @throws Exception
	 */
	public function createDoc(array $data): string
	{
		$this->authenticate->isAuthenticated();
		$validatedData = $this->validator->validateData($data);

		$uuId = Helpers::generateUuId();

		$stmt = $this->db->prepare("INSERT INTO documents (api_key, uuid, title, slug, contents) VALUES (?, ?, ?, ?, ?)");
		$stmt->execute([
			$this->authenticate->getApiKey(),
			$uuId,
			$validatedData['title'],
			$validatedData['slug'],
			json_encode($validatedData['contents'])
		]);

		return $uuId;
	}

	/**
	 * @throws Exception
	 */
	public function getDoc(string $uuId): array
	{
		$this->authenticate->isAuthenticated();
		$stmt = $this->db->prepare("SELECT * FROM documents WHERE uuid = ? AND api_key = ?");
		$stmt->execute([$uuId, $this->authenticate->getApiKey()]);

		$document = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$document) {
			throw new Exception('Document not found');
		}

		$document['contents'] = json_decode($document['contents'], true);

		return $document;
	}

	/**
	 * @throws Exception
	 */
	public function updateDoc(string $uuId, array $dataToUpdate): void
	{
		$this->authenticate->isAuthenticated();
		$validatedData = $this->validator->validateData($dataToUpdate);

		$stmt = $this->db->prepare("UPDATE documents SET title = ?, slug = ?, contents = ? WHERE uuid = ? AND api_key = ?");
		$stmt->execute([
			$validatedData['title'],
			$validatedData['slug'],
			json_encode($validatedData['contents']),
			$uuId,
			$this->authenticate->getApiKey()
		]);

		if ($stmt->rowCount() === 0) {
			throw new Exception('Document update failed or document not found');
		}
	}

	/**
	 * @throws Exception
	 */
	public function deleteDoc(string $uuId): void
	{
		$this->authenticate->isAuthenticated();

		$stmt = $this->db->prepare("DELETE FROM documents WHERE uuid = ? AND api_key = ?");
		$stmt->execute([$uuId, $this->authenticate->getApiKey()]);

		if ($stmt->rowCount() === 0) {
			throw new Exception('Document delete failed or document not found');
		}
	}
}
