<?php

namespace Shaun\LightflowsSuchcloudSdk;
use Exception;
use Shaun\LightflowsSuchcloudSdk\Contracts\ValidatorInterface;
use Shaun\LightflowsSuchcloudSdk\Exceptions\ValidationException;

final class DocumentsValidator implements ValidatorInterface
{
	/**
	 * @throws Exception
	 */
	public function validateData(array $data): array
	{
		$errors = [];
		foreach ($this->validationRules() as $field => $rules) {
			if (isset($rules['required']) && $rules['required'] && empty($data[$field])) {
				$errors[] = ucfirst($field) . ' is a required field';
			}
			if (isset($rules['exists']) && $rules['exists'] && !array_key_exists($field, $data)) {
				$errors[] = ucfirst($field) . ' key must exist';
			}
		}

		if (!empty($errors)) {
			throw new ValidationException('Validation failed: ' . implode(', ', $errors));
		}

		return $data;
	}

	public function validationRules(): array
	{
		// @TODO add more rules if necessary
		return [
			'title' => [
				'exists' => true,
				'required' => true
			],
			'slug' => [
				'exists' => true,
				'required' => true
			],
			'contents' => [
				'exists' => true,
			],
		];
	}
}
