<?php
namespace Wave\FileSystem\Data;


use Wave\Base\FileSystem\Data\IServerState;
use Wave\Objects\RemoteState;
use Wave\Exceptions\WaveException;


class SyncedServerStateTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|IServerState
	 */
	private function mockServerState()
	{
		return $this->getMock(IServerState::class);
	}
	
	
	public function test_setLocalServerState_ReturnSelf()
	{
		$s = new SyncedServerState();
		self::assertSame($s, $s->setLocalServerState($this->mockServerState()));
	}
	
	
	public function test_setRemoteServerState_ReturnSelf()
	{
		$s = new SyncedServerState();
		self::assertSame($s, $s->setRemoteServerState($this->mockServerState()));
	}
	
	
	public function test_load_LoadCalledOnRemote()
	{
		$s = new SyncedServerState();
		
		$state = $this->mockServerState();
		$s->setRemoteServerState($state);
		
		$state->expects($this->once())->method('load');
		
		$s->load();
	}
	
	public function test_load_RemoteResultReturned()
	{
		$s = new SyncedServerState();
		
		$state = $this->mockServerState();
		$s->setRemoteServerState($state);
		
		$state->method('load')->willReturn(12);
		
		self::assertEquals(12, $s->load());
	}
	
	public function test_save_SaveOnLocalCalled()
	{
		$s = new SyncedServerState();

		$local = $this->mockServerState();
		$s->setLocalServerState($local);
		$s->setRemoteServerState($this->mockServerState());
		
		$local->expects($this->once())->method('save');
		
		$s->save(new RemoteState());
	}
	
	public function test_save_SaveOnRemoteCalled()
	{
		$s = new SyncedServerState();

		$remote = $this->mockServerState();
		$s->setLocalServerState($this->mockServerState());
		$s->setRemoteServerState($remote);
		
		$remote->expects($this->once())->method('save');
		
		$s->save(new RemoteState());
	}
	
	public function test_save_CorrectValuePassedToMethods()
	{
		$s = new SyncedServerState();
		$state = new RemoteState();
		
		$local = $this->mockServerState();
		$remote = $this->mockServerState();
		$s->setLocalServerState($local);
		$s->setRemoteServerState($remote);
		
		$local->expects($this->once())->method('save')->with($state);
		$remote->expects($this->once())->method('save')->with($state);
		
		$s->save(new RemoteState());
	}
	
	public function test_save_ErrorThrownByLocalState_RemoteNotUpdate()
	{
		$s = new SyncedServerState();
		$state = new RemoteState();
		
		$local = $this->mockServerState();
		$remote = $this->mockServerState();
		$s->setLocalServerState($local);
		$s->setRemoteServerState($remote);
		
		$local->method('save')->willThrowException(new WaveException('NO'));
		$remote->expects($this->never())->method('save')->with($state);
		
		try
		{
			$s->save(new RemoteState());
		}
		catch (WaveException $e) {}
	}
	
	public function test_save_ErrorThrownByRemoteState_LocalStateReset()
	{
		$s = new SyncedServerState();
		$prevState = new RemoteState();
		
		$local = $this->mockServerState();
		$remote = $this->mockServerState();
		$s->setLocalServerState($local);
		$s->setRemoteServerState($remote);
		
		$local->method('load')->willReturn($prevState);
		$remote->method('save')->willThrowException(new WaveException('NO'));
		$local->expects(self::at(2))->method('save')->with($prevState);
		
		try
		{
			$s->save(new RemoteState());
		}
		catch (WaveException $e) {}
	}

	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_save_ErrorThrownByRemoteState_ErrorThrownBySyncedObject()
	{
		$s = new SyncedServerState();
		
		$local = $this->mockServerState();
		$remote = $this->mockServerState();
		$s->setLocalServerState($local);
		$s->setRemoteServerState($remote);
		
		$local->method('load')->willReturn(new RemoteState());
		$remote->method('save')->willThrowException(new WaveException('NO'));
		
		$s->save(new RemoteState());
	}
}