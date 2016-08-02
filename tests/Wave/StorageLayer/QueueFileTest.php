<?php
namespace Wave\StorageLayer;


use Wave\Base\Commands\IQueue;
use Wave\Base\Commands\Command;
use Wave\Base\FileSystem\IFileAccess;

use Wave\Commands\Queue;
use Wave\Commands\Types\BuildCommand;
use Wave\Commands\Types\CleanCommand;
use Wave\Enum\CommandState;


class QueueFileTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|IFileAccess
	 */
	private function mockFileAccess()
	{
		return $this->getMock(IFileAccess::class);
	}
	
	
	public function test_setFileAccess_ReturnSelf()
	{
		$queueFile = new QueueFile();
		self::assertSame($queueFile, $queueFile->setFileAccess($this->mockFileAccess()));
	}
	
	
	public function test_load_QueueInstanceReturned()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('');
		
		$queueFile = (new QueueFile())->setFileAccess($fileAccess);
		self::assertInstanceOf(IQueue::class, $queueFile->load());
	}
	
	public function test_load_FileEmpty_ObjectIsEmpty()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('');
		
		$queueFile = (new QueueFile())->setFileAccess($fileAccess);
		self::assertEmpty($queueFile->load()->getAll());
	}
	
	public function test_load_FileNotEmpty_CommandsLoaded()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('[{"Type":"build"},{"Type":"clean"}]');
		
		$queueFile = (new QueueFile())->setFileAccess($fileAccess);
		$result = $queueFile->load();
		
		self::assertCount(2, $result->getAll());
		self::assertInstanceOf(Command::class, $result->getAll()[0]);
		self::assertInstanceOf(Command::class, $result->getAll()[1]);
	}
	
	public function test_load_CommandsLoadedAccordingToType()
	{
		$fileAccess = $this->mockFileAccess();
		$fileAccess->method('readAll')->willReturn('[{"Type":"build"},{"Type":"clean"}]');
		
		$queueFile = (new QueueFile())->setFileAccess($fileAccess);
		$result = $queueFile->load();
		
		self::assertInstanceOf(BuildCommand::class, $result->getAll()[0]);
		self::assertInstanceOf(CleanCommand::class, $result->getAll()[1]);
	}
	
	
	public function test_save_EmptyQueue()
	{
		$fileAccess = $this->mockFileAccess();
		$queueFile = (new QueueFile())->setFileAccess($fileAccess);
		
		$fileAccess
			->expects($this->once())
			->method('writeAll')
			->with('[]');
		
		$queueFile->save(new Queue());
	}
	
	public function test_save_QueueHaveCommands_PackagesSaved()
	{
		$fileAccess = $this->mockFileAccess();
		$queueFile = (new QueueFile())->setFileAccess($fileAccess);
		
		$command1 = new BuildCommand();
		$command1->Version = 'a';
		$command2 = new CleanCommand();
		$command2->State = CommandState::IDLE;
		
		$queue = new Queue();
		$queue->add($command1);
		$queue->add($command2);
		
		$fileAccess
			->expects($this->once())
			->method('writeAll')
			->with(
				json_encode(
					[
						$command1->toArray(),
						$command2->toArray()
					],
					JSON_PRETTY_PRINT
				));
		
		$queueFile->save($queue);
	}
}