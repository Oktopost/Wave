<?php
namespace Wave\FileSystem;


use Objection\LiteObject;
use Objection\LiteSetup;


class JsonFileTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @param string $data
	 * @param string $name
	 * @return string
	 */
	private function createFileWith($data = '', $name = '/tmp/JsonFileTest.json')
	{
		if (file_exists($name))
			unlink($name);
		
		self::assertNotFalse(file_put_contents($name, $data));
		return $name;
	}
	
	/**
	 * @param string $data
	 * @param string $name
	 * @return JsonFile
	 */
	private function createJsonFile($data = '', $name = '/tmp/JsonFileTest.json')
	{
		$jf = new JsonFile();
		$jf->setTarget($this->createFileWith($data, $name));
		return $jf;
	}
	
	/**
	 * @return JsonFile
	 */
	private function createJsonFileWithInvalidFile()
	{
		$jf = new JsonFile();
		
		$fileName = $this->createFileWith('[]');
		$jf->setTarget($fileName);
		
		unlink($fileName);
		
		return $jf;
	}
	
	
	/**
	 * @expectedException \Wave\Exceptions\FileException
	 */
	public function test_setTarget_FileNotJson_ExceptionThrown()
	{
		(new JsonFile())->setTarget($this->createFileWith('[]', '/tmp/not_json_file_for_json_file_test.php'));
	}
	
	public function test_setTarget_ValidFile_NoError()
	{
		(new JsonFile())->setTarget($this->createFileWith('[]'));
	}
	
	
	/**
	 * @expectedException \Wave\Exceptions\FileException
	 */
	public function test_readFile_InvalidFile_ErrorThrown()
	{
		$jf = $this->createJsonFileWithInvalidFile();
		$jf->readFile();
	}
	
	public function test_readFile_ValidFile_DataReturned()
	{
		$data = [
			'a' => 12,
			'b' => [1, 2]
		];
		
		$jf = $this->createJsonFile(json_encode($data, JSON_PRETTY_PRINT));
		
		self::assertEquals($data, $jf->readFile());
	}
	
	
	/**
	 * @expectedException \Wave\Exceptions\FileException
	 */
	public function test_loadFile_InvalidFile_ErrorThrown()
	{
		$jf = $this->createJsonFileWithInvalidFile();
		$jf->loadFile(JsonFileTest_Help::class);
	}
	
	public function test_loadFile_ValidFile_LiteObjectReturned()
	{
		$jf = new JsonFile();
		
		$fileName = $this->createFileWith('[]');
		$jf->setTarget($fileName);
		
		self::assertInstanceOf(JsonFileTest_Help::class, $jf->loadFile(JsonFileTest_Help::class));
	}
	
	public function test_loadFile_ValidFile_ParametersLoaded()
	{
		$jf = new JsonFile();
		
		$data = [
			'Name' => 'name',
			'Args' => [
				'a' => 1,
				'b' => 2
			]
		];
		
		$fileName = $this->createFileWith(json_encode($data, JSON_PRETTY_PRINT));
		$jf->setTarget($fileName);
		$object = $jf->loadFile(JsonFileTest_Help::class);
		
		
		self::assertEquals($data, $object->toArray());
	}
	
	
	/**
	 * @expectedException \Wave\Exceptions\FileException
	 */
	public function test_loadAll_InvalidFile_ErrorThrown()
	{
		$jf = $this->createJsonFileWithInvalidFile();
		$jf->loadAll(JsonFileTest_Help::class);
	}
	
	public function test_loadAll_ValidFile_ArrayOfLiteObjectsReturned()
	{
		$jf = new JsonFile();
		
		$fileName = $this->createFileWith('[[],[]]');
		$jf->setTarget($fileName);
		
		$result = $jf->loadAll(JsonFileTest_Help::class);
		
		self::assertTrue(is_array($result));
		self::assertCount(2, $result);
		
		self::assertInstanceOf(JsonFileTest_Help::class, $result[0]);
		self::assertInstanceOf(JsonFileTest_Help::class, $result[1]);
	}
	
	public function test_loadAll_ValidFile_ParametersLoaded()
	{
		$jf = new JsonFile();
		
		$data = [
			[
				'Name' => 'name',
				'Args' => [
					'a' => 1,
					'b' => 2
				]
			],
			[
				'Name' => 'name 2',
				'Args' => [
					'some arg' => 1,
					0 => 'value'
				]
			]
		];
		
		$fileName = $this->createFileWith(json_encode($data, JSON_PRETTY_PRINT));
		$jf->setTarget($fileName);
		$objects = $jf->loadAll(JsonFileTest_Help::class);
		
		
		self::assertEquals($data, LiteObject::allToArray($objects));
	}
	
	
	public function test_save_DataSaved()
	{
		$object = new JsonFileTest_Help();
		$object->Name = 'abc';
		$object->Args = ['a' => 'b'];
		
		$jf = $this->createJsonFile('', '/tmp/JsonFileTest.json');
		$jf->save($object);
		
		self::assertEquals(
			json_encode($object->toArray(), JSON_PRETTY_PRINT), 
			file_get_contents('/tmp/JsonFileTest.json'));
	}
	
	
	public function test_saveAll_NoObjects_EmptyArraySaved()
	{
		$jf = $this->createJsonFile('', '/tmp/JsonFileTest.json');
		$jf->saveAll([]);
		
		self::assertEquals('[]', file_get_contents('/tmp/JsonFileTest.json'));
	}
	
	public function test_saveAll_HasObjects_DataSavedCorrectly()
	{
		$objectA = new JsonFileTest_Help();
		$objectA->Name = 'abc';
		$objectA->Args = ['a' => 'b'];
		
		$objectB = new JsonFileTest_Help();
		$objectB->Name = 'some_value';
		$objectB->Args = ['a' => 'b', 1 => 'abasd'];
		
		$jf = $this->createJsonFile('', '/tmp/JsonFileTest.json');
		$jf->saveAll([$objectA, $objectB]);
		
		self::assertEquals(
			json_encode(
				LiteObject::allToArray([$objectA, $objectB]), 
				JSON_PRETTY_PRINT
			), 
			file_get_contents('/tmp/JsonFileTest.json'));
	}
}


/**
 * @property string $Name
 * @property array $Args
 */
class JsonFileTest_Help extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'Name'	=> LiteSetup::createString(),
			'Args'	=> LiteSetup::createArray()
		];
	}
}