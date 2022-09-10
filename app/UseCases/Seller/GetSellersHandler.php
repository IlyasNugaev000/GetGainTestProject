<?php

namespace App\UseCases\Seller;

use App\Dto\DtoFactory;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\Repositories\Interfaces\SellerRepositoryInterface;
use App\Repositories\SellerRepositoryEloquent;
use App\UseCases\Seller\Dto\GetSellersEntryDto;
use App\UseCases\Seller\Dto\GetSellersResultDto;

class GetSellersHandler
{
    public function __construct(
        private SellerRepositoryInterface $offerRepository,
        private DtoFactory $dtoFactory
    ) {
    }

    public function handle(GetSellersEntryDto $entryDto)
    {
        $sellers = $this->offerRepository->getSellersByProductId($entryDto);

        $resultDtoArray = [];

        foreach ($sellers as $seller)
        {
            $resultDtoArray[] = $this->dtoFactory->createDto(GetSellersResultDto::class,
                [
                    'sellerId' => $seller->sellerId,
                    'sellerName' => $seller->sellerName
                ]
            );
        }

        return $resultDtoArray;
    }
}
