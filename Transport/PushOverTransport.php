<?php

namespace Creavo\NotifyTaskBundle\Transport;

use Creavo\NotifyTaskBundle\Interfaces\NotifyTaskInterface;
use Creavo\NotifyTaskBundle\Interfaces\TransportInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class PushOverTransport implements TransportInterface {

    protected $router;
    protected $apiToken;

    public function __construct($apiToken, Router $router) {
        $this->router=$router;
        $this->apiToken=$apiToken;
    }

    public function send(NotifyTaskInterface $notifyTask) {

        $user=$notifyTask->getUser();
        if(!method_exists($user,'getPushoverKey')) {
            return;
        }

        if(!$this->apiToken) {
            return;
        }

        $data=[
            'token'=>$this->apiToken,
            'user'=>$user->getPushoverKey(),
            'message'=>$notifyTask->getMessage(),
            'title'=>$notifyTask->getTitle(),
        ];

        if($notifyTask->getLinkRoute()) {
            $data['url']=$this->router->generate($notifyTask->getLinkRoute(),$notifyTask->getLinkRouteParams(),Router::ABSOLUTE_URL);
        }
        if($notifyTask->getLinkTitle()) {
            $data['url_title']=$notifyTask->getLinkTitle();
        }

        $this->sendCurl($data);
    }

    public function sendCurl(array $data) {

        curl_setopt_array($ch = curl_init(), array(
            CURLOPT_URL => "https://api.pushover.net/1/messages.json",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_SAFE_UPLOAD => true,
            CURLOPT_RETURNTRANSFER => true,
        ));
        curl_exec($ch);
        curl_close($ch);
    }

}