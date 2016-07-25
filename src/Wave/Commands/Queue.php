<?php
namespace Wave\Base\Commands;


class Queue implements IQueue
{
	/** @var Command[] */
	private $commands = [];
	
	
	/**
	 * @param Command $command
	 * @return Command
	 */
	public function add(Command $command)
	{
		$this->commands[] = $command;
	}
	
	/**
	 * @return Command[]
	 */
	public function getAll()
	{
		return $this->commands;
	}
	
	/**
	 * @param string $type
	 * @return Command[]
	 */
	public function getAllForType($type)
	{
		return array_filter($this->commands,
			function($command)
				use ($type)
			{
				/** @var Command $command */
				return $command->Type = $type;
			});
	}
	
	/**
	 * @param Command $command
	 */
	public function remove(Command $command)
	{
		$index = array_search($command, $this->commands, true);
		
		if ($index !== false)
		{
			unset($this->commands[$index]);
		}
	}
}