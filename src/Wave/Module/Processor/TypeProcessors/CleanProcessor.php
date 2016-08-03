<?php
namespace Wave\Module\Processor\TypeProcessors;


use Wave\Enum\CommandType;


/**
 * @magic
 */
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