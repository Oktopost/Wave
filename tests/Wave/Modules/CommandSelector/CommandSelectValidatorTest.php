<?php
namespace Wave\Module\CommandSelector;


use Wave\Base\Module\CommandSelector\ICommandSelectValidator;
use Wave\Scope;
use Wave\Enum\CommandType;
use Wave\Base\Commands\IQueue;
use Wave\Base\Module\CommandSelector\ICommandTypeSelectValidator;
use Wave\Base\Module\CommandSelector\ICommandTypeSelectValidatorFactory;
use Wave\Commands\Types\StageCommand;


/**
 * @magic
 */
class CommandSelectValidatorTest extends \PHPUnit_Framework_TestCase
{
	/** @var \PHPUnit_Framework_MockObject_MockObject|ICommandTypeSelectValidatorFactory */
	private $factory;
	
	/** @var \PHPUnit_Framework_MockObject_MockObject|IQueue */
	private $queue;
	
	/** @var \PHPUnit_Framework_MockObject_MockObject|ICommandTypeSelectValidator */
	private $validator;
	
	
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|ICommandTypeSelectValidatorFactory
	 */
	private function mockFactory()
	{
		$factory = $this->getMock(ICommandTypeSelectValidatorFactory::class);
		Scope::testSkeleton(ICommandTypeSelectValidatorFactory::class, $factory);
		
		$factory
			->method('get')
			->willReturn($this->validator);
		
		return $factory;
	}
	
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|IQueue
	 */
	private function mockQueue()
	{
		return $this->getMock(IQueue::class);
	}
	
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|ICommandTypeSelectValidator
	 */
	private function mockValidator()
	{
		$validator = $this->getMock(ICommandTypeSelectValidator::class);
		$validator->method('setQueue')->willReturnSelf();
		return $validator;
	}
	
	/**
	 * @return CommandSelectValidator
	 */
	private function getCommandSelectValidator()
	{
		$a = Scope::skeleton()->load(CommandSelectValidator::class);
		$a->setQueue($this->mockQueue());
		return $a;
	}
	
	
	protected function setUp()
	{
		$this->validator	= $this->mockValidator();
		$this->queue		= $this->mockQueue();
		$this->factory		= $this->mockFactory();
	}
	
	
	public function test_skeleton()
	{
		Scope::testSkeleton()->clear();
		
		$this->mockFactory();
		$this->mockQueue();
		
		$this->assertInstanceOf(
			CommandSelectValidator::class, 
			Scope::skeleton(ICommandSelectValidator::class));
	}
	
	
	public function test_setQueue_ReturnSelf()
	{
		$a = $this->getCommandSelectValidator();
		$this->assertSame($a, $a->setQueue($this->queue));
	}
	
	
	public function test_canStart_GetOnFactoryCalledWithType()
	{
		$this->factory
			->expects($this->once())
			->method('get')
			->with(CommandType::STAGE)
			->willReturn($this->validator);
		
		$a = $this->getCommandSelectValidator();
		$a->canStart(new StageCommand());
	}
	
	public function test_canStart_QueuePassedToValidator()
	{
		$this->validator
			->expects($this->once())
			->method('setQueue')
			->with($this->queue)
			->willReturnSelf();
		
		$a = $this->getCommandSelectValidator();
		$a->canStart(new StageCommand());
	}
	
	public function test_canStart_CommandPassedToValidator()
	{
		$command = new StageCommand();
		$this->validator
			->expects($this->once())
			->method('canStart')
			->with($command);
		
		$a = $this->getCommandSelectValidator();
		$a->canStart($command);
	}
	
	public function test_canStart_ValidatorReturnFalse_ReturnFalse()
	{
		$this->validator
			->method('canStart')
			->willReturn(false);
		
		$a = $this->getCommandSelectValidator();
		$this->assertFalse($a->canStart(new StageCommand()));
	}
	
	public function test_canStart_ValidatorReturnTrue_ReturnTrue()
	{
		$this->validator
			->method('canStart')
			->willReturn(true);
		
		$a = $this->getCommandSelectValidator();
		$this->assertTrue($a->canStart(new StageCommand()));
	}
}