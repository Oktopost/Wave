<?php
namespace Wave\Module\Build;


use Wave\Scope;
use Wave\Base\Source\ISource;
use Wave\Base\FileSystem\ITempDirectory;
use Wave\Objects\Package;
use Wave\Exceptions\FileException;
use Wave\Exceptions\WaveException;


class TransferToBuildMediator 
{
	/**
	 * @return ISource
	 */
	private function getSource()
	{
		return Scope::skeleton(ISource::class);
	}
	
	/**
	 * @param ITempDirectory $temp
	 * @return string
	 */
	private function getSourceTemporaryDirPath(ITempDirectory $temp)
	{
		$sourceDirName = Scope::instance()->config('phing.source-dir', 'source');
		$sourceDir = "{$temp->get()}/$sourceDirName";
		
		if (!mkdir($sourceDir, 0750, true))
			throw new FileException($sourceDir, 'Failed to create directory for source');
		
		return $sourceDir;
	}
	
	/**
	 * @param ITempDirectory $temp
	 * @param string $version
	 */
	private function transferCode(ITempDirectory $temp, $version)
	{
		$source 	= $this->getSource();
		$sourceDir	= $this->getSourceTemporaryDirPath($temp);
		$connector	= $source->connector();
		
		$source->lock();
		
		try
		{
			$connector->switchToVersion($version);
			$connector->copyContentIntoDir($sourceDir);
		}
		finally
		{
			$source->unlock();
		}
	}
	
	/**
	 * @param ITempDirectory $temp
	 */
	private function transferPhing(ITempDirectory $temp)
	{
		$phingDir = Scope::instance()->config('phing.dir', 'phing');
		$phingDirFullPath = realpath($phingDir);
		
		if (!$phingDirFullPath)
			throw new FileException($phingDirFullPath, 'Could not find path to phing directory');
		
		$copyFrom = "$phingDir/*";
		$copyTo = $temp->get();
		$command = "cp -r $copyFrom $copyTo";
		
		Scope::instance()->log()->notice("Transferring phing to $copyTo, using $command");
		exec($command, $output, $code);
		
		if ($code !== 0)
			throw new WaveException('Failed to transfer Phing directory. Output of copy: ' . implode(' \\ ', $output));
	}
	
	
	/**
	 * @param ITempDirectory $temp
	 * @param Package $package
	 * @throws FileException
	 */
	public function transfer(ITempDirectory $temp, Package $package)
	{
		$this->transferCode($temp, $package->Version);
		$this->transferPhing($temp);
	}
}