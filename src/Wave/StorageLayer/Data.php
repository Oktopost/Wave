<?php
namespace Wave\StorageLayer;


use Wave\Scope;

use Wave\Base\StorageLayer;
use Wave\Base\FileSystem\IDataFile;
use Wave\Base\FileSystem\ILocalFileAccess;

use Skeleton\ISingleton;


class Data implements StorageLayer\IData, ISingleton
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
	 * @return StorageLayer\ILocalPackages
	 */
	public function localPackages()
	{
		$path = Scope::rootDir() . "/package/packages.json";
		return $this->setupFileAccessFor(new LocalPackages(), $path);
	}

	/**
	 * @param string $serverName
	 * @return StorageLayer\IServerState
	 */
	public function localServerState($serverName)
	{
		$path = Scope::rootDir() . "/state/$serverName/packages.json";
		return $this->setupFileAccessFor(new ServerState(), $path);
	}
	
	/**
	 * @return StorageLayer\IServers
	 */
	public function servers()
	{
		$path = Scope::rootDir() . "/servers.json";
		return $this->setupFileAccessFor(new Servers(), $path);
	}
	
	/**
	 * @return StorageLayer\IQueueFile
	 */
	public function commandsQueue()
	{
		$path = Scope::rootDir() . "/state/commands.json";
		return $this->setupFileAccessFor(new QueueFile(), $path);
	}
}