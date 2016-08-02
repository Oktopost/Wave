<?php
namespace Wave\Base\StorageLayer;


use Wave\Base\FileSystem\IDataFile;
use Wave\Objects\Server;


interface IServers extends IDataFile
{
	/**
	 * @return Server[]
	 */
	public function load();

	/**
	 * @param Server[] $servers
	 */
	public function save(array $servers);
}