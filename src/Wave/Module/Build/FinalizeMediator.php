<?php
namespace Wave\Module\Build;


use Wave\Base\FileSystem\IData;
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
		/** @var IData $data */
		$data = Scope::skeleton(IData::class);
		$localPackagesData = $data->localPackages();
		
		$package->touch();
		
		$localState = $localPackagesData->load();
		$localState->Staged[] = $package;
		$localPackagesData->save($localState);
		
		$temp->remove();
	}
}