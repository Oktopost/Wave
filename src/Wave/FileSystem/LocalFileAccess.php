<?php
namespace Wave\FileSystem;


use Wave\Base\FileSystem\ILocalFileAccess;
use Wave\Exceptions\FileException;


class LocalFileAccess implements ILocalFileAccess
{
	private $path;
	
	
	/**
	 * @param string $path
	 * @return static
	 */
	public function setFilePath($path)
	{
		$this->path = $path;
		return $this;
	}
	
	
	/**
	 * @param bool $ignoreMissingFile
	 * @return string
	 */
	public function readAll($ignoreMissingFile = false)
	{
		if (!is_readable($this->path))
		{
			if ($ignoreMissingFile) return '';
			
			throw new FileException($this->path, 'Failed to read from file.');
		}
		
		$h = fopen($this->path, 'r');
		
		if ($h === false)
			throw new FileException($this->path, 'Failed to read from file.');
		
		flock($h, LOCK_EX);
		$data = fread($h, PHP_INT_MAX);
		fclose($h);
		
		return $data;
	}

	/**
	 * @param string $data
	 */
	public function writeAll($data)
	{
		$h = fopen($this->path, 'w');
		
		if ($h === false)
			throw new FileException($this->path, 'Failed to write to file.');
		
		flock($h, LOCK_EX);
		fwrite($h, $data);
		fclose($h);
	}
}