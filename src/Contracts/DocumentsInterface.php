<?php

namespace Shaun\LightflowsSuchcloudSdk\Contracts;

interface DocumentsInterface
{
	public function authenticate(string $apiKey);

	public function createDoc(array $data);

	public function getDoc(string $uuId);

	public function updateDoc(string $uuId, array $dataToUpdate);

	public function deleteDoc(string $uuId);
}
