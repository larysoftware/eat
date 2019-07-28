<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Customers;

class CustomersForm extends AbstractType  {

  public function buildForm(FormBuilderInterface $builder, array $options)
  {

    $builder -> add('email', TextType::class, [
      'required' => true,
      'constraints' => [
        new Assert\Email([
          'message' => 'Nie jest poprawnym adresem email'
        ]),
        new Assert\NotBlank([
          'message' => 'email nie może być pusty'
        ])
      ]
    ]);

    $builder -> add('login', TextType::class, [
      'required' => true,
      'constraints' => [
        new Assert\NotBlank([
           'message' => 'login nie może być pusty'
         ]),
         new Assert\Regex([
          'pattern' => '/^[a-z0-9]{3,9}$/',
          'message' => 'login może zawierać małe litery oraz cyfry od 3 do 9 znaków'
        ])
      ]
    ]);

  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver -> setDefaults([
      'data_class' =>  Customers::class,
    ]);
  }
}
