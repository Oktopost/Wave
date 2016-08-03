<?php
namespace Wave\Module\Processor\TypeProcessors;


use Wave\Enum\CommandType;
use Wave\Base\Module\IBuild;

use Wave\Commands\Types\BuildCommand;
use Wave\Scope;


class BuildProcessorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @return BuildProcessor
	 */
	private function getObject()
	{
		return Scope::skeleton()->load(BuildProcessor::class);
	}
	
	
	public function test_getType()
	{
		self::assertEquals($this->getObject()->getType(), CommandType::BUILD);
	}
	
	
	public function test_execute_Sanity()
	{
		/** @var \PHPUnit_Framework_MockObject_MockObject|IBuild $buildModule */
		$buildModule = $this->getMock(IBuild::class);
		
		$buildModule
			->expects($this->at(0))
			->method('setTargetPackage')
			->willReturnSelf();
		
		$buildModule
			->expects($this->at(1))
			->method('build');
		
		Scope::testSkeleton(IBuild::class, $buildModule);
		
		$obj = $this->getObject();
		$obj->setCommand(new BuildCommand());
		$obj->execute();
	}
}