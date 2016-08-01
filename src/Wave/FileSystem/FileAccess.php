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
		
		return file_get_contents($this->path);
	}

	/**
	 * @param string $data
	 */
	public function writeAll($data)
	{
		file_put_contents($this->path, $data);
	}
}