<?php

use Rea\Validators\StubValidator;

class UpdateUserValidatorTest extends ApiTester
{

	public function test_create_success()
	{
		$stub = new StubValidator( App::make('validator') );
		$this->assertTrue( $stub->with( $this->getValidCreateData() )->passes() );
	}
 
	public function test_create_failure()
	{
		$stub = new StubValidator( App::make('validator') );
		$this->assertFalse( $stub->with( $this->getInvalidCreateData() )->passes() );
		$this->assertEquals(3, count($stub->errors()));
		$this->assertInstanceOf('Illuminate\Support\MessageBag', $stub->errors());
	}
 
  	public function getValidCreateData()
  	{
    	return [
			'username' => 'philipbrown',
			'email' => 'name@domain.com',
			'password' => 'totes_secure_password',
			'password_confirmation' => 'totes_secure_password'
    	];
  	}
 
  	public function getInvalidCreateData()
  	{
    	return [
			'name' => '<@)}}}><{',
			'email' => 'this is not an email',
			'password' => 'totes_secure_password',
			'password_confirmation' => 'blah_blah_blah'
		];
  	}
}