<?php
namespace Wave\Base\FileSystem\Data;


use Wave\Base\FileSystem\IDataFile;

use Wave\Objects\Package;
use Wave\Objects\RemoteState;


interface IServerState extends IDataFile
{
	/**
	 * @return RemoteState
	 */
	public function read();

	/**
	 * @param Package $p
	 */
	public function add(Package $p);

	/**
	 * @param Package $p
	 */
	public function delete(Package $p);

	/**
	 * @param Package|string $package Package or package name.
	 */
	public function setDeployed($package);
}