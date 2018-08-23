<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

class WebhookSubscriber implements EventSubscriberInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $token;

    /**
     * WebhookSubscriber constructor.
     *
     * @param RouterInterface $router
     * @param string          $path
     * @param string          $token
     */
    public function __construct(RouterInterface $router, string $path, string $token)
    {
        $this->router = $router;
        $this->path = $path;
        $this->token = $token;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (empty($this->path) || empty($this->token)) {
            return;
        }

        $url = $this->router->generate($this->path, [], RouterInterface::ABSOLUTE_URL);
        if ($url !== $event->getRequest()->getUri()) {
            return;
        }

        $requestToken = $event->getRequest()->headers->get('X-Payjp-Webhook-Token');
        if ($requestToken !== $this->token) {
            throw new AccessDeniedException('token is not valid.');
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest'],
        ];
    }
}
