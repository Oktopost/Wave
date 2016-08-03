<?php
namespace Wave\Base\Module\Processor;


use Wave\Base\Commands\Command;


/**
 * @skeleton
 */
interface ICommandProcessor
{
	public function execute(Command $command);
}