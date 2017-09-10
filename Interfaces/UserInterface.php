<?php

namespace Creavo\NotifyTaskBundle\Interfaces;


interface UserInterface {

    public function getEmail();
    public function getPushoverKey();

}