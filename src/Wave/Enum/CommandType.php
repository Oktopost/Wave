<?php
namespace Wave\Enum;


class CommandType
{
	use \Objection\TEnum;
	
	
	const BUILD		= 'build';
	const STAGE		= 'stage';
	const DEPLOY	= 'deploy';
	const CLEAN		= 'clean';
	const UPDATE	= 'update';
	
	
	const PRIORITY = 
	[
		self::BUILD		=> 5,
		self::STAGE		=> 5,
		self::DEPLOY	=> 5,
		self::CLEAN		=> 1,
		self::UPDATE	=> 10
	];
}