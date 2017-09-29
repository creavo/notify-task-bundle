<?php

namespace Creavo\NotifyTaskBundle\Interfaces;


interface NotifyTaskInterface {

    const PRIORITY_LOW=1;
    const PRIORITY_MIDDLE=5;
    const PRIORITY_HIGH=9;

    const SEND_STATUS_DO_NOT_SEND=0;
    const SEND_STATUS_OPEN=1;
    const SEND_STATUS_DONE=2;

    public function getUser();
    public function setUser($user);
    public function getTitle();
    public function setTitle($title);
    public function getMessage();
    public function setMessage($message);
    public function getPriority();
    public function setPriority($priority);
    public function getLinkRoute();
    public function setLinkRoute($linkRoute);
    public function getLinkRouteParams();
    public function setLinkRouteParams($linkRouteParams);
    public function getLinkTitle();
    public function setLinkTitle($linkTitle);

    public function sendViaEmail();
    public function sendViaPushOver();

}
