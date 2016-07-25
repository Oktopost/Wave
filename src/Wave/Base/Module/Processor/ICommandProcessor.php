<?php
namespace Wave\Base\Module\Processor;


use Wave\Base\Commands\Command;
use Wave\Base\Commands\IManager;


/**
 * @skeleton
 */
interface ICommandProcessor
{
	/**
	 * @param IManager $commandManager
	 * @return static
	 */
	public function setManager(IManager $commandManager);
	
	/**
	 * @param Command $command
	 * @return static
	 */
	public function setCommand(Command $command);
	
	public function execute();
}