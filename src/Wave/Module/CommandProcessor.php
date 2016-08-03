<?php
namespace Wave\Module;


use Wave\Commands\CommandManager;
use Wave\Base\Module\Processor\ICommandProcessor;
use Wave\Base\Commands\Command;


/**
 * @magic
 */
class CommandProcessor implements ICommandProcessor
{
	/** 
	 * @magic
	 * @var  
	 */
	private $commandSelector;
	
	/**
	 * @magic
	 * @var \Wave\Base\Module\Processor\ITypeFactory 
	 */
	private $factory;
	
	
	/**
	 * @param Command $command
	 */
	private function safeExecute(Command $command)
	{
		$typeProcessor = $this->factory->get($command->Type);
		$typeProcessor
			->setCommand($command)
			->execute();
	}
	
	/**
	 * @param Command $command
	 */
	private function remove(Command $command)
	{
		
	}
	
	
	/**
	 * @param Command $command
	 */
	public function execute(Command $command)
	{
		try
		{
			$this->safeExecute($command);
		}
		finally
		{
			$this->remove($command);
		}
	}
}