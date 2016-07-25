<?php
namespace Wave\Lock;


use Wave\Exceptions\FileException;


class FileLockEntity extends BaseLockEntity
{
	private $file;
	
	private $handle = null;
	
	
	/**
	 * @throws FileException
	 */
	private function throwCouldNotLock()
	{
		$this->doUnlock();
		throw new FileException(
			$this->file,
			'Could not acquire lock on file. Make sure the directory is writable.');
	}
	
	/**
	 * @throws FileException
	 */
	private function throwCouldNotWrite()
	{
		$this->doUnlock();
		throw new FileException(
			$this->file,
			'Could not write to the locked file. Make sure the directory and file are writable.');
	}
	
	private function openFileForLock()
	{
		$this->handle = fopen('/tmp/wave.run.lock', 'c');
		
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
		
		if (fwrite($this->handle, getmypid()) === false)
			$this->throwCouldNotWrite();
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
	 * @param string $file
	 */
	public function __construct($file) 
	{
		$this->file = $file;
	}
}