<?php

declare(strict_types=1);

namespace EY\BlogGraphQL\Model\ResourceModel;

use EY\BlogGraphQL\Model\ResourceModel\Blog as BlogResourceModel;
use EY\BlogGraphQL\Model\Blog as BlogModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class BlogCollection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(BlogModel::class, BlogResourceModel::class);
    }
}
