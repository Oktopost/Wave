<?php
namespace Wave\StorageLayer;


use Wave\Base\FileSystem\IFileAccess;
use Wave\Objects\Package;
use Wave\Objects\StagingState;


class LocalPackagesTest extends \PHPUnit_Framework_TestCase
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
		$local = new LocalPackages();
		self::assertSame($local, $local->setFileAccess($this->mockFileAccess()));
	}
	
	
	public function test_load_FileEmpty_StagingStateObjectReturned()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('');
		
		$local = (new LocalPackages())->setFileAccess($fileAccess);
		self::assertInstanceOf(StagingState::class, $local->load());
	}
	
	public function test_load_FileEmpty_ObjectIsEmpty()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('');
		
		$local = (new LocalPackages())->setFileAccess($fileAccess);
		self::assertEmpty($local->load()->Staged);
	}
	
	public function test_load_FileNotEmpty_PackageLoaded()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('{"packages":[{"Name":"a"}, {"Name":"b"}]}');
		
		$local = (new LocalPackages())->setFileAccess($fileAccess);
		$result = $local->load();
		
		self::assertCount(2, $result->Staged);
		self::assertEquals('a', $result->Staged[0]->Name);
		self::assertEquals('b', $result->Staged[1]->Name);
	}
	
	
	public function test_save_EmptyArray_EmptyDataSetSaved()
	{
		$fileAccess = $this->mockFileAccess();
		$local = (new LocalPackages())->setFileAccess($fileAccess);
		
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
		
		$local->save(new StagingState());
	}
	
	public function test_save_HavePackages_PackagesSaved()
	{
		$fileAccess = $this->mockFileAccess();
		$local = (new LocalPackages())->setFileAccess($fileAccess);
		
		$package1 = new Package();
		$package1->Name = 'a';
		$package2 = new Package();
		$package2->Name = 'b';
		
		$state = new StagingState();
		$state->Staged = [$package1, $package2];
		
		$fileAccess
			->expects($this->once())
			->method('writeAll')
			->with(
				json_encode(
					[
						'packages' => Package::allToArray([$package1, $package2])
					],
					JSON_PRETTY_PRINT
				));
		
		$local->save($state);
	}
}
