<?php
namespace Wave\Base\CommandQueue;


use Wave\Enum\CommandType;

use Objection\LiteSetup;
use Objection\LiteObject;


/**
 * @property int $ID
 * @property string $Type
 * @property int $Priority
 * @property string $Arguments
 */
class Command extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'ID'		=> LiteSetup::createInt(null),
			'Type'		=> LiteSetup::createEnum(CommandType::class),
			'Priority'	=> LiteSetup::createInt(),
			'Arguments'	=> LiteSetup::createArray()
		];
	}
	
	
	/**
	 * @param int $newCommandPriority
	 */
	public function adjustPriority($newCommandPriority)
	{
		if ($this->Priority <= $newCommandPriority)
			$this->Priority++;
	}
}