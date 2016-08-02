<?php
namespace Wave\Module;


use Wave\Base\Module\Processor\ICommandProcessor;
use Wave\Base\Commands\Command;
use Wave\Base\Commands\IManager;


/**
 * @magic
 */
class Processor implements ICommandProcessor
{
	/** @var Command */
	private $command;
	
	/** @var IManager */
	private $manager;
	
	/**
	 * @magic
	 * @var \Wave\Base\Module\Processor\ITypeFactory 
	 */
	private $factory;
	
	
	private function postExecute()
	{
		$this->manager->getLockEntity()->lock();
		$this->manager->queue()->remove($this->command);
		$this->manager->save();
		$this->manager->getLockEntity()->unlock();
	}
	
	
	/**
	 * @param Command $command
	 * @return static
	 */
	public function setCommand(Command $command)
	{
		$this->command = $command;
		return $this;
	}
	
	/**
	 * @param IManager $commandManager
	 * @return static
	 */
	public function setManager(IManager $commandManager)
	{
		$this->manager = $commandManager;
		return $this;
	}
	
	
	public function execute()
	{
		try
		{
			$typeProcessor = $this->factory->get($this->command->Type);
			
			$typeProcessor
				->setCommand($this->command)
				->execute();
		}
		finally
		{
			$this->postExecute();
		}
	}
}