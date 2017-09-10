<?php

namespace Creavo\NotifyTaskBundle\Interfaces;


interface NotifyTaskInterface {

    const PRIORITY_LOW=1;
    const PRIORITY_MIDDLE=5;
    const PRIORITY_HIGH=9;

    public function getUser();
    public function getTitle();
    public function getMessage();
    public function getPriority();
    public function getLinkRoute();
    public function getLinkRouteParams();

}