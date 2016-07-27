<?php
namespace Wave\Base\Module;


use Wave\Objects\Package;


/**
 * @skeleton
 */
interface IBuild
{
	/**
	 * @param Package $package
	 * @return static
	 */
	public function setTargetPackage(Package $package);
	
	public function build();
}