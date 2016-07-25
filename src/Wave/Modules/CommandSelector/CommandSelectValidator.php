<?php
namespace Wave\Module\CommandSelector;


use Wave\Base\Commands\IQueue;
use Wave\Base\Commands\Command;
use Wave\Base\Module\CommandSelector\ICommandSelectValidator;


/**
 * @magic
 */
class CommandSelectValidator implements ICommandSelectValidator
{
	/** @var IQueue */
	private $queue;
	
	/**
	 * @magic
	 * @var \Wave\Base\Module\CommandSelector\ICommandTypeSelectValidatorFactory
	 */
	private $factory;
	
	/**
	 * @param IQueue $queue
	 * @return static
	 */
	public function setQueue(IQueue $queue)
	{
		$this->queue = $queue;
		return $this;
	}
	
	/**
	 * @param Command $command
	 * @return bool
	 */
	public function canStart(Command $command)
	{
		$typeValidator = $this->factory->get($command->Type);
		$typeValidator->setQueue($this->queue);
		return $typeValidator->canStart($command);
	}
}