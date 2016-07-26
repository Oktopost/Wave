<?php
namespace Wave\Module\Processor\TypeProcessor;


use Wave\Enum\CommandType;


class BuildProcessor extends BaseProcessor
{
	/**
	 * @return string
	 */
	public function getType()
	{
		return CommandType::BUILD;
	}
	
	
	public function execute()
	{
		// TODO: Implement execute() method.
	}
}