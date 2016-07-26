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
}