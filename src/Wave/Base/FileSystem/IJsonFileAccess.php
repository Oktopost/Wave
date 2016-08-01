<?php
namespace Wave\Base\FileSystem;


/**
 * @skeleton
 */
interface IJsonFileAccess
{
	/**
	 * @param IFileAccess $access
	 * @return static
	 */
	public function useFileAccess(IFileAccess $access);

	/**
	 * @param bool $ignoreMissingFile
	 * @return \stdClass
	 */
	public function readAll($ignoreMissingFile = false);

	/**
	 * @param mixed $data
	 * @param bool $isPretty
	 */
	public function writeAll($data, $isPretty = true);
}