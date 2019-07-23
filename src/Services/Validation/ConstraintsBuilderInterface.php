<?php
namespace App\Services\Validation;
use Symfony\Component\Validator\Constraints\Collection as ConstraintsCollection;

interface ConstraintsBuilderInterface {
  public function build(): array;
}
