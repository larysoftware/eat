<?php
namespace App\Constraint;

use Symfony\Component\Validator\Constraint;

class CustomerExist extends Constraint
{
  public $message = 'The customer with the {{ string }} login exists in the database';

  public function validatedBy()
  {
    return self::class . 'Validator';
  }

}
