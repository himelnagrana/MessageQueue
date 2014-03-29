<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Response;
use Repository\MySql\Message as MessageRepository;

class Message extends Base
{
    /** @var MessageRepository */
    protected $messageRepository;

    public function init()
    {
        $this->response = new Response();
        $this->response->headers->set('Content-Type', 'application/json');

        if ($this->config['persister_choice'] == 'mysql') {

            $this->messageRepository = $this->em->getRepository('Entities\Message');

        } elseif ($this->config['persister_choice'] == 'mongodb') {

            $this->messageRepository = $this->em->getRepository('Document\Message');
        }

        $this->messageRepository->setContainer($this->container);
        $this->messageRepository->setRequest($this->request);
    }

    public function insert()
    {
        $data = $this->request->request->all();

        try {

            $message = $this->messageRepository->insert($data);
            $this->response->setContent(json_encode(array('result' => $message)));
            $this->response->setStatusCode(201);

        } catch (\InvalidArgumentException $e) {

            $this->response->setContent(json_encode(array('result' => $e->getMessage())));
            $this->response->setStatusCode($e->getCode());
        }

        return $this->response;
    }

    public function get($messageId)
    {
        try {

            $message = $this->messageRepository->get($messageId);
            $this->response->setContent(json_encode(array('result' => $message)));
            $this->response->setStatusCode(200);

        } catch (\InvalidArgumentException $e) {

            $this->response->setContent(json_encode(array('result' => $e->getMessage())));
            $this->response->setStatusCode($e->getCode());
        }

        return $this->response;
    }

    public function update($messageId)
    {
        $data = $this->request->request->all();

        try {

            $message = $this->messageRepository->update($messageId, $data);
            $this->response->setContent(json_encode(array('result' => $message)));
            $this->response->setStatusCode(200);

        } catch (\InvalidArgumentException $e) {

            $this->response->setContent(json_encode(array('result' => $e->getMessage())));
            $this->response->setStatusCode($e->getCode());
        }

        return $this->response;
    }

    public function delete($messageId)
    {
        try {

            $this->messageRepository->delete($messageId);
            $this->response->setContent(json_encode(array('result' => "Message deleted successfully")));
            $this->response->setStatusCode(200);

        } catch (\InvalidArgumentException $e) {

            $this->response->setContent(json_encode(array('result' => $e->getMessage())));
            $this->response->setStatusCode($e->getCode());
        }

        return $this->response;
    }
}