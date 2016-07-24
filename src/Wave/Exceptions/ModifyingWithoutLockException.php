<?php
namespace Wave\Exceptions;


class ModifyingWithoutLockException extends WaveException
{
	/**
	 * @param string $filePath
	 */
	public function __construct($filePath)
	{
		parent::__construct("Unexpected exception: trying to modify shared file without lock: '$filePath'", 2);
	}
}