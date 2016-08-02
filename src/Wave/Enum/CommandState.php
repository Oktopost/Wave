<?php
namespace Wave\Enum;


class CommandState
{
	use \Objection\TEnum;
	
	
	const IDLE		= 'idle';
	const PAUSED	= 'paused';
	const RUNNING	= 'running';
}