<?php
namespace Wave;


class ConfigTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @param string $fileName
	 * @return Config
	 */
	private function create($fileName = 'test.ini')
	{
		return new Config(realpath(__DIR__ . '/_ConfigTest/' . $fileName));
	}
	
	
	public function test_getAll()
	{
		self::assertEquals(
			[
				'a'		=> '3',
				'key1'	=> 'some_value',
				'key2'	=> 'some_value_2'
			],
			$this->create()->getAll());
	}
	
	public function test_get()
	{
		self::assertEquals('3', $this->create()->get('a'));
		self::assertEquals('some_value', $this->create()->get('key1'));
		self::assertEquals('NOT FOUND', $this->create()->get('key3', 'NOT FOUND'));
		self::assertNull($this->create()->get('key4'));
	}
}