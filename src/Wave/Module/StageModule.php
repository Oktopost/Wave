<?php
namespace Wave\Module;


use Wave\Base\ILock;
use Wave\Base\ILockEntity;
use Wave\Base\Module\IStage;
use Wave\Base\Target\ILocalStaging;
use Wave\Base\Target\IServerConnector;
use Wave\Base\Target\IRemoteScriptRunner;
use Wave\Base\Target\IServerConnectorFactory;
use Wave\Base\StorageLayer\IData;
use Wave\Base\StorageLayer\ILocalPackages;

use Wave\Scope;
use Wave\Objects\Server;
use Wave\Objects\Package;
use Wave\Exceptions\WaveUnexpectedException;


/**
 * @magic
 */
class StageModule implements IStage
{
	/** @var Server */
	private $server;
	
	/** @var Package */
	private $package;
	
	/** @var ILockEntity */
	private $serverLock;
	
	/** @var ILockEntity */
	private $packageLock;
	
	/** @var ILocalPackages */
	private $localPackagesConfig;
	
	/** @var IServerConnector */
	private $connector;

	
	private function unsafeStage()
	{
		$remotePackagesConfig = $this->connector->getServerStateObject();
		$remotePackages = $remotePackagesConfig->load();
		
		if ($remotePackages->has($this->package->Name))
			return;
		
		/** @var ILocalStaging $localStaging */
		$localStaging = Scope::skeleton(ILocalStaging::class);
		
		/** @var IRemoteScriptRunner $scriptRunner */
		$scriptRunner = Scope::skeleton(IRemoteScriptRunner::class);
		
		$this->packageLock->lock();
		
		try 
		{
			$localPackages = $this->localPackagesConfig->load();
			
			if (!$localPackages->has($this->package->Name))
				throw new WaveUnexpectedException("Missing package {$this->package->Name} on local");
			
			$scriptRunner->runPreStage($this->connector, $this->package);
			
			$dir = $localStaging->getDirectoryForPackage($this->package);
			$this->connector->transferPackage($this->package);
			
			$localPackages->get($this->package->Name)->touch();
			$remotePackages->Staged[] = $this->package;
			
			$remotePackagesConfig->save($remotePackages);
			$this->localPackagesConfig->save($localPackages);
		}
		finally
		{
			$this->packageLock->unlock();
		}
		
		$scriptRunner->runPostStage($this->connector, $this->package);
	}
	

	/**.
	 * @param IData $data
	 */
	public function __construct(IData $data)
	{
		$this->localPackagesConfig = $data->localPackages();
	}


	/**
	 * @param Server $server
	 * @return static
	 */
	public function setServer(Server $server)
	{
		$this->server = $server;
		
		/** @var ILock $lock */
		$lock = Scope::skeleton(ILock::class);
		$this->serverLock = $lock->server($server->Name);
		
		/** @var IServerConnectorFactory $factory */
		$factory = Scope::skeleton(IServerConnectorFactory::class);
		$this->connector = $factory->get($server);
			
		return $this;
	}

	/**
	 * @param Package $package
	 * @return static
	 */
	public function setPackage(Package $package)
	{
		$this->package = $package;
		return $this;
	}

	public function stage()
	{
		$this->serverLock->lock();
		
		try
		{
			$this->unsafeStage();
		}
		finally
		{
			$this->serverLock->unlock();
		}
	}
}