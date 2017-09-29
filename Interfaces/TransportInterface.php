<?php

namespace Creavo\NotifyTaskBundle\Interfaces;

interface TransportInterface {

    public function send(NotifyTaskInterface $object);

}
