<?php
namespace Wave\Base\Module;


use Wave\Enum\CommandState;
use Wave\Base\Commands\Command;
use Wave\Base\Commands\IManager;


/**
 * @magic
 */
class CommandSelector implements ICommandSelector
{
	/** @var IManager */
	private $commandManager;
	
	/**
	 * @magic
	 * @var \Wave\Module\CommandSelector\CommandSelectValidator
	 */
	private $validator;
	
	
	/**
	 * @return Command|null
	 */
	private function safeFindCommand()
	{
		$this->validator->setQueue($this->commandManager->queue());
		
		foreach ($this->commandManager->queue()->getAll() as $command)
		{
			if ($command->State != CommandState::IDLE)
			{
				continue;
			}
			else if ($this->validator->canStart($command))
			{
				return $command;
			}
		}
		
		return null;
	}
	
	
	/**
	 * @param IManager $commandManager
	 * @return static
	 */
	public function setManager(IManager $commandManager)
	{
		$this->commandManager = $commandManager;
		return $this;
	}
	
	/**
	 * @return Command|null
	 */
	public function select()
	{
		$commandToStart = null;
		
		$this->commandManager->getLockEntity()->lock();
		
		try
		{
			$commandToStart = $this->safeFindCommand();
			
			if ($commandToStart)
			{
				$commandToStart->State = CommandState::RUNNING;
				$this->commandManager->save();
			}
		}
		finally
		{
			$this->commandManager->getLockEntity()->unlock();
		}
		
		
		return $commandToStart;
	}
}