<?php

declare(strict_types=1);

namespace App\UseCases\Seller\Dto;

use App\Dto\AbstractDto;

class GetSellersEntryDto extends AbstractDto
{
    protected int $productId;
    protected ?int $offset = null;
    protected ?int $limit = null;

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
