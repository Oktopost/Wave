<?php
namespace Wave\Base\Commands;


/**
 * @skeleton
 */
interface IQueue
{
	/**
	 * @param Command $command
	 * @return Command
	 */
	public function add(Command $command);
	
	/**
	 * @return Command[]
	 */
	public function getAll();
	
	/**
	 * @param string $type
	 * @return Command[]
	 */
	public function getAllForType($type);
	
	/**
	 * @param Command $command
	 */
	public function remove(Command $command);
}