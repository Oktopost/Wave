<?php
namespace Wave\StorageLayer;


class DataTest extends \PHPUnit_Framework_TestCase
{
	public function test_localPackages()
	{
		self::assertInstanceOf(LocalPackages::class, (new Data())->localPackages());
	}
	
	public function test_localServerState()
	{
		self::assertInstanceOf(ServerState::class, (new Data())->localServerState('a'));
	}
	
	public function test_servers()
	{
		self::assertInstanceOf(Servers::class, (new Data())->servers());
	}
}