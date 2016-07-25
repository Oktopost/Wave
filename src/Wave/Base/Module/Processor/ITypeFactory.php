<?php
namespace Wave\Base\Module\Processor;


/**
 * @skeleton
 */
interface ITypeFactory
{
	/**
	 * @param string $type
	 * @return ITypeProcessor
	 */
	public function get($type);
}