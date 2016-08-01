<?php
namespace Wave\Exceptions;


class FileException extends WaveException
{
	/**
	 * @param string $filePath
	 * @param string $message
	 */
	public function __construct($filePath, $message)
	{
		parent::__construct("Error when working with '$filePath': $message", 3);
	}
}