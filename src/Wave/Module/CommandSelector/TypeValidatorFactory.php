<?php
namespace Wave\Module\CommandSelector;


use Wave\Enum\CommandType;
use Wave\Base\Module\CommandSelector\ICommandTypeSelectValidator;
use Wave\Base\Module\CommandSelector\ICommandTypeSelectValidatorFactory;
use Wave\Exceptions\WaveException;

use Skeleton\ISingleton;


class TypeValidatorFactory implements ICommandTypeSelectValidatorFactory, ISingleton
{
	/**
	 * @param string $type
	 * @return ICommandTypeSelectValidator
	 */
	public function get($type)
	{
		switch ($type)
		{
			case CommandType::BUILD:
				return new Validators\BuildValidator();
			
			case CommandType::DEPLOY:
				return new Validators\DeployValidator();
			
			case CommandType::CLEAN:
				return new Validators\CleanValidator();
			
			case CommandType::STAGE:
				return new Validators\StagingValidator();
			
			case CommandType::UPDATE:
				return new Validators\UpdateValidator();
			
			default:
				throw new WaveException("Unexpected type $type");
		}
	}
}