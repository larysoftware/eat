<?php

namespace App\Services\Response\Exception;

class ExceptionBuilderResponse extends \Exception {
  public function __construct(string $message, int $code, array $data = [])
  {
    parent::__construct($message, $code, $data);
  }
}
