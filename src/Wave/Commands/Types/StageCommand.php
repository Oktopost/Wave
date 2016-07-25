<?php
namespace Wave\Commands\Types;


use Wave\Enum\CommandType;
use Wave\Base\Commands\Command;

use Objection\LiteSetup;


/**
 * @property string $Version
 * @property string $BuildTarget
 * @property array $Servers
 */
class StageCommand extends Command
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		$setup = [
			'Version'		=> LiteSetup::createString(),
			'BuildTarget'	=> LiteSetup::createString(),
			'Servers'		=> LiteSetup::createArray()
		];
		
		return array_merge(
			parent::_setup(),
			$setup
		);
	}
	
	
	public function __construct() 
	{
		parent::__construct();
		$this->_p->Type = CommandType::STAGE;
	}
}