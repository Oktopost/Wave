<?php
namespace Wave\Base\Source;


interface ISourceVersion
{
	/**
	 * @return string
	 */
	public function getVersionID();
	
	/**
	 * @return string
	 */
	public function getSourceType();
	
	/**
	 * @param string $targetDirectory Full path.
	 * @return bool
	 */
	public function copyTo($targetDirectory);
}