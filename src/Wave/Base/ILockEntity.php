<?php
namespace Wave\Base;


interface ILockEntity
{
	public function lock();
	
	public function unlock();
	
	/**
	 * @return bool
	 */
	public function isLocked();
	
	/**
	 * @return bool
	 */
	public function tryLockNonBlocking();
}