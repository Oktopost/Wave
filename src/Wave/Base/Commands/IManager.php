<?php
namespace Wave\Base\Commands;


/**
 * @skeleton
 */
interface IManager
{
	/**
	 * @param string $file
	 * @return static
	 */
	public function setSource($file);
	
	/**
	 * @return ICommandCreator
	 */
	public function create();
	
	/**
	 * @return IQueue
	 */
	public function queue();
	
	public function load();
	
	public function save();
	
	public function lock();
	
	public function unlock();
}