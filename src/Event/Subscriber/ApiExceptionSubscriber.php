<?php
/** Namespace */
namespace App\Event\Subscriber;

/** Usages */
use App\Exceptions\FormValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Psr\Log\LoggerInterface;

/**
 * Class ApiExceptionSubscriber
 * @package App\Event\Subscriber
 */
class ApiExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * ApiExceptionSubscriber constructor.
     * @param $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents() : array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }

    /**
     * @return array
     */
    public function getDefaultHeaders() : array
    {
        return [
            'Access-Control-Allow-Origin' => '*',
            'Content-type' => 'application/json',
        ];
    }

    /**
     * Catch HTTP exceptions and return a JsonResponse
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event) : void
    {
        $exception = $event->getException();
        $this->logger->error($exception->getMessage(), ['exception' => $exception]);

        // Return only http exceptions
        if ($exception instanceof HttpExceptionInterface) {
            $response =
                new JsonResponse($exception->getMessage(), $exception->getStatusCode(), $this->getDefaultHeaders());
            $event->setResponse($response);
        } elseif ($exception instanceof FormValidationException) {
            $response =
                new JsonResponse($exception->getErrorDetails(), Response::HTTP_BAD_REQUEST, $this->getDefaultHeaders());
            $event->setResponse($response);
        }
    }
}