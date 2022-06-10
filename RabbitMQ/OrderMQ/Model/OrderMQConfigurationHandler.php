<?php
/**
 * @author  Biren Patel <Biren.Mahendrabhai.Patel@gds.ey.com>
 * @package Marmon OrderMQ
 */
namespace Marmon\OrderMQ\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
/**
 * Class OrderMQConfigurationHandler to handle all marmon project configurations
 */
class OrderMQConfigurationHandler
{
    /**
     * dell boomi api endpoint path
     */
    const DELL_BOOMI_API_ENDPOINT = 'ordersubmit/general/dell_boomi_endpoint';

    /**
     * dell boomi username path
     */
    const DELL_BOOMI_USERNAME = 'ordersubmit/general/username';

    /**
     * dell boomi password path
     */
    const DELL_BOOMI_PASSWORD = 'ordersubmit/general/password';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        EncryptorInterface $encryptor,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->encryptor = $encryptor;
        $this->storeManager = $storeManager;
    }

    /**
     *
     * @return string
     */
    public function getDellBoomiApiEndpoint($orderStoreId = 1): string
    {
        return $this->scopeConfig->getValue(self::DELL_BOOMI_API_ENDPOINT, ScopeInterface::SCOPE_STORE,$orderStoreId);
    }

    /**
     *
     * @return string
     */
    public function getDellBoomiUsername($orderStoreId = 1): string
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/configData.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('text message');
        $logger->info($orderStoreId);
        $logger->info('store text message');

        $logger->info(print_r($this->storeManager->getStore()->getStoreId(), true));
        $logger->info(print_r($this->scopeConfig->getValue(self::DELL_BOOMI_USERNAME, ScopeInterface::SCOPE_STORE,$orderStoreId), true));
        $logger->info(print_r($this->scopeConfig->getValue(self::DELL_BOOMI_USERNAME, ScopeInterface::SCOPE_STORE), true));
        return $this->scopeConfig->getValue(self::DELL_BOOMI_USERNAME, ScopeInterface::SCOPE_STORE,$orderStoreId);
    }

    /**
     *
     * @return string | null
     */
    public function getDellBoomiPassword($orderStoreId = 1): ?string
    {
        $password = $this->scopeConfig->getValue(self::DELL_BOOMI_PASSWORD, ScopeInterface::SCOPE_STORE,$orderStoreId);
        return $this->encryptor->decrypt($password);
    }
}
