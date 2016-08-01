<?php
namespace Wave\Base\Target;


use Wave\Base\FileSystem\Data\IServerState;
use Wave\Objects\Server;
use Wave\Objects\Package;


interface IServerConnector
{
	/**
	 * @param Server $server
	 * @return static
	 */
	public function setup(Server $server);

	/**
	 * @return IServerState
	 */
	public function getServerStateObject();

	/**
	 * @param Package $p
	 * @param string $localFullPath
	 */
	public function transferPackage(Package $p, $localFullPath);

	/**
	 * @param Package $p
	 */
	public function deploy(Package $p);

	/**
	 * @param string $localFullPath
	 * @param array $arguments
	 */
	public function executeFile($localFullPath, array $arguments = []);
}