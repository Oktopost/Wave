<?php
namespace Wave\Base\FileSystem;


use Wave\Base\FileSystem\Data\IServerState;
use Wave\Base\FileSystem\Data\ILocalPackages;


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
}