<?php
namespace Wave\Commands\Types;


use Wave\Enum\CommandType;
use Wave\Base\Commands\Command;

use Objection\LiteSetup;


/**
 * @property string $Version
 * @property string $BuildTarget
 */
class BuildCommand extends Command
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		$setup = [
			'Version'		=> LiteSetup::createString(),
			'BuildTarget'	=> LiteSetup::createString()
		];
		
		return array_merge(
			parent::_setup(),
			$setup
		);
	}
	
	
	public function __construct() 
	{
		parent::__construct();
		$this->_p->Type = CommandType::BUILD;
	}
}