<?php
namespace Wave\Base\FileSystem;


/**
 * @skeleton
 */
interface ILocalFileAccess extends IFileAccess
{
	/**
	 * @param string $path
	 * @return static
	 */
	public function setFilePath($path);
}