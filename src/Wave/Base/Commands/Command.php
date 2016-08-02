<?php
namespace Wave\Base\Commands;


use Wave\Enum\CommandType;
use Wave\Enum\CommandState;

use Objection\LiteSetup;
use Objection\LiteObject;


/**
 * @property string $ID
 * @property string $Type
 * @property string $State
 * @property int $Priority
 */
abstract class Command extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'ID'		=> uniqid(),
			'Type'		=> LiteSetup::createEnum(CommandType::class),
			'State'		=> LiteSetup::createEnum(CommandState::class, CommandState::IDLE),
			'Priority'	=> LiteSetup::createInt()
		];
	}
}