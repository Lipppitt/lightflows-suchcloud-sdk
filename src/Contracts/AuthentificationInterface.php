<?php

namespace Shaun\LightflowsSuchcloudSdk\Contracts;

interface AuthentificationInterface
{
	public function setApiKey(string $apiKey);

	public function getApiKey();

	public function isAuthenticated();
}
