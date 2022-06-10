<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace EY\UserLevelGraphQl\Model\Resolver;

use Magento\CustomerGraphQl\Model\Customer\CreateCustomerAccount;
use Magento\CustomerGraphQl\Model\Customer\ExtractCustomerData;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Newsletter\Model\Config;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Create customer account resolver
 */
class CreateCustomer implements ResolverInterface
{
    /**
     * @var TimezoneInterface
     */
    protected $_date;

    /**
     * @var ExtractCustomerData
     */
    private $extractCustomerData;

    /**
     * @var CreateCustomerAccount
     */
    private $createCustomerAccount;

    /**
     * @var Config
     */
    private $newsLetterConfig;

    /**
     * CreateCustomer constructor.
     *
     * @param ExtractCustomerData $extractCustomerData
     * @param CreateCustomerAccount $createCustomerAccount
     * @param Config $newsLetterConfig
     */
    public function __construct(
        ExtractCustomerData $extractCustomerData,
        TimezoneInterface $date,
        CreateCustomerAccount $createCustomerAccount,
        Config $newsLetterConfig
    ) {
        $this->newsLetterConfig = $newsLetterConfig;
        $this->_date = $date;
        $this->extractCustomerData = $extractCustomerData;
        $this->createCustomerAccount = $createCustomerAccount;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        if (!$this->newsLetterConfig->isActive(ScopeInterface::SCOPE_STORE)) {
            $args['input']['is_subscribed'] = false;
        }
        if (isset($args['input']['date_of_birth'])) {
            $args['input']['dob'] = $args['input']['date_of_birth'];

            $args['input']['user_level'] = $this->ageLogic($args['input']['date_of_birth']);

        }

        $customer = $this->createCustomerAccount->execute(
            $args['input'],
            $context->getExtensionAttributes()->getStore()
        );

        $data = $this->extractCustomerData->execute($customer);
        return ['customer' => $data];
    }

    /**
     * @return TimezoneInterface
     */
    public function ageLogic($dob)
    {
        $todayDate = $this->_date->date()->format('Y');
        $custDob = $this->_date->date(new \DateTime($dob))->format('Y');
        $diff = $todayDate - $custDob;
        //$age = date_diff(date_create($args['input']['date_of_birth']), date_create('today'))->y;
        $userLevel = '';
        if($diff >= 18){
            $userLevel = 2;
        }else{
            $userLevel = 1;
        }
        return $userLevel;
    }
}
