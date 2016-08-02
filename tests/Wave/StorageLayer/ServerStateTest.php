<?php
namespace Wave\StorageLayer;


use Wave\Base\FileSystem\IFileAccess;
use Wave\Objects\Package;
use Wave\Objects\RemoteState;
use Wave\Objects\StagingState;


class ServerStateTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|IFileAccess
	 */
	private function mockFileAccess()
	{
		return $this->getMock(IFileAccess::class);
	}
	
	
	public function test_setFileAccess_ReturnSelf()
	{
		$server = new ServerState();
		self::assertSame($server, $server->setFileAccess($this->mockFileAccess()));
	}
	
	
	public function test_load_FileEmpty_RemoteStateObjectReturned()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('');
		
		$server = (new ServerState())->setFileAccess($fileAccess);
		self::assertInstanceOf(RemoteState::class, $server->load());
	}
	
	public function test_load_FileEmpty_ObjectIsEmpty()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('');
		
		$server = (new ServerState())->setFileAccess($fileAccess);
		$result = $server->load();
		
		self::assertEmpty($result->Staged);
		self::assertNull($result->Deployed);
	}
	
	public function test_load_FileNotEmpty_PackageLoaded()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('{"packages":[{"Name":"a"}, {"Name":"b"}],"deployed":"b"}');
		
		$server = (new ServerState())->setFileAccess($fileAccess);
		$result = $server->load();
		
		self::assertCount(2, $result->Staged);
		self::assertEquals('a', $result->Staged[0]->Name);
		self::assertEquals('b', $result->Staged[1]->Name);
		self::assertSame($result->Staged[1], $result->Deployed);
	}
	
	
	public function test_save_EmptyData_EmptyDataSetSaved()
	{
		$fileAccess = $this->mockFileAccess();
		$server = (new ServerState())->setFileAccess($fileAccess);
		
		$fileAccess
			->expects($this->once())
			->method('writeAll')
			->with(
				json_encode(
					[
						'packages' => []
					],
					JSON_PRETTY_PRINT
				));
		
		$server->save(new RemoteState());
	}
	
	public function test_save_HavePackages_PackagesSaved()
	{
		$fileAccess = $this->mockFileAccess();
		$server = (new ServerState())->setFileAccess($fileAccess);
		
		$package1 = new Package();
		$package1->Name = 'a';
		$package2 = new Package();
		$package2->Name = 'b';
		
		$state = new RemoteState();
		$state->Staged = [$package1, $package2];
		$state->setDeployed($package2);
		
		$fileAccess
			->expects($this->once())
			->method('writeAll')
			->with(
				json_encode(
					[
						'packages' => Package::allToArray([$package1, $package2]),
						'deployed' => $package2->Name
					],
					JSON_PRETTY_PRINT
				));
		
		$server->save($state);
	}
}
