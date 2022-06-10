<?php

declare(strict_types=1);

namespace EY\BlogGraphQL\Model\Resolver;

use EY\BlogGraphQL\Model\CreateBlog as CreatBlogService;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class CreateEyBlogs implements ResolverInterface
{
    /**
     * @var CreatBlogService
     */
    private $creatBlog;

    /**
     * @param CreateBlog $creatBlog
     */
    public function __construct(CreatBlogService $creatBlog)
    {
        $this->creatBlog = $creatBlog;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        return ['blog' => $this->creatBlog->execute($args['input'])];
    }
}
