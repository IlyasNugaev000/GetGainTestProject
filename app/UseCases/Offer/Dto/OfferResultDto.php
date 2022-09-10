<?php

declare(strict_types=1);

namespace App\UseCases\Offer\Dto;

use App\Dto\AbstractDto;

class OfferResultDto extends AbstractDto
{
    protected string $productName;

    protected string $productDescription;

    protected string $productImage;

    protected float $offerPrice;

    protected int $offerQuantity;

    protected string $sellerName;
}
