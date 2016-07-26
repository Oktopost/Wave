<?php
namespace Wave\Base\Build\Phing;


class PhingConfigTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \Wave\Exceptions\Phing\PhingException
	 */
	public function test_validate_LogFileIsNull_ErrorThrown()
	{
		$c = new PhingConfig();
		$c->LogFile = null;
		$c->SourceDirectory = 'a';
		$c->validate();
	}
	
	/**
	 * @expectedException \Wave\Exceptions\Phing\PhingException
	 */
	public function test_validate_SourceDirectoryIsNull_ErrorThrown()
	{
		$c = new PhingConfig();
		$c->LogFile = 'a';
		$c->SourceDirectory = null;
		$c->validate();
	}
	
	public function test_validate_ValidConfig_ErrorNotThrown()
	{
		$c = new PhingConfig();
		$c->LogFile = 'a';
		$c->SourceDirectory = 'a';
		$c->validate();
	}
}