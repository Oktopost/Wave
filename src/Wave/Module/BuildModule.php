<?php
namespace Wave\Module;


use Wave\Scope;
use Wave\Base\Module\IBuild;
use Wave\Base\FileSystem\ITempDirectory;
use Wave\Objects\Package;

use Wave\Module\Build\BuildMediator;
use Wave\Module\Build\FinalizeMediator;
use Wave\Module\Build\TransferToBuildMediator;


class BuildModule implements IBuild
{
	/** @var Package */
	private $package;
	
	
	/**
	 * @return ITempDirectory
	 */
	private function getTempDir()
	{
		/** @var ITempDirectory $tempDir */
		$tempDir = Scope::skeleton(ITempDirectory::class);
		$tempDir->generate();
		return $tempDir;
	}
	
	
	/**
	 * @param Package $package
	 * @return static
	 */
	public function setTargetPackage(Package $package)
	{
		$this->package = $package;
		return $this;
	}
	
	public function build()
	{
		$tempDir	= $this->getTempDir();
		$transfer 	= new TransferToBuildMediator();
		$build		= new BuildMediator();
		$finalize	= new FinalizeMediator();
		
		try
		{
			$transfer->transfer($tempDir, $this->package);
			$build->build($tempDir, $this->package);
			$finalize->finalize($tempDir, $this->package);
		}
		finally
		{
			$tempDir->remove();
		}
	}
}