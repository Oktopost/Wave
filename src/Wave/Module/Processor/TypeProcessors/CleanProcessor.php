<?php
namespace Wave\Module\Processor\TypeProcessor;


use Wave\Enum\CommandType;


class CleanProcessor extends BaseProcessor
{
	/**
	 * @return string
	 */
	public function getType()
	{
		return CommandType::CLEAN;
	}
	
	
	public function execute()
	{
		// TODO: Implement execute() method.
	}
}