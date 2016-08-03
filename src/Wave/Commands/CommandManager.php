<?php
namespace Wave\Commands;


use Wave\Base\ILock;
use Wave\Base\ILockEntity;
use Wave\Base\Commands\IQueue;
use Wave\Base\Commands\Command;
use Wave\Base\Commands\ICommandManager;
use Wave\Base\StorageLayer\IData;
use Wave\Base\StorageLayer\IQueueFile;

use Wave\Enum\CommandState;


/**
 * @magic
 */
class CommandManager implements ICommandManager
{
	/** @var ILockEntity */
	private $commandLock;
	
	/** @var IQueueFile */
	private $commandDataFile;
	
	/**
	 * @magic
	 * @var \Wave\Module\CommandSelector\CommandSelectValidator
	 */
	private $validator;
	
	
	/**
	 * @param IQueue $queue
	 * @return null|Command
	 */
	private function safeFindCommand(IQueue $queue)
	{		
		$this->validator->setQueue($queue);
		
		foreach ($queue->getAll() as $command)
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
	 * @param IQueue $queue
	 * @return Command|null
	 */
	private function safeStartCommand(IQueue $queue)
	{
		$commandToStart = $this->safeFindCommand($queue);
		
		if ($commandToStart)
		{
			$commandToStart->State = CommandState::RUNNING;
			$this->commandDataFile->save($queue);
		}
		
		return $commandToStart;
	}
	
	
	/**
	 * @param ILock $lock
	 * @param IData $data
	 */
	public function __construct(ILock $lock, IData $data)
	{
		$this->commandLock = $lock->commands();
		$this->commandDataFile = $data->commandsQueue();
	}
	
	
	/**
	 * @return Command|null
	 */
	public function select()
	{
		$this->commandLock->lock();
		
		$queue = $this->commandDataFile->load();
		
		try
		{
			return $this->safeStartCommand($queue);
		}
		finally
		{
			$this->commandLock->unlock();
		}
	}
	
	/**
	 * @param Command $command
	 */
	public function remove(Command $command)
	{
		$this->commandLock->lock();
		
		try
		{
			$queue = $this->commandDataFile->load();
			$queue->remove($command);
			$this->commandDataFile->save($queue);
		}
		finally
		{
			$this->commandLock->unlock();
		}
	}
}