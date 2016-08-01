<?php
namespace Wave\Base\Target;


use Wave\Objects\Server;
use Wave\Objects\Package;


/**
 * @skeleton
 */
interface IServerConnectorFactory
{
	/**
	 * @param Server $server
	 * @param Package|null $package
	 * @return IServerConnector
	 */
	public function getFor(Server $server, Package $package = null);
}