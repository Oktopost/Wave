<?php
namespace Wave\Base\FileSystem\Data;


use Wave\Base\FileSystem\IDataFile;
use Wave\Objects\Package;


interface ILocalPackages extends IDataFile
{
	/**
	 * @return Package[]
	 */
	public function getState();

	/**
	 * @param Package $p
	 */
	public function add(Package $p);

	/**
	 * @param Package $p
	 */
	public function delete(Package $p);
}