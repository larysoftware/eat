<?php

/**
 * klasa builder
 *
 * @var [type]
 */
namespace App\Services\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

class Director {

  protected $builder;
  protected $context;
  protected $encoder;
  protected $normalizer;

  public function __construct(Builder $builder, EncoderInterface $encoder, NormalizerInterface $normalizer , $context)
  {
    $this -> builder = $builder;
    $this -> context = $context;
    $this -> normalizer = $normalizer;
    $this -> encoder = $encoder;
  }

  public function getResponse(): Response
  {
    $this -> builder -> setNormalizer($this -> normalizer);
    $this -> builder -> setEncoder($this -> encoder);
    $this -> builder -> build($this -> context);
    return $this -> builder -> getResult();
  }
}
