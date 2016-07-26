<?php
namespace Wave\Base\FileSystem;


/**
 * @skeleton
 */
interface ITempDirectory
{
	public function generate();
	public function remove();
	
	/**
	 * @return string
	 */
	public function get();
}