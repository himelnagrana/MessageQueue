<?php

namespace Entities;

use Respect\Validation\Validator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Repository\MySql\Queue")
 * @ORM\Table(name="queue")
 */
class Queue
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $message_id;

    /**
     * @ORM\Column(type="integer", length=5)
     */
    protected $client_id;

    /**
     * @ORM\Column(type="integer", length=5)
     */
    protected $serial;

    /**
     * @ORM\Column(type="integer", length=5)
     */
    protected $priority;

    /**
     * @ORM\Column(length=20)
     */
    protected $encoding; // [values: ASCII, Base64]

    /**
     * @ORM\Column(length=20)
     */
    protected $status; // [values: queued, processing, dequeued, failed]

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedat;

    public function toArray()
    {
        $data = array(
            'id'         => $this->getId(),
            'message_id' => $this->getMessageId(),
            'client_id'  => $this->getClientId(),
            'serial'     => $this->getSerial(),
            'priority'   => $this->getPriority(),
            'status'     => $this->getStatus(),
            'updated_at' => $this->getUpdatedat()
        );

        return $data;
    }

    public function isValid()
    {
        try {

            Validator::create()->notEmpty()->numeric()->assert($this->getMessageId());
            Validator::create()->notEmpty()->numeric()->assert($this->getSerial());
            Validator::create()->notEmpty()->numeric()->assert($this->getPriority());

        } catch (\InvalidArgumentException $e) {

            return false;
        }

        return true;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setMessageId($message_id)
    {
        $this->message_id = $message_id;
    }

    public function getMessageId()
    {
        return $this->message_id;
    }

    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setSerial($serial)
    {
        $this->serial = $serial;
    }

    public function getSerial()
    {
        return $this->serial;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setUpdatedat($updatedat)
    {
        $this->updatedat = $updatedat;
    }

    public function getUpdatedat()
    {
        return $this->updatedat;
    }

    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    public function getEncoding()
    {
        return $this->encoding;
    }
}