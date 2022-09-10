<?php

declare(strict_types=1);

namespace App\UseCases\Offer\Dto;

use App\Dto\AbstractDto;

/**
 * @OA\Schema()
 */
class OfferEntryDto extends AbstractDto
{
    protected ?int $offset = null;
    protected ?int $limit = null;
    protected ?string $productName = null;
    protected ?string $partProductName = null;
    protected ?float $maxPrice = null;
    protected ?bool $priceByAsc = null;
    protected ?bool $byNovelty = null;

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function getPartProductName(): ?string
    {
        return $this->partProductName;
    }

    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }

    public function getPriceByAsc(): ?bool
    {
        return $this->priceByAsc;
    }

    public function getByNovelty(): ?bool
    {
        return $this->byNovelty;
    }
}
