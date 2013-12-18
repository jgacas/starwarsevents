<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$kernel->boot();

/** TODO check what this does! */
$container = $kernel->getContainer();
$container->enterScope('request');
$container->set('request', $request);

// let's test DefaultController
$templating = $container->get('templating');
echo $templating->render('EventBundle:Default:index.html.twig', array(
    'name' => 'Yoda',
    'count' => '8'
));

use Yoda\EventBundle\Entity\Event;

$event = new Event();

$event->setName('Darth\'s surprise birthday party');
$event->setLocation('Deathstar');
$event->setTime(new \DateTime('tomorrow noon'));
$event->setDetails('Ha! Darth HATES surprises!');
// $event->setImageName('foo.jpg');

$em = $container->get('doctrine')->getManager();
$em->persist($event);
$em->flush();