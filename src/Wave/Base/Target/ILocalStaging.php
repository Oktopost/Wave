<?php
namespace Wave\Base\Target;


use Wave\Objects\Package;


/**
 * @skeleton
 */
interface ILocalStaging
{
	/**
	 * @param Package $package
	 * @return string
	 */
	public function getDirectoryForPackage(Package $package);
}