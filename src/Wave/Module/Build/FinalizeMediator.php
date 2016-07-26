<?php
namespace Wave\Module\Build;


use Wave\Scope;
use Wave\Base\Target\ILocalStaging;
use Wave\Base\FileSystem\ITempDirectory;
use Wave\Objects\Package;
use Wave\Exceptions\FileException;


class FinalizeMediator 
{
	/**
	 * @param ITempDirectory $temp
	 * @param Package $package
	 * @throws FileException
	 */
	public function finalize(ITempDirectory $temp, Package $package)
	{
		$localStaging = Scope::instance()->skeleton(ILocalStaging::class);
		
		$package->touch();
		$localStaging->savePackage($package);
		$temp->remove();
	}
}