<?php
namespace Wave;


use Wave\Source\Git\GitSource;
use Wave\Source\SourceConnectorFactory;


class SourceManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_get_InvalidType_ErrorThrown()
	{
		(new SourceConnectorFactory())->getConnector('invalid');
	}
	
	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_get_SvnType_ErrorThrown()
	{
		(new SourceConnectorFactory())->getConnector('svn');
	}
	
	public function test_get_GitType_GitSourceReturned()
	{
		$manager = (new SourceConnectorFactory())->getConnector('git');
		self::assertInstanceOf(GitSource::class, $manager);
	}
}