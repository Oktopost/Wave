<?php
namespace Wave\Base\Module;


use Wave\Base\Commands\Command;


/**
 * @skeleton
 */
interface ICommandSelector
{
	/**
	 * @return Command|null
	 */
	public function select();
}