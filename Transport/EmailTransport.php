<?php

namespace Creavo\NotifyTaskBundle\Transport;

use Creavo\NotifyTaskBundle\Interfaces\NotifyTaskInterface;
use Creavo\NotifyTaskBundle\Interfaces\TransportInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\TwigBundle\TwigEngine;

class EmailTransport implements TransportInterface {

    /** @var array */
    protected $config;

    /** @var Router */
    protected $router;

    /** @var \Swift_Mailer */
    protected $swiftMailer;

    /** @var TwigEngine */
    protected $twig;

    public function __construct(array $config, Router $router, \Swift_Mailer $swift_Mailer, TwigEngine $twigEngine) {
        $this->config=$config;
        $this->router=$router;
        $this->swiftMailer=$swift_Mailer;
        $this->twig=$twigEngine;
    }

    public function send(NotifyTaskInterface $notifyTask) {

        $user=$notifyTask->getUser();
        if(!method_exists($user,'getEmail')) {
            return;
        }

        if(!$user->getEmail()) {
            return;
        }

        /** @var \Swift_Message $mailInstance */
        $mailInstance=$this->swiftMailer->createMessage();
        $mailInstance->setTo($user->getEmail());
        $mailInstance->setFrom($this->config['email_from']);
        $mailInstance->setSubject($this->config['email_subject']);

        $mailInstance->addPart(
            $this->twig->render('CreavoNotifyTaskBundle:Email:single_notification.text.twig',[
                'notifyTask'=>$notifyTask,
            ]),
            'text/plain'
        );

        $mailInstance->addPart(
            $this->twig->render('CreavoNotifyTaskBundle:Email:single_notification.html.twig',[
                'notifyTask'=>$notifyTask,
            ]),
            'text/html'
        );

        $this->swiftMailer->send($mailInstance);
    }

}
