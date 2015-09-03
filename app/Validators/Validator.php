<?php
namespace Rea\Validators;

use Illuminate\Validation\Factory;

/**
* Base class with some methods to validate
* Maybe I should implement an Interface
* But we gonna keep it simple for the moment
*/
abstract class Validator
{

	/**
   * Validator object
   *
   * @var Illuminate\Validation\Factory
   */
	protected $validator;

	/**
	 * Data to be validated
	 * @var array
	 */
	protected $data = array();

	/**
	 * Validation rules
	 * @var array
	 */
	protected $rules = array();

	/**
	 * Validation errors
	 * @var array
	 */
	protected $errors = array();
	
	function __construct(Factory $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Set the date to validate
	 * @param  array  $data 
	 * @return self       
	 */
	public function with(array $data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * Return the erros
	 * @return array
	 */
	public function errors()
	{
		return $this->errors;
	}

	/**
	 * Pass the data and rules to the validator
	 * @return boolean
	 */
	public function passes()
	{
		$validator = $this->validator->make($this->data, $this->rules);
		if($validator->fails())
		{
			$this->errors = $validator->messages();
			return false;
		}
		return true;
	}
}