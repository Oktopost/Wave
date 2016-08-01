<?php
namespace Wave\Base\Module;


use Wave\Objects\Package;
use Wave\Objects\Server;

interface IDeployment
{
	/**
	 * @param Server $server
	 * @return static
	 */
	public function setServer(Server $server);

	/**
	 * @param Package $package
	 * @return static
	 */
	public function setPackage(Package $package);
	
	public function deploy();
}