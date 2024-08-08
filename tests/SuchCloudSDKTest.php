<?php

use PHPUnit\Framework\TestCase;
use Shaun\LightflowsSuchcloudSdk\Exceptions\ValidationException;
use Shaun\LightflowsSuchcloudSdk\SuchCloudSdk;

class SuchCloudSDKTest extends TestCase {

	private SuchCloudSdk $sdk;

	protected function setUp(): void {
		$this->sdk = new SuchCloudSDK();
	}

	/**
	 * @throws Exception
	 */
	public function testCanCreateDocument() {
		$apiKey = 'John';
		$this->sdk->documents->authenticate($apiKey);

		$uuid = $this->sdk->documents->createDoc([
			'title' => 'Test Title',
			'slug' => 'test-slug',
			'contents' => ['field1' => 'value1', 'field2' => 'value2']
		]);

		$doc = $this->sdk->documents->getDoc($uuid);

		$this->assertEquals('Test Title', $doc['title']);
		$this->assertEquals('test-slug', $doc['slug']);
		$this->assertEquals(['field1' => 'value1', 'field2' => 'value2'], $doc['contents']);
	}

	/**
	 * @throws Exception
	 */
	public function testCreateDocumentIsValidated() {
		$apiKey = 'John';
		$this->sdk->documents->authenticate($apiKey);

		$this->expectException(ValidationException::class);
		$this->sdk->documents->createDoc([]);
	}

	/**
	 * @throws Exception
	 */
	public function testCanEditDocument() {
		$apiKey = 'John';
		$this->sdk->documents->authenticate($apiKey);

		$uuid = $this->sdk->documents->createDoc([
			'title' => 'Test Title',
			'slug' => 'test-slug',
			'contents' => ['field1' => 'value1', 'field2' => 'value2']
		]);

		$dataToUpdate = [
			'title' => 'Updated Title',
			'slug' => 'updated-slug',
			'contents' => ['field1' => 'new value']
		];

		$this->sdk->documents->updateDoc($uuid, $dataToUpdate);
		$doc = $this->sdk->documents->getDoc($uuid);

		$this->assertEquals('Updated Title', $doc['title']);
		$this->assertEquals('updated-slug', $doc['slug']);
		$this->assertEquals(['field1' => 'new value'], $doc['contents']);
	}

	/**
	 * @throws Exception
	 */
	public function testCanDeleteDocument() {
		$apiKey = 'John';
		$this->sdk->documents->authenticate($apiKey);

		$uuid = $this->sdk->documents->createDoc([
			'title' => 'Test Title',
			'slug' => 'test-slug',
			'contents' => []
		]);

		$this->sdk->documents->deleteDoc($uuid);

		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Document not found');
		$this->sdk->documents->getDoc($uuid);
	}

	/**
	 * @throws Exception
	 */
	public function testDocumentPartitioningByApiKey(): void
	{
		$this->sdk->documents->authenticate('John');
		$docId = $this->sdk->documents->createDoc([
			'title' => 'John\'s Document',
			'slug' => 'johns-doc',
			'contents' => []
		]);

		$this->sdk->documents->authenticate('Mary');

		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Document not found');

		$this->sdk->documents->getDoc($docId);
	}

	public function testAuthenticateWithoutApiKeyThrowsException() {
		$this->expectException(Exception::class);
		$this->sdk->documents->createDoc([
			'title' => 'No API Key',
			'slug' => 'no-api-key',
			'contents' => ''
			]
		);
	}
}
