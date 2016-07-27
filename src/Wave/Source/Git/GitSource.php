<?php
namespace Wave\Source\Git;


use Wave\Base\Source\ISourceVersion;
use Wave\Base\Source\ISourceConnector;


/**
 * @magic
 */
class GitSource implements ISourceConnector
{
	/**
	 * @var \Wave\Base\Git\IGitAPI
	 * @magic
	 */
	private $gitAPI;
	
	
	/**
	 * @param string $version
	 */
	public function switchToVersion($version)
	{
		
	}
	
	/**
	 * @param string $directory
	 */
	public function copyContentIntoDir($directory)
	{
		
	}
	
	
	/**
	 * @param string $id
	 * @return ISourceVersion|null
	 */
	public function getVersion($id)
	{
		// TODO: Implement getVersion() method.
	}
	
	/**
	 * @return array
	 */
	public function getBranches()
	{
		// TODO: Implement getBranches() method.
	}
	
	/**
	 * @param string $id
	 * @return bool
	 */
	public function hasVersion($id)
	{
		// TODO: Implement hasVersion() method.
	}
	
	/**
	 * @param string $branchName
	 * @return ISourceVersion|null
	 */
	public function getLastVersionForBranch($branchName)
	{
		// TODO: Implement getLastVersionForBranch() method.
	}
}