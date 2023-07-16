<?php

namespace App\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $accept_language = $request->headers->get("Accept-Language");

        if (empty($accept_language)) {
            $lang = "fr";
        }else{
            $lang = substr($accept_language, 0, 2);
        }
        $request->setLocale($lang);
        $request->headers->set('Accept-Language', $lang);
    }
}