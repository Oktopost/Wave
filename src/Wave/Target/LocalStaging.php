<?php
namespace Wave\Target;


use Wave\Scope;
use Wave\Base\FileSystem\IJsonFile;
use Wave\Base\Target\ILocalStaging;
use Wave\Objects\Package;
use Wave\Objects\StagingState;


class LocalStaging implements ILocalStaging
{
	private $stagingDir;
	
	
	/**
	 * @param string $target
	 * @return string
	 */
	private function getStagingPathTo($target)
	{
		return Scope::instance()->rootDir() . "/{$this->getStagingDir()}/$target";
	}
	
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
	
	/**
	 * @param Package $package
	 */
	public function savePackage(Package $package)
	{
		/** @var IJsonFile $jsonFile */
		$jsonFile = Scope::skeleton(IJsonFile::class);
		$jsonFile->setTarget($this->getStagingPathTo("{$package->Name}.json"));
		$jsonFile->save($package);
	}
	
	/**
	 * @return StagingState
	 */
	public function getLocalState()
	{
		// $remoteState = new RemoteState();
	}
}