<?php
namespace Wave\Commands;


use Wave\Commands\Types\DeployCommand;
use Wave\Commands\Types\StageCommand;
use Wave\Enum\CommandType;
use Wave\Enum\CommandState;
use Wave\Base\Commands\IQueue;
use Wave\Base\Commands\Command;
use Wave\Base\Commands\ICommandCreator;

use Wave\Commands\Types\CleanCommand;
use Wave\Commands\Types\BuildCommand;


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
		
		return $this->queue->add(new CleanCommand());
	}
	
	/**
	 * @param string $version
	 * @param string $targetBuild
	 * @return Command
	 */
	public function build($version, $targetBuild)
	{
		$command = new BuildCommand();
		
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
		$command = new StageCommand();
		
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
		
		$command = new DeployCommand();
		
		$command->Version = $version;
		$command->BuildTarget = $targetBuild;
		$command->Servers = $servers;
		
		return $this->queue->add($command);
	}
}