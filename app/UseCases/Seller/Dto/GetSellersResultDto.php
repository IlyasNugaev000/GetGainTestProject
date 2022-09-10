<?php

declare(strict_types=1);

namespace App\UseCases\Seller\Dto;

use App\Dto\AbstractDto;

class GetSellersResultDto extends AbstractDto
{
    protected int $sellerId;
    protected string $sellerName;
}
