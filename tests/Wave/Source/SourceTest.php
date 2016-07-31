<?php
namespace Wave\Source;


use Wave\Lock;
use Wave\Scope;
use Wave\Config;
use Wave\Base\ILock;
use Wave\Base\ILockEntity;
use Wave\Base\Source\ISourceConnector;
use Wave\Base\Source\ISourceConnectorFactory;


class SourceTest extends \PHPUnit_Framework_TestCase
{
	/** @var \PHPUnit_Framework_MockObject_MockObject|ILockEntity */
	private $lockEntity;
	
	
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|ILockEntity
	 */
	private function mockLock()
	{
		$this->lockEntity = $this->getMock(ILockEntity::class);
		
		$lock = $this->getMock(ILock::class);
		$lock->method('source')->willReturn($this->lockEntity);
		Scope::testSkeleton(ILock::class, $lock);
		
		return $this->lockEntity;
	}
	
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|Config
	 */
	private function mockConfig()
	{
		/** @var \PHPUnit_Framework_MockObject_MockObject|Config $config */
		$config = $this->getMockBuilder(Config::class)->disableOriginalConstructor()->getMock();
		Scope::instance()->setConfig($config);
		return $config;
	}
	
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|ISourceConnectorFactory
	 */
	private function mockFactory()
	{
		/** @var \PHPUnit_Framework_MockObject_MockObject|Config $factory */
		$factory = $this->getMock(ISourceConnectorFactory::class);
		Scope::testSkeleton(ISourceConnectorFactory::class, $factory);
		return $factory;
	}
	
	/**
	 * @return Source
	 */
	private function getSource()
	{
		$this->mockLock();
		return Scope::skeleton()->load(Source::class);
	}
	
	
	public function test_lock_LockCalled()
	{
		$source = $this->getSource();
		$this->lockEntity->expects($this->once())->method('lock');
		$source->lock();
	}
	
	public function test_unlock_UnlockCalled()
	{
		$source = $this->getSource();
		$this->lockEntity->expects($this->once())->method('unlock');
		$source->unlock();
	}
	
	public function test_connector_getConnectorOfFactoryCalled()
	{
		$config = $this->mockConfig();
		$factory = $this->mockFactory();
		
		$config->method('get')->willReturn('git');
		$factory->expects($this->once())->method('getConnector')->with('git');
		
		$source = $this->getSource();
		$source->connector();
	}
	
	public function test_connector_ResultIsReturnedFromFactory()
	{
		$config = $this->mockConfig();
		$factory = $this->mockFactory();
		$sourceConn = $this->getMock(ISourceConnector::class);
		
		$config->method('get')->willReturn('git');
		$factory->method('getConnector')->willReturn($sourceConn);
		
		$this->assertSame($sourceConn, $this->getSource()->connector());
	}
	
	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_connector_InvalidTypeConfigured_ThrowException()
	{
		$config = $this->mockConfig();
		
		$config->method('get')->willReturn('asd');
		
		$this->getSource()->connector();
	}
}