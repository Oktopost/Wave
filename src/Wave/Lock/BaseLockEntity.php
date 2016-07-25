<?php
namespace Wave\Lock;


use Wave\Base\ILockEntity;


abstract class BaseLockEntity implements ILockEntity
{
	private $isLocked = false;
	
	
	public function __destruct()
	{
		$this->unlock();
	}
	
	
	protected abstract function doLock();
	
	protected abstract function doUnlock();
	
	/**
	 * @return bool
	 */
	protected abstract function doTryLockNonBlocking();
	
	
	public function lock()
	{
		if ($this->isLocked)
			return;
		
		$this->doLock();
		$this->isLocked = true;
	}
	
	public function unlock()
	{
		if ($this->isLocked)
			return;
		
		$this->doUnlock();
		$this->isLocked = false;
	}
	
	/**
	 * @return bool
	 */
	public function isLocked()
	{
		return $this->isLocked;
	}
	
	/**
	 * @return bool
	 */
	public function tryLockNonBlocking()
	{
		if ($this->isLocked)
			return true;
		
		$this->isLocked = $this->doTryLockNonBlocking();
		return $this->isLocked;
	}
}