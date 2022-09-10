<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\AvailableCarsNotFoundException;
use App\Exceptions\CarNotBelongUserException;
use App\Exceptions\CarNotFoundException;
use App\Exceptions\OfferNotBelongUserException;
use App\Exceptions\UserNotFoundException;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\UseCases\Offer\AddUserCarHandler;
use App\UseCases\Offer\RestoreOfferHandler;
use App\UseCases\Offer\SoftDeleteOfferHanlder;
use App\UseCases\Offer\Dto\OfferEntryDto;
use App\UseCases\Offer\GetAvailableCarsHandler;
use App\UseCases\Offer\GetOffersHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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

    /**
     * @OA\Delete(
     *     path="/api/user/{id}/car/{car_id}",
     *     tags={"cars"},
     *     summary="Удаление машины у пользователя",
     *     @OA\Parameter(name="id", required=true, in="path"),
     *     @OA\Parameter(name="car_id", required=true, in="path"),
     *     @OA\Response(
     *         response="200",
     *         description="Success"
     *     )
     * )
     *
     * @throws ApiException
     */
    public function deleteUserCar(string $userId, string $carId, SoftDeleteOfferHanlder $handler): Response
    {
        try {
            $handler->handle($userId, $carId);
        } catch (CarNotFoundException $e) {
            throw ApiException::generate(ApiException::CAR_NOT_FOUND);
        } catch (CarNotBelongUserException $e) {
            throw ApiException::generate(ApiException::CAR_NOT_BELONG_USER);
        }

        return response()->api();
    }
}
