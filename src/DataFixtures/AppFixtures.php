<?php

namespace App\DataFixtures;

use App\Entity\Event;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 30; $i++) {
            $event = new Event();
            $event->setName('Event ' . $i);
            $event->setIsAuthorized(rand(0, 1));
            $event->setIpAddress('192.168.0.' . rand(1, 255));
            $event->setCreatedAt(new DateTimeImmutable());
            $manager->persist($event);
        }

        $manager->flush();
    }
}
