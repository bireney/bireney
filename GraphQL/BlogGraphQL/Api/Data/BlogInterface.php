<?php

declare(strict_types=1);

namespace EY\BlogGraphQL\Api\Data;

/**
 * Represents a blog and properties
 *
 * @api
 */
interface BlogInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const NAME = 'name';
    const CONTENT = 'content';
    const STATUS = 'status';
    const AUTHOR_NAME = 'author_name';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**#@-*/

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getContent(): ?string;

    public function setContent(?string $content): void;

    public function getStatus(): ?string;

    public function setStatus(?string $status): void;

    public function getAuthorName(): ?string;

    public function setAuthorName(?string $author_name): void;

    public function getCreatedAt(): ?string;

    public function setCreatedAt(?string $created_at): void;

    public function getUpdatedAt(): ?string;

    public function setUpdatedAt(?string $updated_at): void;
}
