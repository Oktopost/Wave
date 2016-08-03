<?php
namespace Wave\Base\Commands;


/**
 * @skeleton
 */
interface ICommandManager
{
	/**
	 * @return Command|null
	 */
	public function select();
	
	/**
	 * @param Command $command
	 */
	public function remove(Command $command);
}