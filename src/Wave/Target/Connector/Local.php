<?php
namespace Wave\Target\Connector;


use Wave\Base\Target\ILocalStaging;
use Wave\Base\Target\IServerConnector;
use Wave\Base\FileSystem\IData;
use Wave\Base\FileSystem\ILocalFileAccess;
use Wave\Base\FileSystem\Data\IServerState;

use Wave\Scope;
use Wave\Objects\Server;
use Wave\Objects\Package;
use Wave\FileSystem\Data\ServerState;
use Wave\FileSystem\Data\SyncedServerState;

use Wave\Exceptions\FileException;
use Wave\Exceptions\DirectoryException;


class Local implements IServerConnector
{
	/** @var Server */
	private $server;
	
	
	/**
	 * @param Server $server
	 * @return static
	 */
	public function setup(Server $server)
	{
		$this->server = $server;
		return $this;
	}

	/**
	 * @return IServerState
	 */
	public function getServerStateObject() 
	{
		/** @var IData $data */
		$data = Scope::skeleton(IData::class);
		$localAccess = $data->localServerState($this->server);
		
		/** @var ILocalFileAccess $remoteAccess */
		$remoteAccess = Scope::skeleton(ILocalFileAccess::class);
		$remoteAccess->setFilePath($this->server->StagingDir . '/state.json');
		
		$synced = new SyncedServerState();
		$synced->setLocalServerState((new ServerState())->setFileAccess($localAccess));
		$synced->setRemoteServerState((new ServerState())->setFileAccess($remoteAccess));
		
		return $synced;
	}

	/**
	 * @param Package $p
	 */
	public function transferPackage(Package $p) 
	{
		/** @var ILocalStaging $localStage */
		$localStage = Scope::skeleton(ILocalStaging::class);
		$path = $localStage->getDirectoryForPackage($p);
		
		exec("cp -r $path {$this->server->StagingDir}/", $output, $value);
		
		if ($value != 0)
		{
			$output = str_replace('\n', ' \\ ', $output);
			throw new DirectoryException(
				$this->server->StagingDir, 
				"Error when trying to copy package directory $path. Output: $output");
		}
	}

	/**
	 * @param Package $p
	 */
	public function deploy(Package $p) 
	{
		$from = $this->server->StagingDir . '/' . $p->Name;
		exec("ln -snf $from {$this->server->DeploymentLinkDir}", $output, $value);
		
		if ($value != 0)
		{
			$output = str_replace('\n', ' \\ ', $output);
			throw new FileException(
				$this->server->DeploymentLinkDir, 
				"Error when trying to create a symbolik link to $from. Output: $output");
		}
	}

	/**
	 * @param string $localFullPath
	 * @param array $arguments
	 */
	public function executeFile($localFullPath, array $arguments = []) {}
}