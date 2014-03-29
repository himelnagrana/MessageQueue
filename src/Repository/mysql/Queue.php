<?php

namespace Repository\MySql;

use Doctrine\ORM\EntityRepository;

use Entities\Queue as QueueEntity;
use Mapper\Queue as QueueMapper;

class Queue extends EntityRepository
{

    /**
     * @var QueueEntity
     */
    protected $queueEntity;

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

    public function enqueue($data)
    {
        $queueEntity = new QueueEntity();
        $mapper = new QueueMapper();

        $data['serial'] = $this->getSerialForClient($data['client_id']);
        $data['status'] = 'queued';

        $queue = $mapper->map($data, $queueEntity);

        if ($queue->isValid() === false) {
            throw new \InvalidArgumentException("Wrong data in messageId or serial or priority");
        }

        $this->container['em']->persist($queue);
        $this->container['em']->flush();

        return $queue->toArray();
    }

    public function process($messageId)
    {
        $queue = $this->findOneBy(array($messageId));

        if (!$queue){
            throw new \InvalidArgumentException("No Message to process");
        }

        $queue->setStatus('processing');

        $this->container['em']->persist($queue);
        $this->container['em']->flush();

        return $queue->toArray();
    }

    public function dequeue($messageId)
    {
        $queue = $this->findOneBy(array($messageId));
        $queue->setStatus('dequeued');

        $this->container['em']->persist($queue);
        $this->container['em']->flush();

        return $queue->toArray();
    }

    public function serveNextMessage($clientId)
    {
        $repository = $this->container['em']->getRepository('Entities\Queue');

        $query = $repository->createQueryBuilder('q')
                            ->select('MAX(q.serial) as maxserial')
                            ->where('q.status = :status')
                            ->andWhere('client_id = :client')
                            ->setParameter('status', 'queued')
                            ->setParameter('client', $clientId)
                            ->getQuery();

        $queue = $query->getResult();

        if (empty($queue[0])) {
            throw new \InvalidArgumentException("No Message to process");
        }

        return $queue[0]['message_id'];
    }

    private function getSerialForClient($clientId)
    {
        $repository = $this->container['em']->getRepository('Entities\Queue');

        $query = $repository->createQueryBuilder('q')
                            ->select('MAX(q.serial) as maxserial')
                            ->where('q.status = :status')
                            ->andWhere('client_id = :client')
                            ->setParameter('status', 'queued')
                            ->setParameter('client', $clientId)
                            ->getQuery();

        $queue = $query->getResult();

        if (empty($queue[0])) {
            return 1;
        }

        return $queue[0]['serial'] + 1;
    }
}