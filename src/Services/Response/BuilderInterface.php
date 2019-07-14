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

interface BuilderInterface
{

  /**
   * set normalizer
   * @param NormalizerInterface $normalizer [description]
   */
  public function setNormalizer(NormalizerInterface $normalizer);

  /**
   * set encoder
   * @param EncoderInterface $encoder
   */
  public function setEncoder(EncoderInterface $encoder);

  /**
   * build from context
   * @param  mixed $context
   * @return void
   */
  public function build($context);

  /**
   * get result
   * @return Response
   */
  public function getResult(): Response;
}
