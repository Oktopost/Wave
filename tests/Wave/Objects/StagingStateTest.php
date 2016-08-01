<?php
namespace Wave\Objects;


class StagingStateTest extends \PHPUnit_Framework_TestCase
{
	public function test_has_Found_ReturnTrue()
	{
		$p = Package::create('a', 'b');
		
		$rs = new StagingState();
		$rs->Staged[] = $p;
		
		$this->assertTrue($rs->has($p->Name));
	}
	
	public function test_has_NotFound_ReturnFalse()
	{
		$p = Package::create('a', 'b');
		
		$rs = new StagingState();
		$rs->Staged[] = $p;
		
		$this->assertFalse($rs->has('n'));
	}
	
	
	public function test_get_Found_ReturnPackage()
	{
		$p = Package::create('a', 'b');
		
		$rs = new StagingState();
		$rs->Staged[] = $p;
		
		$this->assertSame($p, $rs->get($p->Name));
	}
	
	public function test_get_NotFound_ReturnNull()
	{
		$p = Package::create('a', 'b');
		
		$rs = new StagingState();
		$rs->Staged[] = $p;
		
		$this->assertNull($rs->get('n'));
	}
}