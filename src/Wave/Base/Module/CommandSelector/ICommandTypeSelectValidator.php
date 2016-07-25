<?php
namespace Wave\Base\Module\CommandSelector;


use Wave\Base\Commands\IQueue;
use Wave\Base\Commands\Command;


interface ICommandTypeSelectValidator
{
	/**
	 * @param IQueue $queue
	 * @return static
	 */
	public function setQueue(IQueue $queue);
	
	/**
	 * @param Command $command
	 * @return bool
	 */
	public function canStart(Command $command);
}