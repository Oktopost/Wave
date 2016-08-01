<?php
namespace Wave\Enum;


class ServerType
{
	use \Objection\TEnum;
	
	
	const LOCAL		= 'local';
	const SSH		= 'ssh';
}