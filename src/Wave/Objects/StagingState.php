<?php
namespace Wave\Objects;


use Objection\LiteSetup;
use Objection\LiteObject;


/**
 * @property Package[] $Staged
 * @property string[] $Garbage
 */
class StagingState extends LiteObject
{
	/**
	 * @param bool $isForFolders
	 * @return string[]
	 */
	private function getGarbage($isForFolders)
	{
		return array_values(array_filter(
			$this->Garbage,
			function($item)
				use ($isForFolders)
			{
				return (substr($item, -1) == '/') == $isForFolders;
			}
		));
	}
	
	
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'Staged'		=> LiteSetup::createArray([]),
			'Garbage'		=> LiteSetup::createArray([])
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
	
	/**
	 * @return bool
	 */
	public function hasGarbage()
	{
		return (bool)$this->Garbage;
	}
	
	/**
	 * @return string[]
	 */
	public function getGarbageFiles()
	{
		return $this->getGarbage(false);
	}
	
	/**
	 * @return string[]
	 */
	public function getGarbageFolders()
	{
		return $this->getGarbage(true);
	}
}