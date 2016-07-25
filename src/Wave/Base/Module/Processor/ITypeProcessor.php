<?php
namespace Wave\Base\Module\Processor;


use Wave\Base\Commands\Command;


interface ITypeProcessor
{
	/**
	 * @return string
	 */
	public function getType();
	
	/**
	 * @param Command $command
	 * @return static
	 */
	public function setCommand(Command $command);
	
	public function execute();
}