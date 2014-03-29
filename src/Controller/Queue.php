<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Response;
use Repository\MySql\Queue as QueueRepository;

class Queue extends Base
{
    /** @var QueueRepository */
    protected $queueRepository;

    public function init()
    {
        $this->response = new Response();
        $this->response->headers->set('Content-Type', 'application/json');

        if ($this->config['persister_choice'] == 'mysql') {

            $this->queueRepository = $this->em->getRepository('Entities\Queue');

        } elseif ($this->config['persister_choice'] == 'mongodb'){

            $this->queueRepository = $this->em->getRepository('Document\Queue');
        }

        $this->queueRepository->setContainer($this->container);
        $this->queueRepository->setRequest($this->request);
    }

    public function enqueue()
    {
        $data = $this->request->request->all();

        try {

            $queue = $this->queueRepository->enqueue($data);
            $this->response->setContent(json_encode(array('result' => $queue)));
            $this->response->setStatusCode(201);

        } catch (\InvalidArgumentException $e) {

            $this->response->setContent(json_encode(array('result' => $e->getMessage())));
            $this->response->setStatusCode($e->getCode());
        }

        return $this->response;
    }

    public function process($messageId)
    {
        try {

            $queue = $this->queueRepository->process($messageId);
            $this->response->setContent(json_encode(array('result' => $queue)));
            $this->response->setStatusCode(200);

        } catch (\InvalidArgumentException $e) {

            $this->response->setContent(json_encode(array('result' => $e->getMessage())));
            $this->response->setStatusCode($e->getCode());
        }

        return $this->response;
    }

    public function serveNextMessage($clientId)
    {
        try {

            $messageId = $this->queueRepository->serveNextMessage($clientId);
            $this->response->setContent(json_encode(array('result' => $messageId)));
            $this->response->setStatusCode(200);

        } catch (\InvalidArgumentException $e) {

            $this->response->setContent(json_encode(array('result' => $e->getMessage())));
            $this->response->setStatusCode($e->getCode());
        }

        return $this->response;
    }

    public function dequeue($messageId)
    {
        try {

            $queue = $this->queueRepository->dequeue($messageId);
            $this->response->setContent(json_encode(array('result' => $queue)));
            $this->response->setStatusCode(200);

        } catch (\InvalidArgumentException $e) {

            $this->response->setContent(json_encode(array('result' => $e->getMessage())));
            $this->response->setStatusCode($e->getCode());
        }

        return $this->response;
    }
}