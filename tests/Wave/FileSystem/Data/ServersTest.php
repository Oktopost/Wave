<?php
namespace Wave\FileSystem\Data;


use Wave\Base\FileSystem\IFileAccess;
use Wave\Objects\Server;


class ServersTest extends \PHPUnit_Framework_TestCase
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
		$servers = new Servers();
		self::assertSame($servers, $servers->setFileAccess($this->mockFileAccess()));
	}
	
	
	public function test_load_FileEmpty_ReturnEmptyArray()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('');
		
		$servers = (new Servers())->setFileAccess($fileAccess);
		self::assertEquals([], $servers->load());
	}
	
	public function test_load_HaveData_DataParsed()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('[{"Name":"a"},{"Name":"d"}]');
		
		$servers = (new Servers())->setFileAccess($fileAccess);
		$result = $servers->load();
		
		self::assertCount(2, $result);
		self::assertInstanceOf(Server::class, $result[0]);
		self::assertInstanceOf(Server::class, $result[1]);
		self::assertEquals('a', $result[0]->Name);
		self::assertEquals('d', $result[1]->Name);
	}
	
	
	public function test_save_EmptyArray_EmptyArraySaved()
	{
		$fileAccess = $this->mockFileAccess();
		$servers = (new Servers())->setFileAccess($fileAccess);
		
		$fileAccess
			->expects($this->once())
			->method('writeAll')
			->with('[]');
		
		$servers->save([]);
	}
	
	public function test_save_HaveData_EmptyArraySaved()
	{
		$fileAccess = $this->mockFileAccess();
		$servers = (new Servers())->setFileAccess($fileAccess);
		
		$server1 = new Server();
		$server1->Name = 'a';
		
		$server2 = new Server();
		$server2->Name = 'a';
		
		$fileAccess
			->expects($this->once())
			->method('writeAll')
			->with(json_encode([$server1->toArray(), $server2->toArray()], JSON_PRETTY_PRINT));
		
		$servers->save([$server1, $server2]);
	}
}