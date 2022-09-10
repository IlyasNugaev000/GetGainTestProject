<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Offer;
use App\UseCases\Offer\Dto\OfferEntryDto;

interface OfferRepositoryInterface
{
    public function getOffers(OfferEntryDto $entryDto): ?iterable;

    public function getSellerIdByOfferId(int $offerId): ?object;

    public function softDeleteOfferById(int $id): void;

    public function restoreOfferById(int $id): void;

    public function save(Offer $offer): void;
}
