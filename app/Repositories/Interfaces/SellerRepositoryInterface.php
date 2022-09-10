<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\UseCases\Seller\Dto\GetSellersEntryDto;

interface SellerRepositoryInterface
{
    public function getSellersByProductId(GetSellersEntryDto $entryDto): ?iterable;
}
