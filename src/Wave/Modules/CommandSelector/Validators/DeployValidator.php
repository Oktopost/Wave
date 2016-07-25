<?php
namespace Wave\Module\CommandSelector\Validators;


use Wave\Enum\CommandType;
use Wave\Enum\CommandState;
use Wave\Base\Commands\Command;


class DeployValidator extends BaseValidator
{
	/**
	 * @param Command $command
	 * @return bool
	 */
	public function canStart(Command $command)
	{
		foreach ($this->queue()->getAllForType(CommandType::CLEAN) as $scheduled)
		{
			if ($scheduled === $command)
				continue;
			
			if ($scheduled->State == CommandState::RUNNING)
			{
				return false;
			}
		}
		
		return true;
	}
}