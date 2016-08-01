<?php
namespace Wave\Target\Connector;


use Wave\Base\FileSystem\IData;
use Wave\Base\FileSystem\IFileAccess;
use Wave\Base\FileSystem\ILocalFileAccess;

use Wave\Base\Target\ILocalStaging;
use Wave\FileSystem\Data\SyncedServerState;
use Wave\Objects\RemoteState;
use Wave\Scope;
use Wave\Config;
use Wave\Objects\Server;
use Wave\Objects\Package;


class LocalTest extends \PHPUnit_Framework_TestCase
{
	/** @var IFileAccess|\PHPUnit_Framework_MockObject_MockObject */
	private $fileAccess;
	
	/** @var ILocalFileAccess|\PHPUnit_Framework_MockObject_MockObject */
	private $localFileAccess;
	
	/** @var IData|\PHPUnit_Framework_MockObject_MockObject */
	private $data;
	
	
	private function mockAccess()
	{
		$this->localFileAccess = $this->getMock(ILocalFileAccess::class);
		$this->fileAccess = $this->getMock(IFileAccess::class);
		$this->data = $this->getMock(IData::class);
		
		$this->data->method('localServerState')->willReturn($this->fileAccess);
		
		Scope::testSkeleton(IData::class, $this->data);
		Scope::testSkeleton(ILocalFileAccess::class, $this->localFileAccess);
	}
	
	private function clean()
	{
		try {
			unlink(__DIR__ . '/_LocalTest/a.lnk');
		} catch (\PHPUnit_Framework_Error_Warning $e) {}
		
		if (is_dir(__DIR__ . '/_LocalTest/remote.staging/package'))
		{
			$path = __DIR__ . '/_LocalTest/remote.staging/package';
			exec("rm -r $path");
		}
	}
	
	
	protected function setUp()
	{
		$this->clean();
		$this->mockAccess();
	}

	protected function tearDown()
	{
		$this->clean();
	}
	

	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|Config
	 */
	private function mockConfig()
	{
		$config = $this->getMockBuilder(Config::class)->disableOriginalConstructor()->getMock();
		Scope::instance()->setConfig($config);
		return $config;
	}


	/**
	 * @param string $depDir
	 * @param string $stageDir
	 * @return Server
	 */
	private function createServer(
		$depDir = __DIR__ . '/_LocalTest/a.lnk', 
		$stageDir = __DIR__ . '/_LocalTest/remote.staging')
	{
		$server = new Server();
		$server->DeploymentLinkDir = $depDir;
		$server->StagingDir = $stageDir;
		return $server;
	}
	
	/**
	 * @param string $name
	 * @return Package
	 */
	private function createPackage($name = 'package')
	{
		$p = new Package();
		$p->Name = $name;
		return $p;
	}
	

	public function test_setServer_ReturnSelf()
	{
		$a = new Local();
		self::assertSame($a, $a->setup(new Server()));
	}
	
	
	public function test_deploy_SymbolicLinkCreated()
	{
		$server = $this->createServer();
		$package = $this->createPackage();
		
		$a = new Local();
		$a->setup($server);
		$a->deploy($package);
		
		self::assertTrue(is_link($server->DeploymentLinkDir));
	}
	
	public function test_deploy_SymbolicLinkHasCorrectPath()
	{
		$server = $this->createServer();
		$package = $this->createPackage();
		
		$a = new Local();
		$a->setup($server);
		$a->deploy($package);
		
		self::assertEquals(
			$server->StagingDir . '/' . $package->Name, 
			readlink($server->DeploymentLinkDir));
	}
	
	
	public function test_getServerStateObject_SyncedStateReturned()
	{
		$server = $this->createServer();
		
		$a = new Local();
		$a->setup($server);
		
		self::assertInstanceOf(SyncedServerState::class, $a->getServerStateObject());
	}
	
	public function test_getServerStateObject_ServerPAssedToDataInterface()
	{
		$server = $this->createServer();
		
		$a = new Local();
		$a->setup($server);
		
		$this->data->expects(self::once())->method('localServerState')->with($server);
		
		$a->getServerStateObject();
	}
	
	public function test_getServerStateObject_PathToServerFilePassed()
	{
		$server = $this->createServer();
		
		$a = new Local();
		$a->setup($server);
		
		$this->localFileAccess->expects(self::once())->method('setFilePath')
			->with($server->StagingDir . '/state.json');
		
		$a->getServerStateObject();
	}
	
	public function test_getServerStateObject_FileAccessPassedToSync()
	{
		$server = $this->createServer();
		
		$a = new Local();
		$a->setup($server);
		
		$this->fileAccess->expects(self::once())->method('writeAll');
		$this->localFileAccess->expects(self::once())->method('writeAll');
		
		$synced = $a->getServerStateObject();
		$synced->save(new RemoteState());
	}
	
	
	public function test_transfer_FolderCreated()
	{
		$staging = $this->getMock(ILocalStaging::class);
		$staging->method('getDirectoryForPackage')->willReturn(__DIR__ . '/_LocalTest/package');
		Scope::testSkeleton(ILocalStaging::class, $staging);
		
		$server = $this->createServer();
		$package = $this->createPackage();
		
		$a = new Local();
		$a->setup($server);
		
		$a->transferPackage($package);
		
		
		self::assertTrue(is_dir(__DIR__ . '/_LocalTest/remote.staging/package'));
		self::assertTrue(is_file(__DIR__ . '/_LocalTest/remote.staging/package/a'));
		self::assertTrue(is_dir(__DIR__ . '/_LocalTest/remote.staging/package/inr'));
		self::assertTrue(is_file(__DIR__ . '/_LocalTest/remote.staging/package/inr/b'));
	}
}
