<?php
/** Namespace */
namespace App\Event;

/** Usages */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class RequestListener
 *
 * @package App\Event
 */
class RequestListener
{
    /**
     * Set sent json data in POST/PUT/PATCH in the request object
     * @param GetResponseEvent $responseEvent
     */
    public function onKernelRequest(GetResponseEvent $responseEvent)
    {
        /** @var Request $request */
        $request = $responseEvent->getRequest();

        if (!$responseEvent->isMasterRequest()) {
            return;
        }

        if (in_array($request->getMethod(), [Request::METHOD_POST, Request::METHOD_PUT, Request::METHOD_PATCH])) {
            /** @var array $content */
            $content = json_decode($request->getContent(), true);

            if (!empty($content)) {
                foreach($content as $attribute => $value) {
                    $request->request->set($attribute, $value);
                }
            }
        }
    }
}