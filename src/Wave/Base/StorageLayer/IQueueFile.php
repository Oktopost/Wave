<?php
namespace Wave\Base\StorageLayer;


use Wave\Base\Commands\IQueue;
use Wave\Base\FileSystem\IDataFile;


interface IQueueFile extends IDataFile
{
	/**
	 * @return IQueue
	 */
	public function load();
	
	/**
	 * @param IQueue $queue
	 */
	public function save(IQueue $queue);
}