<?php
namespace Wave\Base\FileSystem;


/**
 * @skeleton
 */
interface IFileLock
{
	/**
	 * @param string $file
	 * @return static
	 */
	public function set($file);
	
	public function lock();
	public function unlock();
}