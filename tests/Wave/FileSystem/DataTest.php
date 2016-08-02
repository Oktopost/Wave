<?php
namespace Wave\FileSystem;


use Wave\FileSystem\Data\Servers;
use Wave\FileSystem\Data\ServerState;
use Wave\FileSystem\Data\LocalPackages;


class DataTest extends \PHPUnit_Framework_TestCase
{
	public function test_localPackages()
	{
		$this->assertInstanceOf(LocalPackages::class, (new Data())->localPackages());
	}
	
	public function test_localServerState()
	{
		$this->assertInstanceOf(ServerState::class, (new Data())->localServerState('a'));
	}
	
	public function test_servers()
	{
		$this->assertInstanceOf(Servers::class, (new Data())->servers());
	}
}