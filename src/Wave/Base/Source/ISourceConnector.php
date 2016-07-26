<?php
namespace Wave\Base\Source;


interface ISourceConnector
{
	/**
	 * @param string $version
	 */
	public function switchToVersion($version);
	
	/**
	 * @param string $directory
	 */
	public function copyContentIntoDir($directory);
	
	/**
	 * @param string $id
	 * @return ISourceVersion|null
	 */
	public function getVersion($id);
	
	/**
	 * @return array
	 */
	public function getBranches();
	
	/**
	 * @param string $id
	 * @return bool
	 */
	public function hasVersion($id);
	
	/**
	 * @param string $branchName
	 * @return ISourceVersion|null
	 */
	public function getLastVersionForBranch($branchName);
}