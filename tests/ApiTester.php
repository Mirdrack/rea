<?php 
/**
* Class with basic methods to test API
*/
class ApiTester extends TestCase
{
	const BASE_URL = 'http://rea.app';
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

	protected function getJson($uri)
	{
		return json_decode($this->call('GET', self::BASE_URL.$uri)->getContent());
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
}