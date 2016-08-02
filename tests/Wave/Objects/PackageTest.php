<?php
namespace Wave\Objects;


class PackageTest extends \PHPUnit_Framework_TestCase
{
	public function test_touch_TimestampUpdated()
	{
		$p = new Package();
		
		$p->Timestamp = 12;
		$p->touch();
		
		self::assertEquals(time(), $p->Timestamp, '', 1);
	}
	
	
	public function test_create_PackageReturned()
	{
		self::assertInstanceOf(Package::class, Package::create('a', 'b'));
	}
	
	public function test_create_VersionSet()
	{
		self::assertEquals('a', Package::create('a', 'b')->Version);
	}
	
	public function test_create_BuildSet()
	{
		self::assertEquals('b', Package::create('a', 'b')->BuildTarget);
	}
	
	public function test_create_TimestampSet()
	{
		self::assertEquals(time(), Package::create('a', 'b')->Timestamp, '', 1);
	}
	
	public function test_create_NameSet()
	{
		self::assertEquals('b-a', Package::create('a', 'b')->Name);
	}
}