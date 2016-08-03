<?php
namespace Wave\Base;


/**
 * @skeleton
 */
interface ILock
{
	/**
	 * @return ILockEntity
	 */
	public function source();
	
	/**
	 * @return ILockEntity
	 */
	public function commands();

	/**
	 * @param string $serverName
	 * @return ILockEntity
	 */
	public function server($serverName);

	/**
	 * @param string $packageName
	 * @return ILockEntity
	 */
	public function package($packageName);
}