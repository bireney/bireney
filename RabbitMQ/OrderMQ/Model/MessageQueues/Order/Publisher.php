<?php declare(strict_types=1);
/**
 * @author  Biren Patel <Biren.Mahendrabhai.Patel@gds.ey.com>
 * @package Marmon OrderMQ
 */
namespace Marmon\OrderMQ\Model\MessageQueues\Order;

use Magento\Framework\MessageQueue\PublisherInterface;

class Publisher
{
     const TOPIC_NAME = 'mq.magento.order.place';

     /**
      * @var \Magento\Framework\MessageQueue\PublisherInterface
      */
     private $publisher;

     /**
      * Publisher constructor.
      * @param Publisher $publisher
      */
    public function __construct(
        PublisherInterface $publisher
    ) {
        $this->publisher = $publisher;
    }

     /**
      * @param $_data
      * this function will push the data to rabbitMq publisher queue
      */
    public function execute(string $_data)
    {
        $this->publisher->publish(self::TOPIC_NAME, $_data);
    }
}
