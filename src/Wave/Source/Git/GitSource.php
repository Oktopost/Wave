<?php
namespace Wave\Source\Git;


use Wave\Scope;
use Wave\Base\Source\ISourceConnector;
use Wave\Exceptions\WaveException;
use Wave\Exceptions\FileException;

use Coyl\Git\Git;
use Coyl\Git\GitRepo;


class GitSource implements ISourceConnector
{
	private $sourceDir;
	
	/** @var GitRepo */
	private $git;
	
	
	/**
	 * @param \Exception $e
	 * @param $message
	 * @throws WaveException
	 */
	private function handleError(\Exception $e, $message)
	{
		throw new WaveException($message, 0, $e);
	}
	
	
	public function __construct()
	{
		$this->sourceDir = Scope::instance()->config('source.dir', 'source');
		
		try
		{
			$this->git = Git::open($this->sourceDir);
		}
		catch (\Exception $e)
		{
			$this->handleError($e, "Error loading repository from '$this->sourceDir'");
		}
	}
	
	
	/**
	 * @param string $version
	 */
	public function switchToVersion($version)
	{
		try
		{
			$this->git->checkout($version);
		}
		catch (\Exception $e)
		{
			$this->handleError($e, "Failed to checkout version $version");
		}
	}
	
	/**
	 * @param string $branch
	 */
	public function switchToBranch($branch)
	{
		try
		{
			$this->git->checkout($branch);
			$this->git->fetch();
			$this->git->run('merge', ['--ff-only']);
		}
		catch (\Exception $e)
		{
			$this->handleError($e, "Error chcking out branch $branch");
		}
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