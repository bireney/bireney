<?php
declare(strict_types=1);
/**
 * @author  Biren Patel <Biren.Mahendrabhai.Patel@gds.ey.com>
 * @package Marmon OrderMQ
 */
namespace Marmon\OrderMQ\Observer\Order;

use Marmon\OrderMQ\Model\MessageQueues\Order\Publisher as Publisher;
use Marmon\OrderMQ\Logger\QueueLogger;
use Magento\Framework\Serialize\SerializerInterface;

class SubmitAfter implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var Publisher
     */
    protected $_publisher;
    /**
     * @var QueueLogger
     */
    protected $logger;
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param Publisher $publisher
     * @param QueueLogger $logger
     */
    public function __construct(
        Publisher $publisher,
        SerializerInterface $serializer,
        QueueLogger $logger
    ) {
        $this->_publisher = $publisher;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * Execute observer
     * it will set order data and set to publisher
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();
        $orderData['orderId'] = $orderId;
        $orderData['storeId'] = $order->getStoreId();
        $this->logger->info('Sending order to publisher - '.$orderId);
        $orderData = $this->serializer->serialize($orderData);
        $this->_publisher->execute($orderData);
    }
}
