<?php
namespace Wave\Module\CommandSelector\Validators;


use Wave\Base\Commands\IQueue;
use Wave\Base\Module\CommandSelector\ICommandTypeSelectValidator;


abstract class BaseValidator implements ICommandTypeSelectValidator
{
	/** @var IQueue */
	private $queue;
	
	
	/**
	 * @return IQueue
	 */
	protected function queue()
	{
		return $this->queue;
	}
	
	
	/**
	 * @param IQueue $queue
	 * @return static
	 */
	public function setQueue(IQueue $queue)
	{
		$this->queue = $queue;
		return $this;
	}
}