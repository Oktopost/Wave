<?php
namespace Wave\Source\Git;


use Wave\Scope;
use Wave\Base\Source\ISourceConnector;
use Wave\Exceptions\FileException;

use Coyl\Git\Git;
use Coyl\Git\GitRepo;


class GitSource implements ISourceConnector
{
	private $sourceDir;
	
	/** @var GitRepo */
	private $git;
	
	
	public function __construct()
	{
		$this->sourceDir = Scope::instance()->config('source.dir', 'source');
		$this->git = Git::open($this->sourceDir);
	}
	
	
	/**
	 * @param string $version
	 */
	public function switchToVersion($version)
	{
		$this->git->checkout($version);
	}
	
	/**
	 * @param string $directory
	 */
	public function copyContentIntoDir($directory)
	{
		foreach (scandir($this->sourceDir . '/') as $item)
		{
			if (in_array($item, ['..', '.', '.git'])) continue;
			
			exec("cp -r $this->sourceDir/$item $directory", $output, $code);
			
			if ($code != 0)
			{
				throw new FileException(
					$item,
					'Failed to copy directory/file. Output: ' . implode(' \\ ', $output)
				);
			}
		}
	}
	
	/**
	 * @return array
	 */
	public function getBranches()
	{
		$result = [];
		
		foreach ($this->git->branches(GitRepo::BRANCH_LIST_MODE_REMOTE) as $branch)
		{
			$result[] = substr($branch, strrpos($branch, '/') + 1);
		}
		
		return $result;
	}
}