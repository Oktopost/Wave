<?php
namespace Wave\Base\Source;


/**
 * @skeleton
 */
interface ISource
{
	/**
	 * @return ISourceConnector
	 */
	public function connector();
	
	public function lock();
	public function unlock();
}