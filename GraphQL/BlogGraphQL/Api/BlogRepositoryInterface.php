<?php

declare(strict_types=1);

namespace EY\BlogGraphQL\Api;

use EY\BlogGraphQL\Api\Data\BlogInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 */
interface BlogRepositoryInterface
{
    /**
     * Save the Blog data.
     *
     * @param \Magento\InventoryApi\Api\Data\SourceInterface $source
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(BlogInterface $blog): void;

    /**
     * Find Blog by given SearchCriteria
     * SearchCriteria is not required because load all blogs is useful case
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Magento\InventoryApi\Api\Data\SourceSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface;
}
