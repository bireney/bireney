<?php
declare(strict_types=1);

namespace EY\RabbitMQ\Observer\Order;
use EY\RabbitMQ\Model\MessageQueues\Order\Publisher as Publisher;

class PlaceAfter implements \Magento\Framework\Event\ObserverInterface
{
    /**
    * @var Publisher
    */
    private $_publisher;

    public function __construct(
        Publisher $publisher
    )
    {
        $this->_publisher = $publisher;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getIncrementId();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/orrab.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('Custom message');
        $logger->info(print_r($orderId, true));
        $erpOrderId = "ERP-".$orderId;
        $_data=array(
            'magentoOrderId' => $orderId,
            'erpOrderId' => $erpOrderId
        );

        $this->_publisher->execute(json_encode($_data));
    }
}
