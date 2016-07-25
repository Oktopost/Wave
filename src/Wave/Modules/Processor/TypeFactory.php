<?php
namespace Wave\Module\Processor;


use Wave\Enum\CommandType;
use Wave\Base\Module\Processor\ITypeFactory;
use Wave\Base\Module\Processor\ITypeProcessor;
use Wave\Exceptions\WaveException;


class TypeFactory implements ITypeFactory
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
				return new TypeProcessor\CleanProcessor();
			
			default:
				throw new WaveException("Unexpected type $type");
		}
	}
}