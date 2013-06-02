<?php

namespace Repository\MySql;

use Doctrine\ORM\EntityRepository;

use Entities\Message as MessageEntity;
use Mapper\Message as MessageMapper;

class Message extends EntityRepository
{

    /**
     * @var MessageEntity
     */
    protected $messageEntity;

    /**
     * @var \Pimple
     */
    protected $container;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;


    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function insert($data)
    {
        $messageEntity = new MessageEntity();
        $messageMapper = new MessageMapper();

        $mapped = $messageMapper->map($data, $messageEntity);

        if ($mapped->isValid() === false) {
            throw new \InvalidArgumentException("Wrong data provided for client or encoding or message body");
        }

        $this->container['em']->persist($mapped);
        $this->container['em']->flush();

        return $mapped->toArray();
    }

    public function get($id)
    {
        $message = $this->find($id);

        if (!$message){
            throw new \InvalidArgumentException("No message found");
        }

        return $message->toArray();
    }

    public function update($id, $data)
    {
        $messageEntity = $this->find($id);

        if (!$messageEntity){
            throw new \InvalidArgumentException("No message found");
        }

        $messageMapper = new MessageMapper();
        $mapped = $messageMapper->map($data, $messageEntity);

        if ($mapped->isValid() === false) {
            throw new \InvalidArgumentException("Wrong data provided for client or encoding or message body");
        }

        $this->container['em']->persist($mapped);
        $this->container['em']->flush();

        return $mapped->toArray();
    }

    public function delete($id)
    {
        $message = $this->find($id);

        if (!$message){
            throw new \InvalidArgumentException("No message found");
        }

        $this->container['em']->remove($message);
        $this->container['em']->flush();
    }
}