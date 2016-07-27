<?php
namespace Wave\Source\Git;


use Wave\Scope;
use Wave\Base\Source\ISourceConnector;
use Wave\Exceptions\FileException;

use Cz\Git\GitRepository;


class GitSource implements ISourceConnector
{
	private $sourceDir;
	
	/** @var GitRepository */
	private $git;
	
	
	public function __construct()
	{
		$this->sourceDir = Scope::instance()->config('source.dir', 'source');
		$this->git = new GitRepository($this->sourceDir);
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
					'Failed to copy directroy/file. Output: ' . implode(' \\ ', $output)
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
		
		foreach ($this->git->getBranches() as $branch)
		{
			if (strpos($branch, 'remotes') === 0)
			{
				$result[] = substr($branch, strrpos($branch, '/') + 1);
			}
		}
		
		return $result;
	}
}