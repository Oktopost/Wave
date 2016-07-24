<?php
namespace Wave\Source\Git;


use Wave\Base\Git\IGitAPI;


class GitAPI implements IGitAPI
{
	/**
	 * @param string $directory
	 * @return bool
	 */
	public function setDirectory($directory)
	{
		// TODO: Implement setDirectory() method.
	}
	
	/**
	 * @return array String of branch names
	 */
	public function getRemoteBranches()
	{
		// TODO: Implement getRemoteBranches() method.
	}
	
	/**
	 * @param string $commit
	 * @return bool
	 */
	public function checkoutCommit($commit)
	{
		// TODO: Implement checkoutCommit() method.
	}
	
	/**
	 * @param string $commit
	 * @return mixed
	 */
	public function getCommitData($commit)
	{
		// TODO: Implement getCommitData() method.
	}
	
	/**
	 * @return bool
	 */
	public function fetch()
	{
		// TODO: Implement fetch() method.
	}
}