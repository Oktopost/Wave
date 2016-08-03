<?php
namespace Wave;


use Wave\Base\ILock;
use Wave\Base\ILockEntity;
use Wave\Lock\FileLockEntity;

use Skeleton\ISingleton;


class Lock implements ILock, ISingleton
{
	/**
	 * @return ILockEntity
	 */
	public function source()
	{
		return new FileLockEntity(Scope::instance()->config('lock.source', 'source.lock'));
	}
	
	/**
	 * @return ILockEntity
	 */
	public function commands()
	{
		return new FileLockEntity(Scope::instance()->config('lock.source', 'commands.lock'));
	}
	
	/**
	 * @param string $serverName
	 * @return ILockEntity
	 */
	public function server($serverName)
	{
		$name = Scope::instance()->config('lock.server', 'server.%id.lock');
		return new FileLockEntity(str_replace('%id', $serverName, $name));
	}

	/**
	 * @param string $packageName
	 * @return ILockEntity
	 */
	public function package($packageName)
	{
		$name = Scope::instance()->config('lock.package', 'package.%id.lock');
		return new FileLockEntity(str_replace('%id', $packageName, $name));
	}
}