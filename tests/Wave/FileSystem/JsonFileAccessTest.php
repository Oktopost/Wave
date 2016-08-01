<?php
namespace Wave\FileSystem;


use Wave\Base\FileSystem\IFileAccess;


class JsonFileAccessTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|IFileAccess
	 */
	private function mockFileAccess()
	{
		return $this->getMock(IFileAccess::class);
	}
	
	
	public function test_useFileAccess_ReturnSelf()
	{
		$access = new JsonFileAccess();
		
		self::assertSame($access, $access->useFileAccess($this->mockFileAccess()));
	}
	
	
	public function test_readAll_readAllOnFileAccessCalled()
	{
		$access = $this->mockFileAccess();
		$access->expects($this->once())->method('readAll')->with(true)->willReturn('');
		
		(new JsonFileAccess())->useFileAccess($access)->readAll(true);
	}
	
	public function test_readAll_DataParsed()
	{
		$access = $this->mockFileAccess();
		$access->method('readAll')->willReturn('{"a":"b"}');
		
		$result = (new JsonFileAccess())->useFileAccess($access)->readAll();
		
		self::assertEquals((object)['a' => 'b'], $result);
	}
	
	
	public function test_writeAll_writeAllOnAccessCalled()
	{
		$access = $this->mockFileAccess();
		$access->expects($this->once())->method('writeAll');
		
		(new JsonFileAccess())->useFileAccess($access)->writeAll([]);
	}
	
	public function test_writeAll_JsonEncodePassed()
	{
		$access = $this->mockFileAccess();
		$access->expects($this->once())->method('writeAll')->with('{"a":"b"}');
		
		(new JsonFileAccess())->useFileAccess($access)->writeAll(['a' => 'b'], false);
	}
	
	public function test_writeAll_PrettyFormatUsed_PrettyJsonPassed()
	{
		$access = $this->mockFileAccess();
		$access->expects($this->once())->method('writeAll')->with("{\n    \"a\": \"b\"\n}");
		
		(new JsonFileAccess())->useFileAccess($access)->writeAll(['a' => 'b'], true);
	}
}