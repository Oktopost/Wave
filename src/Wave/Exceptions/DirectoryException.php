<?php
namespace Wave\Exceptions;


class DirectoryException extends WaveException
{
	/**
	 * @param string $dir
	 * @param int $message
	 */
	public function __construct($dir, $message)
	{
		parent::__construct("Error when working with directory '$dir': $message", 5);
	}
}