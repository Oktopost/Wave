<?php
namespace Wave\FileSystem;


use Wave\Scope;
use Wave\Base\FileSystem\ITempDirectory;
use Wave\Exceptions\FileException;


class TempDirectory implements ITempDirectory
{
	private static $index = 0;
	
	private $fullPath = null;
	
	
	/**
	 * @return string
	 */
	private function generateRelativePath()
	{
		$globalTempDir = Scope::instance()->config('temp_directory', '.tmp');
		$tempDir = time() . '.' . getmypid() . '-' . self::$index++ . '-tmp';
		return "$globalTempDir/$tempDir";
	}
	
	
	public function __destruct()
	{
		$this->remove();
	}
	
	
	public function generate()
	{
		if ($this->fullPath)
		{
			Scope::instance()->log()->warning('Temporary directory was already generated! ' . $this->fullPath);
			return;
		}
		
		$path = $this->generateRelativePath();
		
		if (!mkdir($path, 0750, true))
			throw new FileException($path, 'Error when trying to create temporary directory');
		
		$this->fullPath = realpath($path);
	}
	
	public function remove()
	{
		if ($this->fullPath)
		{
			exec("rm -r {$this->fullPath}");
			$this->fullPath = null;
		}
	}
	
	/**
	 * @return string
	 */
	public function get()
	{
		return $this->fullPath;
	}
}