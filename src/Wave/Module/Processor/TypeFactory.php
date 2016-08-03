<?php
namespace Wave\Module\Processor;


use Wave\Enum\CommandType;
use Wave\Base\Module\Processor\ITypeFactory;
use Wave\Base\Module\Processor\ITypeProcessor;
use Wave\Exceptions\WaveException;

use Skeleton\ISingleton;
use Wave\Scope;


class TypeFactory implements ITypeFactory, ISingleton
{
	/**
	 * @param string $type
	 * @return ITypeProcessor
	 */
	public function get($type)
	{
		switch ($type)
		{
			case CommandType::CLEAN:
				return Scope::skeleton()->load(TypeProcessors\CleanProcessor::class);
			
			case CommandType::UPDATE:
				return Scope::skeleton()->load(TypeProcessors\UpdateProcessor::class);
			
			case CommandType::BUILD:
				return Scope::skeleton()->load(TypeProcessors\BuildProcessor::class);
			
			case CommandType::STAGE:
				return Scope::skeleton()->load(TypeProcessors\StageProcessor::class);
			
			case CommandType::DEPLOY:
				return Scope::skeleton()->load(TypeProcessors\DeployProcessor::class);
			
			default:
				throw new WaveException("Unexpected type $type");
		}
	}
}