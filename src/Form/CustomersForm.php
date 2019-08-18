<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints as Assert;
use App\Constraint as AssertSystem;

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
        ]),
      ]
    ]);

    $builder -> add('login', TextType::class, [
      'required' => true,
      'constraints' => [
        new Assert\NotBlank([
           'message' => 'login nie może być pusty'
         ]),
         new Assert\Regex([
          'pattern' => '/^[a-z0-9]{3,20}$/',
          'message' => 'login może zawierać małe litery oraz cyfry od 3 do 20 znaków'
        ]),
        new AssertSystem\CustomerExist([
          'message' => 'login: `{{ login }}` istnieje już w systemie'
        ])
      ]
    ]);

    $builder -> add('company', TextType::class ,[
      'required' => true,
      'constraints' => [
        new Assert\NotBlank([
           'message' => 'nazwa firmy nie może być pusta'
        ]),
        new Assert\Regex([
         'pattern' => '/^[a-z0-9]{3,100}$/',
         'message' => 'nazwa firmy musi mieć od 3 do 100 znaków'
       ])
      ]
    ]);

    $builder -> add('phone', TextType::class, [
      'required' => true,
      'constraints' => [
        new Assert\NotBlank([
           'message' => 'telefon nie może być pusty'
        ])
      ]
    ]);

    $builder -> add('fax', TextType::class, [
      'required' => false,
      'empty_data' => ''
    ]);

    $builder -> add('contactName', TextType::class, [
      'required' => false,
      'constraints' => [
          new Assert\NotBlank([
             'message' => 'imię kontaktu nie może być puste'
          ])
        ]
      ]
    );

    $builder -> add('contactSurname', TextType::class, [
      'required' => false,
      'constraints' => [
          new Assert\NotBlank([
             'message' => 'nazwisko kontaktu nie może być puste'
          ])
        ]
      ]
    );


    $builder -> add('nip', TextType::class, [
      'required' => false,
      'constraints' => [
          new Assert\NotBlank([
             'message' => 'nip nie może być pusty'
          ])
        ]
      ]
    );

    $builder -> add('street', TextType::class, [
      'required' => false,
      'constraints' => [
          new Assert\NotBlank([
             'message' => 'ulica nie może być pusta'
          ])
        ]
      ]
    );

    $builder -> add('postCode', TextType::class, [
      'required' => false,
      'constraints' => [
          new Assert\NotBlank([
             'message' => 'kod pocztowy nie może być pusty'
          ])
        ]
      ]
    );

    $builder -> add('nip', TextType::class, [
      'required' => false,
      'constraints' => [
          new Assert\NotBlank([
             'message' => 'nip nie może być pusty'
          ])
        ]
      ]
    );


    $builder -> add('password', TextType::class, [
      'required' => false,
      'constraints' => [
          new Assert\NotBlank([
             'message' => 'hasło nie może być puste'
          ]),
          new Assert\Length([
            'min' => 4,
            'minMessage' => 'hasło musi zawierać przynajmnniej 4 znaki'
          ])
        ]
      ]
    );


  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver -> setDefaults([
      'data_class' =>  Customers::class,
      'csrf_protection' => false
    ]);
  }
}
