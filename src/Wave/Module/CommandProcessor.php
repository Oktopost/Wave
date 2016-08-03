<?php
namespace Wave\Module;


use Wave\Base\Module\Processor\ICommandProcessor;
use Wave\Base\Commands\Command;

use Wave\Scope;


/**
 * @magic
 */
class CommandProcessor implements ICommandProcessor
{
	/** 
	 * @magic
	 * @var \Wave\Commands\CommandManager
	 */
	private $commandManager;
	
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
	public function execute(Command $command)
	{
		try
		{
			Scope::instance()->log()->info('Executing command: @0 type @1', $command->ID, $command->Type);
			$this->safeExecute($command);
			Scope::instance()->log()->info('Command complete: @0 type @1', $command->ID, $command->Type);
		}
		finally
		{
			$this->commandManager->remove($command);
		}
	}
}