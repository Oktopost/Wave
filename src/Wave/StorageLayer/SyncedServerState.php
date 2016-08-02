<?php
namespace Wave\StorageLayer;


use Wave\Base\FileSystem\IFileAccess;
use Wave\Base\StorageLayer\IServerState;

use Wave\Objects\RemoteState;
use Wave\Exceptions\WaveUnexpectedException;


class SyncedServerState implements IServerState
{
	/** @var IServerState */
	private $localState;
	
	/** @var IServerState */
	private $remoteState;
	
	
	public function sync()
	{
		// TODO:
	}
	
	
	/**
	 * @param IServerState $state
	 * @return static
	 */
	public function setLocalServerState(IServerState $state)
	{
		$this->localState = $state;
		return $this;
	}

	/**
	 * @param IServerState $state
	 * @return static
	 */
	public function setRemoteServerState(IServerState $state)
	{
		$this->remoteState = $state;
		return $this;
	}
	
	
	/**
	 * @param IFileAccess $access
	 * @return static
	 */
	public function setFileAccess(IFileAccess $access) 
	{
		throw new WaveUnexpectedException('This method should not be called on SyncedServerState');
	}
	
	/**
	 * @return RemoteState
	 */
	public function load()
	{
		return $this->remoteState->load();
	}
	
	/**
	 * @param RemoteState $state
	 */
	public function save(RemoteState $state)
	{
		$original = $this->localState->load();
		$this->localState->save($state);
		
		try
		{
			$this->remoteState->save($state);
		}
		catch (\Exception $e)
		{
			$this->localState->save($original);
			throw $e;
		}
	}
}