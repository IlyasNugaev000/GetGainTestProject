<?php

declare(strict_types=1);

namespace App\UseCases\Offer;

use App\Dto\AbstractDto;
use App\Dto\DtoFactory;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\UseCases\Offer\Dto\OfferResultDto;
use App\UseCases\Offer\Dto\OfferEntryDto;

class GetOffersHandler
{
    public function __construct(
        private OfferRepositoryInterface $offerRepository,
        private DtoFactory               $dtoFactory
    ) {
    }

    public function handle(OfferEntryDto $entryDto): array
    {
        $offers = $this->offerRepository->getOffers($entryDto);

        $resultDtoArray = [];

        foreach ($offers as $offer)
        {
            $resultDtoArray[] = $this->dtoFactory->createDto(OfferResultDto::class,
                [
                    'productName' => $offer->productName,
                    'productDescription' => $offer->productDescription,
                    'productImage' => $offer->productImage,
                    'offerPrice' => $offer->offerPrice,
                    'offerQuantity' => $offer->offerQuantity,
                    'sellerName' => $offer->sellerName
                ]);
        }

        return $resultDtoArray;
    }
}
