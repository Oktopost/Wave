<?php
namespace Wave\FileSystem\Data;


use Wave\Scope;

use Wave\Base\FileSystem\IFileAccess;
use Wave\Base\FileSystem\IJsonFileAccess;
use Wave\Base\FileSystem\Data\IServerState;

use Wave\Objects\Package;
use Wave\Objects\RemoteState;


class ServerState implements IServerState
{
	/** @var IJsonFileAccess */
	private $access;
	
	
	/**
	 * @param IFileAccess $access
	 * @return static
	 */
	public function setFileAccess(IFileAccess $access) 
	{
		$this->access = Scope::skeleton(IJsonFileAccess::class);
		$this->access->useFileAccess($access);
		return $this;
	}
	
	/**
	 * @return RemoteState
	 */
	public function load()
	{
		$data = $this->access->readAll(true);
		$state = new RemoteState();
		
		if (!isset($data->packages))
			$data->packages = [];
			
		foreach ($data->packages as $packageData)
		{
			$package = new Package();
			$package->fromArray($packageData);
			$state->Staged[] = $package;
		}
		
		if (isset($data->deployed))
			$state->setDeployed($data->deployed);
		
		return $state;
	}
	
	/**
	 * @param RemoteState $state
	 */
	public function save(RemoteState $state)
	{
		$data = new \stdClass();
		
		$data->packages = [];
		
		if ($state->hasDeployed())
			$data->deployed = $state->Deployed->Name;
		
		foreach ($state->Staged as $package)
		{
			$data->packages[] = $package->toArray();
		}
		
		$this->access->writeAll($data);
	}
}