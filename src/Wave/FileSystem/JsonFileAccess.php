<?php
namespace Wave\FileSystem;


use Wave\Base\FileSystem\IFileAccess;
use Wave\Base\FileSystem\IJsonFileAccess;
use Wave\Exceptions\WaveException;


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
		$data = $this->fileAccess->readAll($ignoreMissingFile);
		
		if ($data === '')
			return new \stdClass();
		
		$decoded = json_decode($data);
		
		if (is_null($decoded))			
			throw new WaveException('Failed to decode data from file: ' . json_last_error_msg());
		
		return $decoded;
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