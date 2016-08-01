<?php
namespace Wave\Objects;


use Objection\LiteSetup;
use Objection\LiteObject;


/**
 * @property Package[] $Staged
 */
class StagingState extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'Staged' => LiteSetup::createArray([])
		];
	}
	
	
	/**
	 * @param string $packageName
	 * @return bool
	 */
	public function has($packageName)
	{
		return !is_null($this->get($packageName));
	}
	
	/**
	 * @param string $packageName
	 * @return Package|null
	 */
	public function get($packageName)
	{
		foreach ($this->Staged as $package)
		{
			if ($package->Name == $packageName)
				return $package;
		}
		
		return null;
	}
}