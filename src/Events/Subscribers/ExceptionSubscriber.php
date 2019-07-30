<?php
namespace App\Events\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;

use App\Services\Response\ResponseCreatorInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    protected $responseFactory;

    public function __construct(ResponseCreatorInterface $responseFactory) {
      $this -> responseFactory = $responseFactory;
    }

    /**
     * get exception to json
     * @param  GetResponseForExceptionEvent $e [description]
     * @return [type]                          [description]
     */
    public function onKernelException(GetResponseForExceptionEvent $e)
    {

      $exception = $e -> getException();

      $e -> setResponse(
        $this -> responseFactory -> createResponse(
          [
            'error' => $exception -> getMessage()
          ],
          Response::HTTP_INTERNAL_SERVER_ERROR
        )
      );
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }
}
