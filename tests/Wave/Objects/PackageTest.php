<?php
namespace Wave\Objects;


class PackageTest extends \PHPUnit_Framework_TestCase
{
	public function test_touch_TimestampUpdated()
	{
		$p = new Package();
		
		$p->Timestamp = 12;
		$p->touch();
		
		$this->assertEquals(time(), $p->Timestamp, '', 1);
	}
	
	
	public function test_create_PackageReturned()
	{
		$this->assertInstanceOf(Package::class, Package::create('a', 'b'));
	}
	
	public function test_create_VersionSet()
	{
		$this->assertEquals('a', Package::create('a', 'b')->Version);
	}
	
	public function test_create_BuildSet()
	{
		$this->assertEquals('b', Package::create('a', 'b')->BuildTarget);
	}
	
	public function test_create_TimestampSet()
	{
		$this->assertEquals(time(), Package::create('a', 'b')->Timestamp, '', 1);
	}
	
	public function test_create_NameSet()
	{
		$this->assertEquals('b-a', Package::create('a', 'b')->Name);
	}
}