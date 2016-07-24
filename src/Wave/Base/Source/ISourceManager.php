<?php
namespace Wave\Base\Source;


use Wave\Exceptions\InvalidSourceDirectoryException;


interface ISourceManager
{
	/**
	 * @param string $source
	 * @throws InvalidSourceDirectoryException
	 */
	public function setSourceDirectory($source);
	
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