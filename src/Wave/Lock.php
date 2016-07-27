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
		return new FileLockEntity(Scope::instance()->config('lock.source', 'source'));
	}
}