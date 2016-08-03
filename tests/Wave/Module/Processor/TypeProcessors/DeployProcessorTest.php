<?php
namespace Wave\Module\Processor\TypeProcessors;


use Wave\Enum\CommandType;
use Wave\Base\Module\IDeployment;
use Wave\Base\StorageLayer\IData;
use Wave\Base\StorageLayer\IServers;

use Wave\Scope;
use Wave\Objects\Server;
use Wave\Commands\Types\DeployCommand;


class DeployProcessorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @return DeployProcessor
	 */
	private function getObject()
	{
		return Scope::skeleton()->load(DeployProcessor::class);
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
		self::assertEquals($this->getObject()->getType(), CommandType::DEPLOY);
	}
	
	
	public function test_execute_Sanity()
	{
		/** @var \PHPUnit_Framework_MockObject_MockObject|IDeployment $deploymentModule */
		$deploymentModule = $this->getMock(IDeployment::class);
		
		$deploymentModule
			->expects($this->at(0))
			->method('setPackage')
			->willReturnSelf();
		
		$deploymentModule
			->expects($this->at(1))
			->method('setServer')
			->willReturnSelf();
		
		$deploymentModule
			->expects($this->at(2))
			->method('deploy');
		
		Scope::testSkeleton(IDeployment::class, $deploymentModule);
		
		$command = new DeployCommand();
		$command->Servers = ['a'];
		
		$obj = $this->getObject();
		$obj->setCommand($command);
		$obj->execute();
	}
}