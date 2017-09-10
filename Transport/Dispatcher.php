<?php

namespace Creavo\NotifyTaskBundle\Transport;


use Creavo\NotifyTaskBundle\Entity\Notification;

class Dispatcher {

    /** @var array */
    protected $config;

    /** @var PushOverTransport */
    protected $pushOverTransport;

    public function __construct(array $config, PushOverTransport $pushOverTransport) {
        $this->config=$config;
        $this->pushOverTransport=$pushOverTransport;
    }

    public function sendNotification(Notification $notification) {

        if($this->config['pushover_enabled']===true) {
            $this->pushOverTransport->send($notification);
        }

    }
}