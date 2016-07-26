<?php
namespace Wave\Base\Build\Phing;


use Objection\LiteSetup;
use Objection\LiteObject;
use Wave\Exceptions\Phing\PhingException;


/**
 * @property string $PathToPhing
 * @property string $TargetBuildFile
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
			'PathToPhing'		=> LiteSetup::createString('phing'),
			'TargetBuildFile'	=> LiteSetup::createString('build.xml'),
			'TargetBuild'		=> LiteSetup::createString('build'),
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
	}
}