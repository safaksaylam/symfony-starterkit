<?php

namespace App\Controller\Traits;

use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Trait EventTrait
 *
 * @package App\Controller\Traits
 */
trait EventTrait
{
    /**
     * @param string $eventName
     * @param array  $arguments
     */
    protected function dispatch(string $eventName, array $arguments)
    {
        if (!isset($arguments['subject'])) {
            throw new \InvalidArgumentException(sprintf('Event subject is not defined.'));
        }

        $event = new GenericEvent($arguments['subject'], $arguments);

        $this->get('event_dispatcher')
            ->dispatch($eventName, $event);
    }
}
