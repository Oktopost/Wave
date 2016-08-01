<?php
namespace Wave\Target;


use Wave\Base\Target\IServerConnector;
use Wave\Base\Target\IServerConnectorFactory;

use Wave\Enum\ServerType;
use Wave\Target\Connector\Local;
use Wave\Objects\Server;
use Wave\Exceptions\WaveUnexpectedException;

use Skeleton\ISingleton;


class ServerConnectorFactory implements IServerConnectorFactory, ISingleton
{
	/**
	 * @param Server $server
	 * @return IServerConnector
	 */
	public function get(Server $server)
	{
		switch ($server->Type)
		{
			case ServerType::LOCAL:
				$result = new Local();
				break;
			
			default:
				throw new WaveUnexpectedException("Unsupported type {$server->Type}");
		}
		
		$result->setup($server);
		
		return $result;
	}
}