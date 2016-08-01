<?php
namespace Wave\Base\FileSystem;


interface IFileAccess
{
	/**
	 * @param bool $ignoreMissingFile
	 */
	public function readAll($ignoreMissingFile = false);

	/**
	 * @param string $data
	 */
	public function writeAll($data);
}