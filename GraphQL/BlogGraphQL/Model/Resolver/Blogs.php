<?php

declare(strict_types=1);

namespace EY\BlogGraphQL\Model\Resolver;

use EY\BlogGraphQL\Api\BlogRepositoryInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder as SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Blogs implements ResolverInterface
{

    /**
     * @var GetListInterface
     */
    private $blogRepository;
    /**
     * @var blogDataProvider
     */
    private $blogDataProvider;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * BlogList constructor.
     * @param GetList $blogRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        BlogRepositoryInterface $blogRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder)
    {
        $this->blogRepository = $blogRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {

        $this->vaildateArgs($args);
        $searchCriteria = $this->searchCriteriaBuilder->build('eyblog', $args);
        $searchCriteria->setCurrentPage($args['currentPage']);
        $searchCriteria->setPageSize($args['pageSize']);
        $searchResult = $this->blogRepository->getList($searchCriteria);


        foreach ($searchResult->getItems() as $item){
            $status = $item->getStatus();
            $item->setStatus("Inactive");
            if($status == 1){
                $item->setStatus("Active");
            }
        }
        //exit;

        return [
            'total_count' => $searchResult->getTotalCount(),
            'posts' => $searchResult->getItems(),
        ];
    }

    /**
     * @param array $args
     * @throws GraphQlInputException
     */
    private function vaildateArgs(array $args): void
    {
        if (isset($args['currentPage']) && $args['currentPage'] < 1) {
            throw new GraphQlInputException(__('currentPage value must be greater than 0.'));
        }

        if (isset($args['pageSize']) && $args['pageSize'] < 1) {
            throw new GraphQlInputException(__('pageSize value must be greater than 0.'));
        }
    }
}
