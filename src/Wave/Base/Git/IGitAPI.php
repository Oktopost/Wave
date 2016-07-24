<?php
namespace Wave\Base\Git;


/**
 * @skeleton
 */
interface IGitAPI
{
	/**
	 * @param string $directory
	 * @return bool
	 */
	public function setDirectory($directory);
	
	/**
	 * @return array String of branch names
	 */
	public function getRemoteBranches();
	
	/**
	 * @param string $commit
	 * @return bool
	 */
	public function checkoutCommit($commit);
	
	/**
	 * @param string $commit
	 * @return mixed
	 */
	public function getCommitData($commit);
	
	/**
	 * @return bool
	 */
	public function fetch();
}