<?php
namespace Wave\FileSystem;


use Wave\FileSystem\Data\Servers;
use Wave\FileSystem\Data\ServerState;
use Wave\FileSystem\Data\LocalPackages;


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