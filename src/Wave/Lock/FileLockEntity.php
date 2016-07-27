<?php
namespace Wave\Lock;


use Wave\Exceptions\FileException;
use Wave\Scope;


class FileLockEntity extends BaseLockEntity
{
	private $fileName;
	
	private $handle = null;
	
	/**
	 * @return string
	 */
	private function getLockFilePath()
	{
		$lockDir = Scope::instance()->config('lock.dir', '.tmp/lock');
		
		if (!is_dir($lockDir) && !mkdir($lockDir, 0750, true))
			throw new FileException($lockDir, 'Filed to access lock directory');
		
		return "$lockDir/$this->fileName";
	}
	
	/**
	 * @throws FileException
	 */
	private function throwCouldNotLock()
	{
		$this->doUnlock();
		throw new FileException(
			$this->fileName,
			'Could not acquire lock on file. Make sure the directory is writable.');
	}
	
	/**
	 * @throws FileException
	 */
	private function throwCouldNotWrite()
	{
		$this->doUnlock();
		throw new FileException(
			$this->fileName,
			'Could not write to the locked file. Make sure the directory and file are writable.');
	}
	
	private function openFileForLock()
	{
		$filePath = $this->getLockFilePath();
		$this->handle = fopen($filePath, 'c');
		
		if ($this->handle === false)
		{
			$this->throwCouldNotLock();
		}
	}
	
	
	protected function doLock()
	{
		$this->openFileForLock();
		
		if (!flock($this->handle, LOCK_EX))
			$this->throwCouldNotLock();
		
		if (fwrite($this->handle, getmypid() . PHP_EOL) === false ||
			fwrite($this->handle, time()) === false)
		{
			$this->throwCouldNotWrite();
		}
	}
	
	protected function doUnlock()
	{
		if (is_null($this->handle))
			return;
		
		fclose($this->handle);
		$this->handle = null;
	}
	
	/**
	 * @return bool
	 */
	protected function doTryLockNonBlocking()
	{
		if (!is_null($this->handle))
			return true;
		
		$this->openFileForLock();
		
		if (!flock($this->handle, LOCK_EX | LOCK_NB))
		{
			$this->doUnlock();
			return false;
		}
		
		if (fwrite($this->handle, getmypid()) === false)
			$this->throwCouldNotWrite();
		
		return true;
	}
	
	
	/**
	 * @param string $fileName
	 */
	public function __construct($fileName) 
	{
		$this->fileName = $fileName;
	}
}