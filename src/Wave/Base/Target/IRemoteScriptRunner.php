<?php
namespace Wave\Base\Target;


use Wave\Objects\Package;


/**
 * @skeleton
 */
interface IRemoteScriptRunner
{
	/**
	 * @param IServerConnector $connector
	 * @param Package $package
	 */
	public function runPreStage(IServerConnector $connector, Package $package);
	
	/**
	 * @param IServerConnector $connector
	 * @param Package $package
	 */
	public function runPostStage(IServerConnector $connector, Package $package);
	
	/**
	 * @param IServerConnector $connector
	 * @param Package $package
	 */
	public function runPreDeploy(IServerConnector $connector, Package $package);
	
	/**
	 * @param IServerConnector $connector
	 * @param Package $package
	 */
	public function runPostDeploy(IServerConnector $connector, Package $package);
}