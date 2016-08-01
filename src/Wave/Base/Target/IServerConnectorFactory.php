<?php
namespace Wave\Base\Target;


use Wave\Objects\Server;


/**
 * @skeleton
 */
interface IServerConnectorFactory
{
	/**
	 * @param Server $server
	 * @return IServerConnector
	 */
	public function get(Server $server);
}