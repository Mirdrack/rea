<?php

use Mockery as Mockery;

use Rea\Validators\StubValidator;

class ValidatorTest extends TestCase
{
	
	public function tearDown()
	{
		Mockery::close();
	}

	/**
	 * 
	 * @expectedException Exception
	 */
	public function test_validator_throws_exception_on_wrong_dependency()
	{
		$validator = new StubValidator( new StdClass() );
	}

	/**
	*  @expectedException Exception
	*/
	public function test_with_method_throws_exception_if_not_array()
	{
		$validator = new StubValidator( Mockery::mock('Illuminate\Validation\Factory') );
		$validator->with( 'hello world' );
	}

	/**
	*  @expectedException Exception
	*/
	public function test_passes_method_throws_exception_if_not_array()
	{
		$validator = new StubValidator( Mockery::mock('Illuminate\Validation\Factory') );
		$validator->passes( 'hello world' );
	}
}