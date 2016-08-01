<?php
namespace Wave\Target;


use Wave\Scope;
use Wave\Base\Target\ILocalStaging;
use Wave\Base\FileSystem\IJsonFile;
use Wave\Objects\Package;
use Wave\Objects\StagingState;


class LocalStaging implements ILocalStaging
{
	private $stagingDir;
	
	
	/**
	 * @return string
	 */
	private function getStagingDir()
	{
		if (!$this->stagingDir)
			$this->stagingDir = Scope::instance()->config('package.dir', 'package');
		
		return $this->stagingDir;
	}
	
	
	/**
	 * @param Package $package
	 * @return string
	 */
	public function getDirectoryForPackage(Package $package)
	{
		return "{$this->getStagingDir()}/{$package->Name}";
	}
}