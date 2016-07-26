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
		$c->validate();
	}
	
	public function test_validate_LogFileIsSet_ErrorNotThrown()
	{
		$c = new PhingConfig();
		$c->LogFile = 'a';
		$c->validate();
	}
}