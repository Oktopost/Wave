<?php
namespace Wave\Base\StorageLayer;


/**
 * @skeleton
 */
interface IData
{
	/**
	 * @return ILocalPackages
	 */
	public function localPackages();

	/**
	 * @param string $serverName
	 * @return IServerState
	 */
	public function localServerState($serverName);
	
	/**
	 * @return IServers
	 */
	public function servers();
}