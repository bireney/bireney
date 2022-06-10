<?php
namespace EY\ERPOrderGraph\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderManagementInterface;
/**
 * Class OrderRepositoryPlugin
 */
class OrderManagement
{
    /**
     * Order feedback field name
     */
    const ERP_ORDER_NO_COL = 'erp_order_number';

    /**
     * Order model name
     */
    protected $order;

    /**
     * @param \Magento\Sales\Model\Order $order
     */
    public function __construct(
        \Magento\Sales\Model\Order $order
    ) {
        $this->order = $order;
    }

    /**
     * @param OrderManagementInterface $subject
     * @param OrderInterface $result
     * @return OrderInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterPlace(
        OrderManagementInterface $subject,
        OrderInterface $result
    ) {
        $orderId = $result->getIncrementId();
        if ($orderId) {
            $erpRandomNumber = rand(0,99999999);
            $ordData = $this->order->load($orderId);
            $ordData->setErpOrderNumber($erpRandomNumber);
            $ordData->save();
        }
        return $result;
    }
}
