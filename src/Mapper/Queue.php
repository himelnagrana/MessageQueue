<?php

namespace Mapper;

use Entities\Queue as QueueEntity;

class Queue
{

    public function map($data, QueueEntity $queueEntity)
    {
        if (!empty($data['message_id'])){
            $queueEntity->setMessageId($data['message_id']);
        }

        if (!empty($data['client_id'])){
            $queueEntity->setClientId($data['client_id']);
        }

        if (!empty($data['serial'])){
            $queueEntity->setSerial($data['serial']);
        }

        if (!empty($data['priority'])){
            $queueEntity->setPriority($data['priority']);
        }

        if (!empty($data['status'])){
            $queueEntity->setStatus($data['status']);
        }

        if (!empty($data['encoding'])){
            $queueEntity->setEncoding($data['encoding']);
        }

        $queueEntity->setUpdatedat(new \DateTime());

        return $queueEntity;
    }
}