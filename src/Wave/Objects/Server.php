<?php
namespace Wave\Objects;


use Wave\Enum\ServerType;
use Wave\Enum\AutoBehavior;

use Objection\LiteSetup;
use Objection\LiteObject;


/**
 * @property string $Name
 * @property string $IP
 * @property string $Auto
 * @property string $Type
 * @property string $StagingDir
 * @property string $DeploymentLinkDir
 */
class Server extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'Name'				=> LiteSetup::createString(),
			'IP'				=> LiteSetup::createString(null),
			'Auto'				=> LiteSetup::createEnum(AutoBehavior::class, AutoBehavior::NONE),
			'Type'				=> LiteSetup::createEnum(ServerType::class, ServerType::LOCAL),
			'StagingDir'		=> LiteSetup::createString(),
			'DeploymentLinkDir'	=> LiteSetup::createString(),
		];
	}
}