<?php
namespace Wave\Base\Module\CommandSelector;


/**
 * @skeleton
 */
interface ICommandTypeSelectValidatorFactory
{
	/**
	 * @param string $type
	 * @return ICommandTypeSelectValidator
	 */
	public function get($type);
}