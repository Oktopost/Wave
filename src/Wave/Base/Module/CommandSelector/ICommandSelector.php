<?php
namespace Wave\Base\Module\CommandSelector;


use Wave\Base\Commands\Command;
use Wave\Base\Commands\IManager;


/**
 * @skeleton
 */
interface ICommandSelector
{
	/**
	 * @param IManager $commandManager
	 * @return static
	 */
	public function setManager(IManager $commandManager);
	
	/**
	 * @return Command|null
	 */
	public function select();
}