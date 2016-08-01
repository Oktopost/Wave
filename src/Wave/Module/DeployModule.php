<?php
namespace Wave\Module;


use Wave\Base\ILock;
use Wave\Base\ILockEntity;
use Wave\Base\Module\IDeployment;
use Wave\Base\Target\ILocalStaging;
use Wave\Base\Target\IServerConnector;
use Wave\Base\Target\IRemoteScriptRunner;
use Wave\Base\FileSystem\IData;

use Wave\Scope;
use Wave\Objects\Server;
use Wave\Objects\Package;
use Wave\Exceptions\WaveUnexpectedException;


/**
 * @autoload
 */
class DeployModule implements IDeployment
{
	/** @var Server */
	private $server;
	
	/** @var Package */
	private $package;
	
	/** @var ILockEntity */
	private $serverLock;
	
	/** @var IServerConnector */
	private $connector;

	
	private function unsafeDeploy()
	{
		$remotePackagesConfig = $this->connector->getServerStateObject();
		$remoteState = $remotePackagesConfig->load();
		
		if ($remoteState->has($this->package->Name))
		{
			throw new WaveUnexpectedException(
				"Missing package {$this->package->Name} on remote server {$this->server->Name}");
		}
		
		/** @var IRemoteScriptRunner $scriptRunner */
		$scriptRunner = Scope::skeleton(IRemoteScriptRunner::class);
		
		$scriptRunner->runPreDeploy($this->connector, $this->package);
		
		$this->connector->deploy($this->package);
		$remoteState->setDeployed($this->package);
		$remotePackagesConfig->save($remoteState);
		
		$scriptRunner->runPostDeploy($this->connector, $this->package);
	}
	

	/**.
	 * @param IData $data
	 */
	public function __construct(IData $data)
	{
		
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
		
		$this->connector = Scope::skeleton(IServerConnector::class);
		$this->connector->setup($server);
			
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
	
	public function deploy()
	{
		$this->serverLock->lock();
		
		try
		{
			$this->unsafeDeploy();
		}
		finally
		{
			$this->serverLock->unlock();
		}
	}
}