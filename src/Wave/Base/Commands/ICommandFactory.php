<?php
namespace Wave\Base\Commands;


/**
 * @skeleton
 */
interface ICommandFactory
{
	/**
	 * @param string $type
	 * @return Command
	 */
	public function get($type);
}