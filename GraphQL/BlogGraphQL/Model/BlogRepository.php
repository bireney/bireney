<?php

declare(strict_types=1);

namespace EY\BlogGraphQL\Model;

use EY\BlogGraphQL\Api\Data\BlogInterface;
use EY\BlogGraphQL\Api\BlogRepositoryInterface;
use EY\BlogGraphQL\Model\ResourceModel\Blog as BlogResourceModel;
use EY\BlogGraphQL\Model\ResourceModel\BlogCollection;
use EY\BlogGraphQL\Model\ResourceModel\BlogCollectionFactory;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;

class BlogRepository implements BlogRepositoryInterface
{
    /**
     * @var BlogCollectionFactory
     */
    private $blogCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var SearchResultsInterfaceFactory
     */
    private $blogSearchResultsInterfaceFactory;
    /**
     * @var BlogResourceModel
     */
    private $blogResourceModel;

    public function __construct(
        BlogCollectionFactory $blogCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SearchResultsInterfaceFactory $blogSearchResultsInterfaceFactory,
        BlogResourceModel $blogResourceModel
    ) {
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->blogSearchResultsInterfaceFactory = $blogSearchResultsInterfaceFactory;
        $this->blogResourceModel = $blogResourceModel;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        /** @var BlogCollection $blogCollection */
        $blogCollection = $this->blogCollectionFactory->create();
        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $blogCollection);
        }
        /** @var SearchResultsInterface $searchResult */
        $searchResult = $this->blogSearchResultsInterfaceFactory->create();
        $searchResult->setItems($blogCollection->getItems());
        $searchResult->setTotalCount($blogCollection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }

    /**
     * @inheritDoc
     */
    public function save(BlogInterface $blog): void
    {
        try {
            $this->blogResourceModel->save($blog);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save Source'), $e);
        }
    }
}
