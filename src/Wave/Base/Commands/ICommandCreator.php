<?php
namespace Wave\Base\Commands;


/**
 * @skeleton
 */
interface ICommandCreator
{
	/**
	 * @param IQueue $queue
	 * @return static
	 */
	public function setQueue(IQueue $queue);
	
	/**
	 * @return Command
	 */
	public function clean();
	
	/**
	 * @param string $version
	 * @param string $targetBuild
	 * @return Command
	 */
	public function build($version, $targetBuild);
	
	/**
	 * @param string $version
	 * @param string $targetBuild
	 * @param array $servers
	 * @return Command
	 */
	public function stage($version, $targetBuild, array $servers);
	
	/**
	 * @param string $version
	 * @param string $targetBuild
	 * @param array $servers
	 * @return Command
	 */
	public function deploy($version, $targetBuild, array $servers);
}