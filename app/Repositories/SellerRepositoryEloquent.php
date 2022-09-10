<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Seller;
use App\Repositories\Interfaces\SellerRepositoryInterface;
use App\UseCases\Seller\Dto\GetSellersEntryDto;

class SellerRepositoryEloquent implements SellerRepositoryInterface
{
    public function __construct
    (
        private Seller $seller
    ) {
    }

    public function getSellersByProductId(GetSellersEntryDto $entryDto): ?iterable
    {
        return $this->seller
            ->select('sellers.id as sellerId', 'sellers.name as sellerName')
            ->join('offers', 'sellers.id', 'offers.seller_id')
            ->join('products', 'products.id', 'offers.product_id')
            ->where('offers.product_id', $entryDto->getProductId())
            ->when($entryDto->getOffset() !== null, function ($query) use($entryDto) {
                return $query->offset($entryDto->getOffset());
            })
            ->when($entryDto->getLimit() !== null, function ($query) use($entryDto) {
                return $query->limit($entryDto->getLimit());
            })
            ->get();
    }
}
