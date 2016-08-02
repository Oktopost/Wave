<?php
namespace Wave\Commands;


use Wave\Enum\CommandType;
use Wave\Enum\CommandState;
use Wave\Base\Commands\IQueue;
use Wave\Base\Commands\Command;
use Wave\Base\Commands\ICommandCreator;

use Wave\Commands\Types;


class CommandCreator implements ICommandCreator
{
	/** @var IQueue */
	private $queue;
	
	
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
	 * @return Command
	 */
	public function clean()
	{
		foreach ($this->queue->getAllForType(CommandType::CLEAN) as $command)
		{
			if ($command->State == CommandState::IDLE)
			{
				return $command;
			}
		}
		
		return $this->queue->add(new Types\CleanCommand());
	}
	
	/**
	 * @param string $version
	 * @param string $targetBuild
	 * @return Command
	 */
	public function build($version, $targetBuild)
	{
		$command = new Types\BuildCommand();
		
		$command->Version = $version;
		$command->BuildTarget = $targetBuild;
		
		return $this->queue->add($command);
	}
	
	/**
	 * @param string $version
	 * @param string $targetBuild
	 * @param array $servers
	 * @return Command
	 */
	public function stage($version, $targetBuild, array $servers)
	{
		$command = new Types\StageCommand();
		
		$command->Version = $version;
		$command->BuildTarget = $targetBuild;
		$command->Servers = $servers;
		
		return $this->queue->add($command);
	}
	
	/**
	 * @param string $version
	 * @param string $targetBuild
	 * @param array $servers
	 * @return Command
	 */
	public function deploy($version, $targetBuild, array $servers)
	{
		$command = new Types\DeployCommand();
		
		$command->Version = $version;
		$command->BuildTarget = $targetBuild;
		$command->Servers = $servers;
		
		return $this->queue->add($command);
	}
}