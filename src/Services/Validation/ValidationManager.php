<?php
namespace App\Services\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;;
use Symfony\Component\Validator\Constraints\Collection as ConstraintsCollection;

class ValidationManager {

  protected $validator;

  protected $messages = [];

  protected $constraintsCollection;

  protected $data;

  public function __construct(ValidatorInterface $validator)
  {
    $this -> validator = $validator;
  }

  /**
   * set input data
   * @param  mixed $data
   * @return self         [description]
   */
  public function setData($data): self
  {
    $this -> data = $data;
    return $this;
  }

  /**
   * valida
   * @param  ConstraintsBuilderInterface|Collection|array $constraintBuilder
   * @return bool
   */
  public function validate($constraintBuilder): bool
  {

    if(is_array($constraintBuilder)) {
      $this -> constraintsCollection = new ConstraintsCollection(
        $constraintBuilder
      );
    }

    if($constraintBuilder instanceof ConstraintsBuilderInterface) {
      $this -> constraintsCollection = new ConstraintsCollection(
        $constraintBuilder -> build()
      );
    }

    if($constraintBuilder instanceof ConstraintsCollection) {
        $this -> constraintsCollection = $constraintsCollection;
    }

    #alidate
    $errors = $this -> validator -> validate($this -> data, $this -> constraintsCollection);

    #itarate
    if(count($errors)) {
      foreach ($errors as $error) {
        #PropertyAccess
        $this -> messages[$error -> getPropertyPath()][] = (string)$error -> getMessage();
      }

      return false;
    }

    return true;
  }

  /**
   * get error messages
   * @return array
   */
  public function getMessages(): array
  {

    return $this -> messages;
  }


}
