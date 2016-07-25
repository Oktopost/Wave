<?php
namespace Wave\Module\Processor\TypeProcessor;


use Wave\Enum\CommandType;


class UpdateProcessor extends BaseProcessor
{
	/**
	 * @return string
	 */
	public function getType()
	{
		return CommandType::UPDATE;
	}
	
	
	public function execute()
	{
		// TODO: Implement execute() method.
	}
}