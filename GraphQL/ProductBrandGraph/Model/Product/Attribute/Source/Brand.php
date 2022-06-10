<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace EY\ProductBrandGraph\Model\Product\Attribute\Source;

class Brand extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [
        ['value' => '', 'label' => __('Select Brands')],
        ['value' => 1, 'label' => __('Brand1')],
        ['value' => 2, 'label' => __('Brand2')],
        ['value' => 3, 'label' => __('Brand3')]
        ];
        return $this->_options;
    }
}

