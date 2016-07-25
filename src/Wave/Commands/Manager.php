<?php
namespace Wave\Commands;


use Wave\Base\Commands\IQueue;
use Wave\Base\Commands\IManager;
use Wave\Base\Commands\ICommandCreator;


/**
 * @magic
 */
class Manager implements IManager
{
	private $file;
	
	/** @var IQueue */
	private $queue;
	
	/**
	 * @magic
	 * @var \Wave\Base\FileSystem\IFileLock
	 */
	private $fileLock;
	
	/**
	 * @magic
	 * @var \Wave\Base\Commands\ICommandCreator
	 */
	private $creator;
	
	/**
	 * @magic
	 * @var \Wave\Base\Commands\IQueueFile
	 */
	private $queueFile;
	
	
	/**
	 * @param string $file
	 * @return static
	 */
	public function setSource($file)
	{
		$this->fileLock->set($file);
		$this->file = $file;
		return $this;
	}
	
	/**
	 * @return ICommandCreator
	 */
	public function create()
	{
		$this->creator->setQueue($this->queue());
		return $this->creator;
	}
	
	/**
	 * @return IQueue
	 */
	public function queue()
	{
		return $this->queue;
	}
	
	public function load()
	{
		$this->queueFile->setFile($this->file);
		$this->queue = $this->queueFile->load();
	}
	
	public function save()
	{
		$this->queueFile->setFile($this->file);
		$this->queueFile->save($this->queue);
	}
	
	public function lock()
	{
		$this->fileLock->lock();
	}
	
	public function unlock()
	{
		$this->fileLock->unlock();
	}
}