<?php
namespace Wave\Base\Module\Build;


use Wave\Objects\Package;


class BuildModule implements IBuild
{
	/** @var Package */
	private $package;
	
	
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
		// Create TempDir
		
		// Lock Source
		// Switch version 
		// Copy
		// Unlock Source
		
		// Copy Phing
		// Build Phing
		
		// Run DepMap
		$this->package->touch();
		// Save package data
		
		// Remove TempDir
	}
}