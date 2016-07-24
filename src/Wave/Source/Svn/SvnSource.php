<?php
namespace Wave\Source\Svn;


use Wave\Base\Source\ISourceManager;
use Wave\Base\Source\ISourceVersion;
use Wave\Exceptions\InvalidSourceDirectoryException;


class SvnSource implements ISourceManager
{
	/**
	 * @param string $source
	 * @throws InvalidSourceDirectoryException
	 */
	public function setSourceDirectory($source)
	{
		// TODO: Implement setSourceDirectory() method.
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