<?php
namespace Wave\Exceptions;


class InvalidSourceDirectoryException extends WaveException
{
	/**
	 * @param string $dir
	 * @param int $type
	 */
	public function __construct($dir, $type)
	{
		parent::__construct("The directory '$dir' is not a valid source directory for '$type' source", 1);
	}
}