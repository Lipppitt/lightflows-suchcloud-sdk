<?php

namespace Shaun\LightflowsSuchcloudSdk;
use Exception;
use Shaun\LightflowsSuchcloudSdk\Contracts\AuthentificationInterface;

final class Authenticate implements AuthentificationInterface
{
	public string $apiKey = '';

	public function setApiKey(string $apiKey): void
	{
		$this->apiKey = $apiKey;
	}

	/**
	 * @throws Exception
	 */
	public function getApiKey(): string
	{
		if (empty($this->apiKey)) {
			throw new Exception('No api key found');
		}
		return $this->apiKey;
	}

	/**
	 * @throws Exception
	 */
	public function isAuthenticated(): void
	{
		if (!$this->apiKey) {
			throw new Exception('API key required.');
		}
	}
}
