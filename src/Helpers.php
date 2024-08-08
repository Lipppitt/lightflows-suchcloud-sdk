<?php

namespace Shaun\LightflowsSuchcloudSdk;
final class Helpers
{
	/**
	 * @throws \Exception
	 */
	public static function generateUuId(): string
	{
		return bin2hex(random_bytes(16));
	}
}
