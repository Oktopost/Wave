<?php
namespace Wave\Objects;


use Objection\LiteSetup;
use Objection\LiteObject;


/**
 * @property string $Name
 * @property string $Version
 * @property string $BuildTarget
 * @property int $Timestamp
 */
class Package extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'Name'			=> LiteSetup::createString(),
			'Version'		=> LiteSetup::createString(),
			'BuildTarget'	=> LiteSetup::createString(),
			'Timestamp'		=> LiteSetup::createInt()
		];
	}
	
	
	public function touch()
	{
		$this->Timestamp = time();
	}
	
	
	/**
	 * @param string $version
	 * @param string $buildTarget
	 * @return Package
	 */
	public static function create($version, $buildTarget)
	{
		$package = new Package();
		
		$package->Name			= "$buildTarget-$version";
		$package->Version		= $version;
		$package->BuildTarget	= $buildTarget;
		$package->Timestamp		= time();
		
		return $package;
	}
}