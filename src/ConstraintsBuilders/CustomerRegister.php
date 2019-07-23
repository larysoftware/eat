<?php
namespace App\ConstraintsBuilders;

use App\Services\Validation\ConstraintsBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerRegister implements ConstraintsBuilderInterface {

  public function build(): array
  {
    return [
      'email' => [
        new Assert\Email([
          'message' => 'Nie jest poprawnym adresem email'
        ]),
        new Assert\Url([
          'message' => 'Nie jest poprawnym adresem urlem'
        ])
      ],
      'x' => [
        
      ]
    ];
  }
}
