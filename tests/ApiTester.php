<?php 

use Rea\Entities\User as User;

/**
* Class with basic methods to test API
*/
abstract class ApiTester extends TestCase
{
	const BASE_URL = 'http://rea.app';
	const ENTITIES_PATH = 'Rea\Entities\\';
	protected $times = 1;

	/*function __construct()
	{
		# code...
	}*/

	public function setUp()
	{
		parent::setUp();
		Artisan::call('migrate:refresh');
		Artisan::call('db:seed');
	}

	protected function times($count = 1)
	{
		$this->times = $count;
		return $this;
	}

	protected function make($type, $fields = [])
	{
		while ($this->times--) 
		{
			$stub = array_merge($this->getStub(), $fields);
			$type = self::ENTITIES_PATH.$type;
			$model = new $type;
			$model->create();
		}
	}

	protected function getJson($uri, $method = 'GET', $params = [])
	{
		/*$res = $this->call($method, self::BASE_URL.$uri, $params)->getContent();
		var_dump($res);
		return $res;*/
		return json_decode($this->call($method, self::BASE_URL.$uri, $params)->getContent());
	}

	protected function assertObjectHasAttributes()
	{
		$args = func_get_args();
		$object = array_shift($args);

		foreach ($args as $attribute)
		{
			$this->assertObjectHasAttribute($attribute, $object);
		}
	}

	protected function getStub()
	{
		throw new BadMethodCallException('Create your own getStub method to declare your fields');
	}
}