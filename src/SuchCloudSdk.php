<?php

namespace Shaun\LightflowsSuchcloudSdk;

use Shaun\LightflowsSuchcloudSdk\Contracts\DocumentsInterface;

final class SuchCloudSdk
{
	public DocumentsInterface $documents;

	public function __construct($dbFilePath = ':memory:')
	{
		$db 			= new Db($dbFilePath);
		$authenticate 	= new Authenticate();
		$validator 		= new DocumentsValidator();

		$this->documents = new DbDocuments($db->getInstance(), $authenticate, $validator);
	}
}
