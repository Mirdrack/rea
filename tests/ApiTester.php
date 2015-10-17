<?php 

use Faker\Factory as Faker;

/**
* Class with basic methods to test API
*/
abstract class ApiTester extends TestCase
{
	const ENTITIES_PATH = 'Rea\Entities\\';
	
	protected $times = 1;
	protected $fake;

	function __construct()
	{
		$this->fake = Faker::create();
	}

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
			$model->create($stub);
		}
	}

	protected function getJson($uri, $method = 'GET', $params = [])
	{
		/* 
		Use this if you need to dump the response
		*/
		$res = $this->call($method, $uri, $params)->getContent();
		dd($res);
		return $res;
		return json_decode($this->call($method, $uri, $params)->getContent());
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