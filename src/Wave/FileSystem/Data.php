<?php
namespace Wave\FileSystem;


use Wave\Scope;

use Wave\Base\FileSystem\IData;
use Wave\Base\FileSystem\ILocalFileAccess;
use Wave\Base\FileSystem\Data\IServerState;
use Wave\Base\FileSystem\Data\ILocalPackages;

use Wave\FileSystem\Data\ServerState;
use Wave\FileSystem\Data\LocalPackages;

use Skeleton\ISingleton;


class Data implements IData, ISingleton
{
	/**
	 * @param string $file
	 * @return ILocalFileAccess
	 */
	private function getFileAccessFor($file)
	{
		/** @var ILocalFileAccess $access */
		$access = Scope::skeleton(ILocalFileAccess::class);
		return $access->setFilePath($file);
	}
	
	
	/**
	 * @return ILocalPackages
	 */
	public function localPackages()
	{
		$path = Scope::rootDir() . "/package/packages.json";
		$state = new LocalPackages();
		$state->setFileAccess($this->getFileAccessFor($path));
		return $state;
	}

	/**
	 * @param string $serverName
	 * @return IServerState
	 */
	public function localServerState($serverName)
	{
		$path = Scope::rootDir() . "/state/$serverName/packages.json";
		$state = new ServerState();
		$state->setFileAccess($this->getFileAccessFor($path));
		return $state;
	}
}