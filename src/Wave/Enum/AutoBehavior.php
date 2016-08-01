<?php
namespace Wave\Enum;


class AutoBehavior
{
	use \Objection\TEnum;
	
	
	const NONE		= 'none';
	const BUILD		= 'build';
	const STAGE		= 'stage';
	const DEPLOY	= 'deploy';
}