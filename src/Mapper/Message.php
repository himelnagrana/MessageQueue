<?php

namespace Mapper;

use Entities\Message as MessageEntity;

class Message
{

    public function map($data, MessageEntity $messageEntity)
    {
        if (!empty($data['encoding'])){
            $messageEntity->setEncoding($data['encoding']);
        }

        if (!empty($data['client_id'])){
            $messageEntity->setClientId($data['client_id']);
        }

        if (!empty($data['message_body'])){
            $messageEntity->setMessageBody($data['message_body']);
        }

        $messageEntity->setCreated(new \DateTime());

        return $messageEntity;
    }
}