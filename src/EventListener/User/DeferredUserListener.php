<?php declare(strict_types=1);
// SPDX-License-Identifier: BSD-3-Clause

namespace Nbgrp\OneloginSamlBundle\EventListener\User;

use Nbgrp\OneloginSamlBundle\Security\Http\Authenticator\Passport\Badge\DeferredEventBadge;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsEventListener]
final class DeferredUserListener
{
    public function __invoke(CheckPassportEvent $event, string $eventName, EventDispatcherInterface $eventDispatcher): void
    {
        $badge = $event->getPassport()->getBadge(DeferredEventBadge::class);
        if (!$badge instanceof DeferredEventBadge) {
            return;
        }

        $deferredEvent = $badge->getEvent();
        if ($deferredEvent) {
            $eventDispatcher->dispatch($deferredEvent);
        }
    }
}
