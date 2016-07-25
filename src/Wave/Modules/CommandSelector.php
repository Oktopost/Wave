<?php
namespace Wave\Base\Module;


use Wave\Enum\CommandState;
use Wave\Base\Commands\Command;


/**
 * @magic
 */
class CommandSelector implements ICommandSelector
{
	/**
	 * @magic
	 * @var \Wave\Module\CommandSelector\CommandSelectValidator
	 */
	private $validator;
	
	/**
	 * @magic
	 * @var \Wave\Base\Commands\IManager
	 */
	private $commandManager;
	
	
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