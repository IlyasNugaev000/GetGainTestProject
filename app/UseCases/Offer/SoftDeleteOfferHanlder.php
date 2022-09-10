<?php

declare(strict_types=1);

namespace App\UseCases\Offer;

use App\Dto\DtoFactory;
use App\Exceptions\CarNotBelongUserException;
use App\Exceptions\CarNotFoundException;
use App\Exceptions\OfferNotBelongUserException;
use App\Models\Car;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\Services\OfferService;
use App\UseCases\Offer\Dto\AvailableCarsResultDto;
use Illuminate\Support\Facades\Auth;

class SoftDeleteOfferHanlder
{
    public function __construct(
        private OfferRepositoryInterface $offerRepository
    ) {
    }

    public function handle(int $offerId): void
    {
        $offerInstance = $this->offerRepository->getSellerIdByOfferId($offerId);

        if (Auth::id() !== $offerInstance->sellerId) {
            throw new OfferNotBelongUserException();
        }

        $this->offerRepository->softDeleteOfferById($offerId);
    }
}
