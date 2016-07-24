<?php
namespace Wave\Base\Source;


/**
 * @skeleton
 */
interface ISourceManagerFactory
{
	/**
	 * @param string $type
	 * @return ISourceManager
	 */
	public function get($type);
}