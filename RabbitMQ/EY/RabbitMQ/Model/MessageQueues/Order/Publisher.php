<?php declare(strict_types=1);

namespace EY\RabbitMQ\Model\MessageQueues\Order;
use Magento\Framework\MessageQueue\PublisherInterface;

class Publisher
{
     const TOPIC_NAME = 'ey.magento.order.place';

     /**
      * @var \Magento\Framework\MessageQueue\PublisherInterface
      */
     private $publisher;

     /**
     * Publisher constructor.
     * @param Publisher $publisher
     */
     public function __construct
     (
         PublisherInterface $publisher
     )
     {
         $this->publisher = $publisher;
     }

     /**
     * @param data
     */
     public function execute(string $_data)
     {
         $this->publisher->publish(self::TOPIC_NAME, $_data);
     }
}
