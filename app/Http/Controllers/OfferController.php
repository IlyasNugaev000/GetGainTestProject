<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\OfferNotBelongUserException;
use App\UseCases\Offer\RestoreOfferHandler;
use App\UseCases\Offer\SoftDeleteOfferHanlder;
use App\UseCases\Offer\Dto\OfferEntryDto;
use App\UseCases\Offer\GetOffersHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    public function getOffers(GetOffersHandler $handler, Request $request): Response
    {
        $entryOfferDto = $this->dtoFactory->createDto(OfferEntryDto::class, $request->all());
        $resultDtoArray = $handler->handle($entryOfferDto);

        return response()->api($resultDtoArray);
    }

    public function softDeleteOffer(SoftDeleteOfferHanlder $handler, int $id): Response
    {
        try {
            $handler->handle($id);
        } catch (OfferNotBelongUserException $e) {
            throw ApiException::generate(ApiException::OFFER_NOT_BELONG_USER);
        }

        return response()->api();
    }

    public function restoreOffer(RestoreOfferHandler $handler, string $id): Response
    {
        try {
            $handler->handle($id);
        } catch (OfferNotBelongUserException $e) {
            throw ApiException::generate(ApiException::OFFER_NOT_BELONG_USER);
        }

        return response()->api();
    }
}
