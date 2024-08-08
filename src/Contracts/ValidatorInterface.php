<?php

namespace Shaun\LightflowsSuchcloudSdk\Contracts;

interface ValidatorInterface
{
	public function validateData(array $data);

	public function validationRules();
}
