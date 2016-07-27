<?php
namespace Wave\Build\Phing;


use Wave\Base\Build\Phing\IPhingBuilder;
use Wave\Base\Build\Phing\PhingConfig;
use Wave\Scope;


class PhingBuilderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @return PhingConfig
	 */
	private function getValidConfig()
	{
		$config = new PhingConfig();
		
		$config->PathToPhing		= 'phing';
		$config->LogFile			= $this->getLogFilePath();
		$config->TargetBuild 		= 'test-build';
		$config->SourceDirectory	= realpath(__DIR__ . '/_PhingBuilderTest');
		$config->TargetBuildFile	= 'test_build.xml';
		
		return $config;
	}
	
	/**
	 * @return string
	 */
	private function getLogFilePath()
	{
		return realpath(__DIR__ . '/_PhingBuilderTest') . '/test.log';
	}
	
	/**
	 * @param string $fileName
	 * @return string
	 */
	private function getPathToCreatedFileByPhingBuild($fileName = 'a.file')
	{
		return realpath(__DIR__ . '/_PhingBuilderTest') . "/$fileName";
	}
	
	
	protected function setUp()
	{
		if (file_exists($this->getLogFilePath()))
			unlink($this->getLogFilePath());
	}
	
	
	public function test_skeleton()
	{
		Scope::testSkeleton()->clear();
		$this->assertInstanceOf(PhingBuilder::class, Scope::skeleton(IPhingBuilder::class));
	}
	
	
	public function test_setConfig_ReturnSelf()
	{
		$p = new PhingBuilder();
		$this->assertSame($p, $p->setConfig(new PhingConfig()));
	}
	
	
	/**
	 * @expectedException \Wave\Exceptions\WaveUnexpectedException
	 */
	public function test_build_ConfigNotSet_ExceptionThrown()
	{
		$p = new PhingBuilder();
		$p->build();
	}
	
	public function test_build_validConfig_NoErrorThrown()
	{
		$p = new PhingBuilder();
		$p->setConfig($this->getValidConfig());
		$p->build();
	}
	
	public function test_build_LogFileDidNotExists_LogFileCreated()
	{
		$logFile = $this->getLogFilePath();
		
		if (file_exists($logFile))
			unlink($logFile);
		
		$p = new PhingBuilder();
		$p->setConfig($this->getValidConfig());
		$p->build();
		
		$this->assertFileExists($logFile);
	}
	
	public function test_build_LogFileFilledWithPhingLog()
	{
		$logFile = $this->getLogFilePath();
		
		if (file_exists($logFile))
			unlink($logFile);
		
		$p = new PhingBuilder();
		$p->setConfig($this->getValidConfig());
		$p->build();
		
		$this->assertTrue(strlen(file_get_contents($logFile)) > 0);
	}
	
	/**
	 * @expectedException \Wave\Exceptions\Phing\PhingException
	 */
	public function test_build_InvalidBuildFile_ErrorThrown()
	{
		$config = $this->getValidConfig();
		$config->TargetBuildFile = 'not_exists.xml';
		
		$p = new PhingBuilder();
		$p->setConfig($config);
		$p->build();
	}
	
	/**
	 * @expectedException \Wave\Exceptions\Phing\PhingException
	 */
	public function test_build_InvalidBuildTarget_ErrorThrown()
	{
		$config = $this->getValidConfig();
		$config->TargetBuild = 'invalid';
		
		$p = new PhingBuilder();
		$p->setConfig($config);
		$p->build();
	}
	
	/**
	 * @expectedException \Wave\Exceptions\Phing\PhingException
	 */
	public function test_build_ErrorDuringPhingBuild_ErrorThrown()
	{
		$config = $this->getValidConfig();
		$config->TargetBuild = 'fail';
		
		$p = new PhingBuilder();
		$p->setConfig($config);
		$p->build();
	}
	
	public function test_build_AllValid_NoError()
	{
		$p = new PhingBuilder();
		$p->setConfig($this->getValidConfig());
		$p->build();
	}
	
	public function test_build_CorrectTargetRun()
	{
		$p = new PhingBuilder();
		$p->setConfig($this->getValidConfig());
		$p->build();
		
		$this->assertFileExists($this->getPathToCreatedFileByPhingBuild());
	}
}