<?php
namespace App\Constraint;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

use App\Services\Customers\CustomersStorageInterface;

class CustomerExistValidator extends ConstraintValidator
{

  protected $customerStorage;

  public function __construct(CustomersStorageInterface $customerStorage) {
    $this -> customerStorage  = $customerStorage;
  }

  public function validate($login, Constraint $constraint)
  {

    if($constraint instanceof CustomerExistf) {
      throw new UnexpectedTypeException($constraint, CustomerExist::class);
    }

    if(null === $login || !is_string($login) || '' === $login) {
      return;
    }

    if(0 == $this -> customerStorage -> countByQuery([ 'login' => $login ])) {
      return;
    }

    # error
    $this -> context -> buildViolation($constraint -> message)
    -> setParameter('{{ string }}', $login)
    -> addViolation();
  }
}
