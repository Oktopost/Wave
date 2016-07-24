<?php
namespace Wave;


use Wave\Source\Git\GitSource;
use Wave\Source\SourceManagerFactory;


class SourceManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_get_InvalidType_ErrorThrown()
	{
		(new SourceManagerFactory())->get('invalid');
	}
	
	/**
	 * @expectedException \Wave\Exceptions\WaveException
	 */
	public function test_get_SvnType_ErrorThrown()
	{
		(new SourceManagerFactory())->get('svn');
	}
	
	public function test_get_GitType_GitSourceReturned()
	{
		$manager = (new SourceManagerFactory())->get('git');
		$this->assertInstanceOf(GitSource::class, $manager);
	}
}