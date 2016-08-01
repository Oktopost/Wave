<?php
namespace Wave\FileSystem;


use Wave\Base\FileSystem\IFileAccess;
use Wave\Base\FileSystem\IJsonFileAccess;


class JsonFileAccess implements IJsonFileAccess
{
	/** @var IFileAccess */
	private $fileAccess = null;
	
	
	/**
	 * @param IFileAccess $access
	 * @return static
	 */
	public function useFileAccess(IFileAccess $access) 
	{
		$this->fileAccess = $access;
		return $this;
	}
	
	/**
	 * @param bool $ignoreMissingFile
	 * @return \stdClass
	 */
	public function readAll($ignoreMissingFile = false)
	{
		return json_decode($this->fileAccess->readAll($ignoreMissingFile));
	}
	
	/**
	 * @param mixed $data
	 * @param bool $isPretty
	 */
	public function writeAll($data, $isPretty = true)
	{
		$encodedData = json_encode($data, ($isPretty ? JSON_PRETTY_PRINT : 0));
		$this->fileAccess->writeAll($encodedData);
	}
}