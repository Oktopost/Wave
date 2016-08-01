<?php
namespace Wave\FileSystem\Data;


use Wave\Base\FileSystem\IFileAccess;
use Wave\Base\FileSystem\IJsonFileAccess;
use Wave\Base\FileSystem\Data\IServerState;

use Wave\Scope;
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
		$this->access->readAll();
		return new RemoteState();
	}
	
	/**
	 * @param RemoteState $state
	 */
	public function save(RemoteState $state)
	{
		$this->access->writeAll('a');
	}
}