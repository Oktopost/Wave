<?php
namespace Wave\Base\StorageLayer;


use Wave\Base\FileSystem\IDataFile;
use Wave\Objects\RemoteState;


interface IServerState extends IDataFile
{
	/**
	 * @return RemoteState
	 */
	public function load();

	/**
	 * @param RemoteState $state
	 */
	public function save(RemoteState $state);
}