<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace EY\ProductBrandGraph\Model\Resolver\Product;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Query\ResolverInterface;


/**
 * Orders data reslover
 */
class AddBrandAttribute implements ResolverInterface
{

    /**
     * @var ProductRepository
     */
    protected $productRepository;



    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        \Magento\Framework\GraphQl\Config\Element\Field $field,
                                                        $context,
        \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info,
        array $value = null,
        array $args = null
    )
    {
        if (!isset($value['entity_id'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }

        $product =  $this->productRepository->getById($value['entity_id']);
        $attr = $product->getResource()->getAttribute('brand');
        if ($attr->usesSource()) {
            if($product->getData('brand')){
                $optionText = $attr->getSource()->getOptionText($product->getData('brand'));
                return $optionText;
            }
        }
    }
}
