<?php

namespace Entities;

use Respect\Validation\Validator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Repository\MySql\Message")
 * @ORM\Table(name="message")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", length=5)
     */
    protected $client_id;

    /**
     * @ORM\Column(length=20)
     */
    protected $encoding; // [values: ASCII, Base64]

    /**
     * @ORM\Column(length=400)
     */
    protected $message_body;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created;

    public function toArray()
    {
        $data = array(
            'id'           => $this->getId(),
            'client_id'    => $this->getClientId(),
            'encoding'     => $this->getEncoding(),
            'message_body' => $this->getMessageBody(),
            'created'      => $this->getCreated()
        );

        return $data;
    }

    public function isValid()
    {
        try {

            Validator::create()->notEmpty()->numeric()->assert($this->getClientId());
            Validator::create()->notEmpty()->numeric()->assert($this->getEncoding());
            Validator::create()->notEmpty()->numeric()->assert($this->getMessageBody());

        } catch (\InvalidArgumentException $e) {

            return false;
        }

        return true;
    }

    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    public function getEncoding()
    {
        return $this->encoding;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setMessageBody($message_body)
    {
        $this->message_body = $message_body;
    }

    public function getMessageBody()
    {
        return $this->message_body;
    }
}