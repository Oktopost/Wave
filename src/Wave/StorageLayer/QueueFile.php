<?php
namespace Wave\StorageLayer;


use Wave\Base\FileSystem\IFileAccess;
use Wave\Scope;
use Wave\Base\Commands\IQueue;
use Wave\Base\Commands\ICommandFactory;
use Wave\Base\FileSystem\IJsonFileAccess;
use Wave\Base\StorageLayer\IQueueFile;


class QueueFile implements IQueueFile
{
	/** @var IJsonFileAccess */
	private $access;
	
	
	/**
	 * @return ICommandFactory
	 */
	private function getCommandFactory()
	{
		return Scope::skeleton(ICommandFactory::class);
	}
	
	/**
	 * @return IQueue
	 */
	private function getQueueObject()
	{
		return Scope::skeleton(IQueue::class);
	}
	
	
	/**
	 * @param IFileAccess $access
	 * @return static
	 */
	public function setFileAccess(IFileAccess $access)
	{
		$this->access = Scope::skeleton(IJsonFileAccess::class);
		$this->access->useFileAccess($access);
		return $this;
	}
	
	/**
	 * @return IQueue
	 */
	public function load()
	{
		$data		= $this->access->readAll(true);
		$queue		= $this->getQueueObject();
		$factory	= $this->getCommandFactory();
		
		if (!$data)
			return $queue;
		
		foreach ($data as $commandData)
		{
			$command = $factory->get($commandData->Type);
			$command->fromArray($commandData);
			$queue->add($command);
		}
		
		return $queue;
	}
	
	/**
	 * @param IQueue $queue
	 */
	public function save(IQueue $queue)
	{
		$data = [];
		
		foreach ($queue->getAll() as $command)
		{
			$data[] = $command->toArray();
		}
		
		$this->access->writeAll($data);
	}
}