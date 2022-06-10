<?php declare(strict_types=1);

/**
 * @author  Biren Patel <Biren.Mahendrabhai.Patel@gds.ey.com>
 * @package Marmon OrderMQ
 */

namespace Marmon\OrderMQ\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Class Handler for Custom log
 */
class Handler extends Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * File name
     * @var string
     */
    protected $fileName = 'var/log/orderqueue.log';
}
