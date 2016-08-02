<?php
namespace Wave\Base\Commands;


use Wave\Scope;


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
		foreach ($this->commands as $index => $existing)
		{
			if ($existing->ID == $command->ID)
			{
				unset($this->commands[$index]);
				return;
			}
		}
		
		Scope::instance()->log()->info('Command was not found when trying to remove @0', $command->toArray());
	}
}