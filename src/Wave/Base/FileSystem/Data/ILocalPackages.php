<?php
namespace Wave\Base\FileSystem\Data;


use Wave\Base\FileSystem\IDataFile;
use Wave\Objects\StagingState;


interface ILocalPackages extends IDataFile
{
	/**
	 * @return StagingState
	 */
	public function load();

	/**
	 * @param StagingState $state
	 */
	public function save(StagingState $state);
}