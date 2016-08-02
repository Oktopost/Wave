<?php
namespace Wave\Commands;


use Wave\Scope;
use Wave\Enum\CommandType;
use Wave\Base\Commands\ICommandFactory;

use Wave\Commands\Types\BuildCommand;
use Wave\Commands\Types\CleanCommand;
use Wave\Commands\Types\StageCommand;
use Wave\Commands\Types\DeployCommand;


class CommandFactoryTest extends \PHPUnit_Framework_TestCase
{
	public function test_skeleton_Configured()
	{
		self::assertInstanceOf(CommandFactory::class, Scope::skeleton(ICommandFactory::class));
	}
	
	
	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_get_UndefinedType_ThrowException()
	{
		(new CommandFactory())->get('invalid');
	}
	
	
	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_get_Update_ThrowException()
	{
		(new CommandFactory())->get(CommandType::UPDATE);
	}
	
	public function test_get_Build()
	{
		self::assertInstanceOf(BuildCommand::class, (new CommandFactory())->get(CommandType::BUILD));
	}
	
	public function test_get_Clean()
	{
		self::assertInstanceOf(CleanCommand::class, (new CommandFactory())->get(CommandType::CLEAN));
	}
	
	public function test_get_Stage()
	{
		self::assertInstanceOf(StageCommand::class, (new CommandFactory())->get(CommandType::STAGE));
	}
	
	public function test_get_Deploy()
	{
		self::assertInstanceOf(DeployCommand::class, (new CommandFactory())->get(CommandType::DEPLOY));
	}
}