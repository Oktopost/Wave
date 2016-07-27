<?php
namespace Wave\Module\Build;


use Wave\Exceptions\WaveConfigException;
use Wave\Scope;
use Wave\Base\Build\Phing\IPhingBuilder;
use Wave\Base\Build\Phing\PhingConfig;
use Wave\Base\Target\ILocalStaging;
use Wave\Base\FileSystem\ITempDirectory;
use Wave\Objects\Package;
use Wave\Exceptions\FileException;

use DepMap\Deployment;


class BuildMediator 
{
	/**
	 * @param Package $package
	 * @return string
	 */
	private function getLogFile(Package $package)
	{
		$logDir = Scope::instance()->config('phing.log-dir', 'Log/phing');
		$logDirFullPath = realpath($logDir);
		
		if (!$logDirFullPath || !is_dir($logDirFullPath))
		{
			throw new WaveConfigException(
				'phing.log-dir',
				'Failed to find target directory',
				$logDir);
		}
		
		return $logDir . '/' . time() . '-' . $package->Name . '.phing.log';
	}
	
	/**
	 * @param string $buildDir
	 * @param Package $package
	 * @return IPhingBuilder
	 */
	private function getPhingBuildObject($buildDir, Package $package)
	{
		$pc = new PhingConfig();
		
		$pc->LogFile			= $this->getLogFile($package);
		$pc->TargetBuild		= $package->BuildTarget;
		$pc->SourceDirectory	= $buildDir;
		
		/** @var IPhingBuilder $phingBuild */
		$phingBuild = Scope::skeleton(IPhingBuilder::class);
		$phingBuild->setConfig($pc);
		
		return $phingBuild;
	}
	
	/**
	 * @param ITempDirectory $tempDir
	 * @param string $targetDir
	 */
	private function runDepMap(ITempDirectory $tempDir, $targetDir)
	{
		$depMap = new Deployment();
		
		$depMap->setRootDirectory($tempDir->get());
		$depMap->setTargetDirectory($targetDir);
		$depMap->deploy();
	}
	
	
	/**
	 * @param ITempDirectory $temp
	 * @param Package $package
	 * @throws FileException
	 */
	public function build(ITempDirectory $temp, Package $package)
	{
		$localStaging	= Scope::skeleton(ILocalStaging::class);
		$phingBuilder	= $this->getPhingBuildObject($temp->get(), $package);
		$packageDir		= $localStaging->getDirectoryForPackage($package);
		
		$phingBuilder->build();
		$this->runDepMap($temp, $packageDir);
	}
}