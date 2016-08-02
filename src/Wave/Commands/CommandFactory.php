<?php
namespace Wave\Commands;


use Wave\Enum\CommandType;
use Wave\Base\Commands\Command;
use Wave\Base\Commands\ICommandFactory;
use Wave\Exceptions\WaveUnexpectedException;

use Wave\Commands\Types;


class CommandFactory implements ICommandFactory
{
	/**
	 * @param string $type
	 * @return Command
	 */
	public function get($type)
	{
		switch ($type)
		{
			case CommandType::BUILD:
				return new Types\BuildCommand();
			
			case CommandType::STAGE:
				return new Types\StageCommand();
			
			case CommandType::DEPLOY:
				return new Types\DeployCommand();
			
			case CommandType::CLEAN:
				return new Types\CleanCommand();
			
			case CommandType::UPDATE:
			default:
				throw new WaveUnexpectedException("Unexpected command type: $type");
		}
	}
}