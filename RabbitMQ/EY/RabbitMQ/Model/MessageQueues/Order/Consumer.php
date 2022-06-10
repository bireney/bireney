<?php

declare(strict_types=1);

namespace EY\RabbitMQ\Model\MessageQueues\Order;

use Psr\Log\LoggerInterface;

/**
 * Class Consumer
 * @package EY\RabbitMQ\MessageQueues\Order
 */
class Consumer
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
     /**
     * Consumer constructor.
     */
     public function __construct(LoggerInterface $logger)
     {
         $this->logger = $logger;
     }

     public function processMessage(string $_data)
     {

         $this->logger->info('biren log#');
         $this->logger->info(print_r($_data,true));
         echo $_data."\n";
     }

}
