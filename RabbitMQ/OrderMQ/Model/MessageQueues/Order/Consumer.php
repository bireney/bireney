<?php
declare(strict_types=1);
/**
 * @author  Biren Patel <Biren.Mahendrabhai.Patel@gds.ey.com>
 * @package Marmon OrderMQ
 */
namespace Marmon\OrderMQ\Model\MessageQueues\Order;

use Marmon\OrderMQ\Logger\QueueLogger;
use Marmon\Core\Model\HttpClient;
use Marmon\OrderMQ\Model\OrderMQConfigurationHandler;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class Consumer
 * Marmon\OrderMQ\MessageQueues\Order
 */
class Consumer
{
    /**
     * @var QueueLogger
     */
    protected $logger;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var OrderMQConfigurationHandler
     */
    protected $orderMQConfigurationHandler;

    /**
     *
     * @var Json
     */
    protected $jsonSerializer;

    /**
     * @param QueueLogger $logger
     * @param OrderMQConfigurationHandler $orderMQConfigurationHandler
     * @param Json $jsonSerializer
     * @param HttpClient $httpClient
     */
    public function __construct(
        QueueLogger $logger,
        OrderMQConfigurationHandler $orderMQConfigurationHandler,
        Json $jsonSerializer,
        HttpClient $httpClient
    ) {
        $this->httpClient = $httpClient;
        $this->orderMQConfigurationHandler = $orderMQConfigurationHandler;
        $this->jsonSerializer = $jsonSerializer;
        $this->logger = $logger;
    }

    /**
     * @param string $_data
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function processMessage(string $_data)
    {
        $orderData = $this->jsonSerializer->unserialize($_data);
        $orderStoreId = $orderData['storeId'];
        $user = $this->orderMQConfigurationHandler->getDellBoomiUsername($orderStoreId);
        $pass = $this->orderMQConfigurationHandler->getDellBoomiPassword($orderStoreId);
        $userPass = $user.":".$pass;
        $headers = [
            'Content-Type:application/json',
            'Authorization: Basic '. base64_encode($userPass)
        ];
        $this->logger->info($user);
        $this->logger->info("User New");
        $this->logger->info($pass);
        $this->logger->info("Pass New best");
        $this->logger->info(print_r($orderData, true));

        $response = $this->httpClient->call(
            $this->orderMQConfigurationHandler->getDellBoomiApiEndpoint($orderStoreId),
            true,
            'POST',
            $headers,
            ["OrderID" => $orderData['orderId']]
        );
        $this->logger->info($response);
        return $_data;
    }
}
