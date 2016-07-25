<?php
namespace Wave\Base\Commands;


/**
 * @skeleton
 */
interface IQueueFile
{
	/**
	 * @param string $filePath
	 * @return static
	 */
	public function setFile($filePath);
	
	/**
	 * @return IQueue
	 */
	public function load();
	
	/**
	 * @param IQueue $queue
	 */
	public function save(IQueue $queue);
}