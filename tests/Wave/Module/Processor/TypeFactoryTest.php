<?php
namespace Wave\Module\Processor;


use Wave\Enum\CommandType;
use Wave\Module\Processor\TypeProcessors;


class TypeFactoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_get_InvalidTypePassed_ErrorThrown()
	{
		(new TypeFactory())->get('Invalid_Type');
	}
	
	public function test_get_Clean_CleanObjectReturned()
	{
		self::assertInstanceOf(TypeProcessors\CleanProcessor::class, (new TypeFactory())->get(CommandType::CLEAN));
	}
	
	public function test_get_Build_BuildObjectReturned()
	{
		self::assertInstanceOf(TypeProcessors\BuildProcessor::class, (new TypeFactory())->get(CommandType::BUILD));
	}
	
	public function test_get_Stage_StageObjectReturned()
	{
		self::assertInstanceOf(TypeProcessors\StageProcessor::class, (new TypeFactory())->get(CommandType::STAGE));
	}
	
	public function test_get_Deploy_DeployObjectReturned()
	{
		self::assertInstanceOf(TypeProcessors\DeployProcessor::class, (new TypeFactory())->get(CommandType::DEPLOY));
	}
	
	public function test_get_Update_UpdateObjectReturned()
	{
		self::assertInstanceOf(TypeProcessors\UpdateProcessor::class, (new TypeFactory())->get(CommandType::UPDATE));
	}
}
