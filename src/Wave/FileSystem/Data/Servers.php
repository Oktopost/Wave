<?php
namespace Wave\FileSystem\Data;


use Wave\Scope;

use Wave\Base\FileSystem\IFileAccess;
use Wave\Base\FileSystem\IJsonFileAccess;
use Wave\Base\FileSystem\Data\IServers;

use Wave\Objects\Server;


class Servers implements IServers
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
	 * @return Server[]
	 */
	public function load()
	{
		$data = $this->access->readAll(true);
		$servers = [];
		
		if (!$data) return [];
		
		foreach ($data as $serverData)
		{
			$server = new Server();
			$server->fromArray($serverData);
			$servers[] = $server;
		}
		
		return $servers;
	}

	/**
	 * @param Server[] $servers
	 */
	public function save(array $servers)
	{
		$data = [];
		
		foreach ($servers as $server)
		{
			$data[] = $server->toArray();
		}
		
		$this->access->writeAll($data);
	}
}