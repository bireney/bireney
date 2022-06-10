<?php

declare(strict_types=1);

namespace EY\BlogGraphQL\Model;

use EY\BlogGraphQL\Api\Data\BlogInterface;
use EY\BlogGraphQL\Api\Data\BlogInterfaceFactory;
use EY\BlogGraphQL\Api\BlogRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;

class CreateBlog
{

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;
    /**
     * @var BlogRepositoryInterface
     */
    private $blogRepository;
    /**
     * @var BlogInterfaceFactory
     */
    private $blogFactory;

    /**
     * @param DataObjectHelper $dataObjectHelper
     * @param BlogRepositoryInterface $blogRepository
     * @param BlogInterfaceFactory $blogInterfaceFactory
     */
    public function __construct(
        DataObjectHelper $dataObjectHelper,
        BlogRepositoryInterface $blogRepository,
        BlogInterfaceFactory $blogInterfaceFactory
    ) {
        $this->dataObjectHelper = $dataObjectHelper;
        $this->blogRepository = $blogRepository;
        $this->blogFactory = $blogInterfaceFactory;
    }

    /**
     * @param array $data
     * @return BlogInterface
     * @throws GraphQlInputException
     */
    public function execute(array $data): BlogInterface
    {
        try {
            $this->vaildateData($data);
            $blog = $this->createBlog($data);
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }

        return $blog;
    }

    /**
     * Guard function to handle bad request.
     * @param array $data
     * @throws LocalizedException
     */
    private function vaildateData(array $data)
    {
        if (!isset($data[BlogInterface::NAME])) {
            throw new LocalizedException(__('Name must be set'));
        }
    }

    /**
     * @param array $data
     * @return BlogInterface
     * @throws CouldNotSaveException
     */
    private function createBlog(array $data): BlogInterface
    {
        /** @var BlogInterface $blogDataObject */
        $blogDataObject = $this->blogFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $blogDataObject,
            $data,
            BlogInterface::class
        );

        $this->blogRepository->save($blogDataObject);

        return $blogDataObject;
    }
}
