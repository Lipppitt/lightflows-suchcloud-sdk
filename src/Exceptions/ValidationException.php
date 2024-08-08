<?php

namespace Shaun\LightflowsSuchcloudSdk\Exceptions;

use Exception;

class ValidationException extends Exception
{
	public function __construct($message = "Validation error", $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
