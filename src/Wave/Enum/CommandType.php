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
}