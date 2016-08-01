<?php
namespace Wave\Objects;


use Objection\LiteSetup;
use Objection\Enum\AccessRestriction;


/**
 * @property Package $Deployed
 */
class RemoteState extends StagingState
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		$setup = [
			'Deployed'	=> LiteSetup::createInstanceOf(Package::class, AccessRestriction::NO_SET)
		];
		
		return array_merge(
			parent::_setup(),
			$setup	
		);
	}
	
	
	/**
	 * @param Package|string $packageName
	 */
	public function setDeployed($packageName)
	{
		if ($packageName instanceof Package)
		{
			$this->_p->Deployed = $this->get($packageName->Name);
		}
		else
		{
			$this->_p->Deployed = $this->get($packageName);
		}
	}
	
	/**
	 * @return bool
	 */
	public function hasDeployed()
	{
		return !is_null($this->Deployed);
	}
}