<?php
namespace Wave\StorageLayer;


use Wave\Scope;

use Wave\Base\FileSystem\IFileAccess;
use Wave\Base\FileSystem\IJsonFileAccess;
use Wave\Base\StorageLayer\ILocalPackages;

use Wave\Objects\Package;
use Wave\Objects\StagingState;


class LocalPackages implements ILocalPackages
{
	/** @var IJsonFileAccess */
	private $access;
	
	
	/**
	 * @param \stdClass $data
	 * @param StagingState $into
	 */
	protected function readPackages(\stdClass $data, StagingState $into)
	{
		if (!isset($data->packages))
			return;
		
		foreach ($data->packages as $packageData)
		{
			$package = new Package();
			$package->fromArray($packageData);
			$into->Staged[] = $package;
		}
	}
	
	
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
	 * @return StagingState
	 */
	public function load() 
	{
		$data = $this->access->readAll(true);
		$state = new StagingState();
		$this->readPackages($data, $state);
		
		return $state;
	}

	/**
	 * @param StagingState $state
	 */
	public function save(StagingState $state)
	{
		$data = new \stdClass();
		$data->packages = [];
		
		foreach ($state->Staged as $package)
		{
			$data->packages[] = $package->toArray();
		}
		
		$this->access->writeAll($data);
	}
}