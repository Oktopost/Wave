<?php
namespace Wave\Base\Commands;


use Wave\Base\ILockEntity;


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
	
	/**
	 * @return ILockEntity
	 */
	public function getLockEntity();
}