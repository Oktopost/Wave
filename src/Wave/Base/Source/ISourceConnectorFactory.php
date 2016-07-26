<?php
namespace Wave\Base\Source;


/**
 * @skeleton
 */
interface ISourceConnectorFactory
{
	/**
	 * @param string $type
	 * @return ISourceConnector
	 */
	public function getConnector($type);
}