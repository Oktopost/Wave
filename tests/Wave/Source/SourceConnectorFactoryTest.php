<?php
namespace Wave\Source;


use Wave\Config;
use Wave\Enum\SourceType;
use Wave\Scope;
use Wave\Source\Git\GitSource;


class SourceConnectorFactoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_getConnector_InvalidType_ErrorThrown()
	{
		$f = new SourceConnectorFactory();
		$f->getConnector('not_existing');
	}
	
	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_getConnector_SvnConnector_ErrorThrown()
	{
		$f = new SourceConnectorFactory();
		$f->getConnector(SourceType::SVN);
	}
	
	public function test_getConnector_GitConnector_GitSourceInstanceReturned()
	{
		/** @var Config $config */
		$config = $this->getMock(Config::class, [], [], '', false);
		Scope::instance()->setConfig($config);
		
		$f = new SourceConnectorFactory();
		self::assertInstanceOf(GitSource::class, $f->getConnector(SourceType::GIT));
	}
}