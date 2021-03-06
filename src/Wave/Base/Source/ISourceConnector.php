<?php
namespace Wave\Base\Source;


interface ISourceConnector
{
	/**
	 * @param string $version
	 */
	public function switchToVersion($version);
	
	/**
	 * @param string $branch
	 */
	public function switchToBranch($branch);
	
	/**
	 * @param string $directory
	 */
	public function copyContentIntoDir($directory);
	
	/**
	 * @return array
	 */
	public function getBranches();
}