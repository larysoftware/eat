<?php
/**
 * @author lukasz7221@gmail.com
 *
 * Response Builder
 */

namespace App\Services\Response;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use App\Services\Response\Exception\ExceptionBuilderResponse;

abstract class AbstractBuilder implements BuilderInterface
{

  protected $normalizer;

  protected $encoder;

  /**
   * set normalizer
   * @param NormalizerInterface $normalizer [description]
   */
  public function setNormalizer(NormalizerInterface $normalizer)
  {
    $this -> normalizer = $normalizer;
  }

  /**
   * set encoder
   * @param EncoderInterface $encoder
   */
  public function setEncoder(EncoderInterface $encoder)
  {
    $this -> encoder = $encoder;
  }

  /**
   * build from context
   * @param  mixed $context
   * @return void
   */
  public abstract function build($context);

  /**
   * get result
   * @return Response
   */
  public function getResult(): Response {

    if(null === $this -> response or !( $this -> response instanceof  Response ) ) {
      throw new ExceptionBuilderResponse("Error create response", 1);
    }

    return $this -> response;
  }
}
