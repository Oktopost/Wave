<?php
namespace Wave\Commands\Types;


use Wave\Enum\CommandType;
use Wave\Base\Commands\Command;


class CleanCommand extends Command
{
	public function __construct() 
	{
		parent::__construct();
		$this->_p->Type = CommandType::CLEAN;
	}
}