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
	
	
	public function test_hasGarbage_Found_ReturnTrue()
	{
		$rs = new StagingState();
		$rs->Garbage[] = 'a';
		
		$this->assertTrue($rs->hasGarbage());
	}
	
	public function test_hasGarbage_NotFound_ReturnFalse()
	{
		$rs = new StagingState();
		$rs->Garbage = [];
		
		$this->assertFalse($rs->hasGarbage());
	}
	
	
	public function test_getGarbageFiles_None_RetunrEmptyArray()
	{
		$rs = new StagingState();
		$rs->Garbage[] = 'a/';
		$rs->Garbage[] = 'a/';
		
		$this->assertEmpty($rs->getGarbageFiles());
	}
	
	public function test_getGarbageFiles_Has_FilesReturned()
	{
		$rs = new StagingState();
		$rs->Garbage[] = 'a/';
		$rs->Garbage[] = 'd';
		$rs->Garbage[] = 'n';
		
		$this->assertEquals(['d', 'n'], $rs->getGarbageFiles());
	}
	
	
	public function test_getGarbageFolders_None_RetunrEmptyArray()
	{
		$rs = new StagingState();
		$rs->Garbage[] = 'a';
		$rs->Garbage[] = 'a';
		
		$this->assertEmpty($rs->getGarbageFolders());
	}
	
	public function test_getGarbageFolders_Has_FilesReturned()
	{
		$rs = new StagingState();
		$rs->Garbage[] = 'a';
		$rs->Garbage[] = 'd/';
		$rs->Garbage[] = 'n/';
		
		$this->assertEquals(['d/', 'n/'], $rs->getGarbageFolders());
	}
}