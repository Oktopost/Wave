<?php
namespace Wave\Module\Processor\TypeProcessors;


use Wave\Enum\CommandType;
use Wave\Base\Module\IStage;
use Wave\Base\StorageLayer\IData;
use Wave\Base\StorageLayer\IServers;

use Wave\Scope;
use Wave\Objects\Server;
use Wave\Commands\Types\StageCommand;


class StageProcessorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @return StageProcessor
	 */
	private function getObject()
	{
		return Scope::skeleton()->load(StageProcessor::class);
	}
	
	private function mockServersData()
	{
		$server = new Server();
		$server->Name = 'a';
		
		$serversFile = $this->getMock(IServers::class);
		$serversFile->method('load')->willReturn([$server]);
		
		$data = $this->getMock(IData::class);
		$data->method('servers')->willReturn($serversFile);
		
		Scope::testSkeleton(IData::class, $data);
	}
	
	
	protected function setUp()
	{
		$this->mockServersData();
	}
	
	public function test_getType()
	{
		self::assertEquals($this->getObject()->getType(), CommandType::STAGE);
	}
	
	
	public function test_execute_Sanity()
	{
		/** @var \PHPUnit_Framework_MockObject_MockObject|IStage $stageModule */
		$stageModule = $this->getMock(IStage::class);
		
		$stageModule
			->expects($this->at(0))
			->method('setPackage')
			->willReturnSelf();
		
		$stageModule
			->expects($this->at(1))
			->method('setServer')
			->willReturnSelf();
		
		$stageModule
			->expects($this->at(2))
			->method('stage');
		
		Scope::testSkeleton(IStage::class, $stageModule);
		
		$command = new StageCommand();
		$command->Servers = ['a'];
		
		$obj = $this->getObject();
		$obj->setCommand($command);
		$obj->execute();
	}
}