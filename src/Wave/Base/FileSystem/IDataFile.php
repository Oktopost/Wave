<?php
namespace Wave\Base\FileSystem;


interface IDataFile
{
	/**
	 * @param IFileAccess $access
	 * @return static
	 */
	public function setFileAccess(IFileAccess $access);
}