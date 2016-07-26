<?php
namespace Wave\Objects;


class RemoteStateTest extends \PHPUnit_Framework_TestCase
{
	public function test_setDeployed_NoPackageFound_SetToNull()
	{
		$rs = new RemoteState();
		$rs->Staged[] = Package::create('a', 'b');
		$rs->setDeployed('n');
		
		$this->assertNull($rs->Deployed);
	}
	
	public function test_setDeployed_NoPackageFoundByPackage_SetToNull()
	{
		$rs = new RemoteState();
		$rs->Staged[] = Package::create('a', 'b');
		$rs->setDeployed(Package::create('a', 'n'));
		
		$this->assertNull($rs->Deployed);
	}
	
	public function test_setDeployed_ByName_PackageSet()
	{
		$p = Package::create('a', 'b');
		
		$rs = new RemoteState();
		$rs->Staged[] = $p;
		$rs->setDeployed($p->Name);
		
		$this->assertSame($p, $rs->Deployed);
	}
	
	public function test_setDeployed_ByPackage_PackageSet()
	{
		$p = Package::create('a', 'b');
		
		$rs = new RemoteState();
		$rs->Staged[] = $p;
		$rs->setDeployed($p);
		
		$this->assertSame($p, $rs->Deployed);
	}
	
	
	public function test_hasDeployed_No_ReturnFalse()
	{
		$rs = new RemoteState();
		$rs->Staged[] = Package::create('a', 'b');
		
		$this->assertFalse($rs->hasDeployed());
	}
	
	public function test_hasDeployed_Yes_ReturnTrue()
	{
		$p = Package::create('a', 'b');
		
		$rs = new RemoteState();
		$rs->Staged[] = $p;
		$rs->setDeployed($p->Name);
		
		$this->assertTrue($rs->hasDeployed());
	}
	
	
	public function test_has_Found_ReturnTrue()
	{
		$p = Package::create('a', 'b');
		
		$rs = new RemoteState();
		$rs->Staged[] = $p;
		
		$this->assertTrue($rs->has($p->Name));
	}
	
	public function test_has_NotFound_ReturnFalse()
	{
		$p = Package::create('a', 'b');
		
		$rs = new RemoteState();
		$rs->Staged[] = $p;
		
		$this->assertFalse($rs->has('n'));
	}
	
	
	public function test_get_Found_ReturnPackage()
	{
		$p = Package::create('a', 'b');
		
		$rs = new RemoteState();
		$rs->Staged[] = $p;
		
		$this->assertSame($p, $rs->get($p->Name));
	}
	
	public function test_get_NotFound_ReturnNull()
	{
		$p = Package::create('a', 'b');
		
		$rs = new RemoteState();
		$rs->Staged[] = $p;
		
		$this->assertNull($rs->get('n'));
	}
	
	
	public function test_hasGarbage_Found_ReturnTrue()
	{
		$rs = new RemoteState();
		$rs->Garbage[] = 'a';
		
		$this->assertTrue($rs->hasGarbage());
	}
	
	public function test_hasGarbage_NotFound_ReturnFalse()
	{
		$rs = new RemoteState();
		$rs->Garbage = [];
		
		$this->assertFalse($rs->hasGarbage());
	}
	
	
	public function test_getGarbageFiles_None_RetunrEmptyArray()
	{
		$rs = new RemoteState();
		$rs->Garbage[] = 'a/';
		$rs->Garbage[] = 'a/';
		
		$this->assertEmpty($rs->getGarbageFiles());
	}
	
	public function test_getGarbageFiles_Has_FilesReturned()
	{
		$rs = new RemoteState();
		$rs->Garbage[] = 'a/';
		$rs->Garbage[] = 'd';
		$rs->Garbage[] = 'n';
		
		$this->assertEquals(['d', 'n'], $rs->getGarbageFiles());
	}
	
	
	public function test_getGarbageFolders_None_RetunrEmptyArray()
	{
		$rs = new RemoteState();
		$rs->Garbage[] = 'a';
		$rs->Garbage[] = 'a';
		
		$this->assertEmpty($rs->getGarbageFolders());
	}
	
	public function test_getGarbageFolders_Has_FilesReturned()
	{
		$rs = new RemoteState();
		$rs->Garbage[] = 'a';
		$rs->Garbage[] = 'd/';
		$rs->Garbage[] = 'n/';
		
		$this->assertEquals(['d/', 'n/'], $rs->getGarbageFolders());
	}
}