<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Offer;
use App\Models\Seller;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\UseCases\Offer\Dto\OfferEntryDto;
use Carbon\Carbon;

class OfferRepositoryEloquent implements OfferRepositoryInterface
{
    public function __construct
    (
       private Offer $offer
    ) {
    }

    public function getOffers(OfferEntryDto $entryDto): ?iterable
    {
        return $this->offer
            ->select(
                'products.name as productName',
                'products.description as productDescription',
                'products.image as productImage',
                'price as offerPrice',
                'quantity as offerQuantity',
                'sellers.name as sellerName',
            )
            ->join('sellers', 'offers.seller_id', 'sellers.id')
            ->join('products', 'offers.product_id', 'products.id')
            ->when($entryDto->getProductName() !== null, function ($query) use($entryDto) {
                return $query->where('products.name', $entryDto->getProductName());
            })
            ->when($entryDto->getPartProductName() !== null, function ($query) use($entryDto) {
                return $query->where('products.name', "like", "%" . $entryDto->getPartProductName() . "%");
            })
            ->when($entryDto->getMaxPrice() !== null, function ($query) use($entryDto) {
                return $query->where('price', '<=', $entryDto->getMaxPrice());
            })
            ->when($entryDto->getPriceByAsc() === true, function ($query) use($entryDto) {
                return $query->orderBy('price');
            })
            ->when($entryDto->getByNovelty() === true, function ($query) use($entryDto) {
                return $query->orderBy('offers.created_at', 'desc');
            })
            ->when($entryDto->getOffset() !== null, function ($query) use($entryDto) {
                return $query->offset($entryDto->getOffset());
            })
            ->when($entryDto->getLimit() !== null, function ($query) use($entryDto) {
                return $query->limit($entryDto->getLimit());
            })
            ->get();
    }

    public function getSellerIdByOfferId(int $offerId): ?Offer
    {
        return $this->offer->select('seller_id as sellerId')->where('id', $offerId)->withTrashed()->first();
    }

    public function softDeleteOfferById(int $id): void
    {
        $this->offer->where('id', $id)->delete();
    }

    public function forceDeleteOffers(): void
    {
        $this->offer->whereDate('deleted_at',  '<', Carbon::now()->subHours(24)->toDateString())->forceDelete();
    }

    public function restoreOfferById(int $id): void
    {
        $this->offer->where('id', $id)->restore();
    }

    public function save(Offer $offer): void
    {
        $offer->save();
    }
}
