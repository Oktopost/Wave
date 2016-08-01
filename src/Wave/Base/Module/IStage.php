<?php
namespace Wave\Base\Module;


use Wave\Objects\Server;
use Wave\Objects\Package;


/**
 * @skeleton
 */
interface IStage
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
	
	public function stage();
}