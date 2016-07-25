<?php
namespace Wave\Module\Processor\TypeProcessor;


use Wave\Base\Commands\Command;
use Wave\Base\Module\Processor\ITypeProcessor;


abstract class BaseProcessor implements ITypeProcessor
{
	/** @var Command */
	private $command;
	
	
	/**
	 * @return Command
	 */
	protected function command()
	{
		return $this->command;
	}
	
	
	/**
	 * @return string
	 */
	public abstract function getType();
	
	public abstract function execute();
	
	
	/**
	 * @param Command $command
	 * @return static
	 */
	public function setCommand(Command $command)
	{
		$this->command = $command;
		return $this;
	}
}