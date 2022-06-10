<?php

declare(strict_types=1);

namespace EY\BlogGraphQL\Model;

use EY\BlogGraphQL\Api\Data\BlogInterface;
use EY\BlogGraphQL\Model\ResourceModel\Blog as BlogResourceModel;
use Magento\Framework\Model\AbstractExtensibleModel;

class Blog extends AbstractExtensibleModel implements BlogInterface
{

    protected function _construct()
    {
        $this->_init(BlogResourceModel::class);
    }

    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    public function setName(?string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    public function setContent(?string $content): void
    {
        $this->setData(self::CONTENT, $content);
    }

    public function getStatus(): ?string
    {
        return $this->getData(self::STATUS);
    }

    public function setStatus(?string $status): void
    {
        $this->setData(self::STATUS, $status);
    }

    public function getAuthorName(): ?string
    {
        return $this->getData(self::AUTHOR_NAME);
    }

    public function setAuthorName(?string $author_name): void
    {
        $this->setData(self::AUTHOR_NAME, $author_name);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(?string $created_at): void
    {
        $this->setData(self::CREATED_AT, $created_at);
    }

    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt(?string $updated_at): void
    {
        $this->setData(self::UPDATED_AT, $updated_at);
    }
}
