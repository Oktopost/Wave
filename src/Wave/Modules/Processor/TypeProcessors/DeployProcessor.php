<?php
namespace Wave\Module\Processor\TypeProcessor;


use Wave\Enum\CommandType;


class DeployProcessor extends BaseProcessor
{
	/**
	 * @return string
	 */
	public function getType()
	{
		return CommandType::STAGE;
	}
	
	
	public function execute()
	{
		// TODO: Implement execute() method.
	}
}