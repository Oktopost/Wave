<?php
namespace Wave\StorageLayer;


use Wave\Scope;

use Wave\Base\FileSystem\IDataFile;
use Wave\Base\FileSystem\ILocalFileAccess;
use Wave\Base\StorageLayer\IData;
use Wave\Base\StorageLayer\IServers;
use Wave\Base\StorageLayer\IServerState;
use Wave\Base\StorageLayer\ILocalPackages;

use Skeleton\ISingleton;


class Data implements IData, ISingleton
{
	/**
	 * @param IDataFile $dataLoader
	 * @param string $file
	 * @return ILocalFileAccess
	 */
	private function setupFileAccessFor(IDataFile $dataLoader, $file)
	{
		/** @var ILocalFileAccess $access */
		$access = Scope::skeleton(ILocalFileAccess::class);
		$access->setFilePath($file);
		$dataLoader->setFileAccess($access);
		return $dataLoader;
	}
	
	
	/**
	 * @return ILocalPackages
	 */
	public function localPackages()
	{
		$path = Scope::rootDir() . "/package/packages.json";
		return $this->setupFileAccessFor(new LocalPackages(), $path);
	}

	/**
	 * @param string $serverName
	 * @return IServerState
	 */
	public function localServerState($serverName)
	{
		$path = Scope::rootDir() . "/state/$serverName/packages.json";
		return $this->setupFileAccessFor(new ServerState(), $path);
	}
	
	/**
	 * @return IServers
	 */
	public function servers()
	{
		$path = Scope::rootDir() . "/servers.json";
		return $this->setupFileAccessFor(new Servers(), $path);
	}
}