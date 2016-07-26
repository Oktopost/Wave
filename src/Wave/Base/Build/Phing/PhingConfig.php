<?php
namespace Wave\Base\Build\Phing;


use Wave\Scope;
use Wave\Exceptions\Phing\PhingException;

use Objection\LiteSetup;
use Objection\LiteObject;


/**
 * @property string $PathToPhing
 * @property string $TargetBuildFile
 * @property string $SourceDirectory
 * @property string $TargetBuild
 * @property string $LogFile
 */
class PhingConfig extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'PathToPhing'		=> LiteSetup::createString(Scope::instance()->config('phing.executable', 'phing')),
			'TargetBuildFile'	=> LiteSetup::createString(Scope::instance()->config('phing.build-file', 'build.xml')),
			'SourceDirectory'	=> LiteSetup::createString(null),
			'TargetBuild'		=> LiteSetup::createString(Scope::instance()->config('phing.build-target', 'build')),
			'LogFile'			=> LiteSetup::createString(null)
		];
	}
	
	
	/**
	 * @throws PhingException
	 */
	public function validate()
	{
		if (is_null($this->LogFile))
			throw new PhingException('Unexpected exception: Log file is not set');
		
		if (is_null($this->SourceDirectory))
			throw new PhingException('Unexpected exception: Source directory not set');
	}
}