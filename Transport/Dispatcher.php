<?php

namespace Creavo\NotifyTaskBundle\Transport;


use Creavo\NotifyTaskBundle\Entity\Notification;

class Dispatcher {

    /** @var array */
    protected $config;

    /** @var PushOverTransport */
    protected $pushOverTransport;

    /** @var EmailTransport */
    protected $emailTransport;

    public function __construct(array $config, PushOverTransport $pushOverTransport, EmailTransport $emailTransport) {
        $this->config=$config;
        $this->pushOverTransport=$pushOverTransport;
        $this->emailTransport=$emailTransport;
    }

    public function sendNotification(Notification $notification) {

        if($this->config['pushover_enabled']===true) {
            $this->pushOverTransport->send($notification);
        }
        if($this->config['email_enabled']===true) {
            $this->emailTransport->send($notification);
        }

    }
}
