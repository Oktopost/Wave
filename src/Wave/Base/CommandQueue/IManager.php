<?php
namespace Wave\Base\CommandQueue;


use Wave\Exceptions\ModifyingWithoutLockException;


/**
 * @skeleton
 */
interface IManager
{
	/**
	 * @return Command[]
	 */
	public function load();
	
	/**
	 * @param Command $command
	 * @throws ModifyingWithoutLockException
	 */
	public function add(Command $command);
	
	/**
	 * @param Command[] $commands
	 * @throws ModifyingWithoutLockException
	 */
	public function addAll(array $commands);
	
	/**
	 * @param Command $command
	 * @throws ModifyingWithoutLockException
	 */
	public function remove(Command $command);
	
	/**
	 * @param Command $command
	 * @throws ModifyingWithoutLockException
	 */
	public function update(Command $command);
	
	/**
	 * @throws ModifyingWithoutLockException
	 */
	public function save();
	
	/**
	 * @param bool $blocking
	 * @return bool
	 */
	public function lock($blocking = false);
	
	public function unlock();
}