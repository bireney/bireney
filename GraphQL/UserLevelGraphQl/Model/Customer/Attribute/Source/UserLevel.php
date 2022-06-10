<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace EY\UserLevelGraphQl\Model\Customer\Attribute\Source;

class UserLevel extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => 1, 'label' => __('Junior')],
                ['value' => 2, 'label' => __('Senior')]
            ];
        }
        return $this->_options;
    }
}

