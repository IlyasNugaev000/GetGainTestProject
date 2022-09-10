<?php

namespace App\Http\Controllers;

use App\UseCases\Seller\Dto\GetSellersEntryDto;
use App\UseCases\Seller\GetSellersHandler;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function getSellers(GetSellersHandler $handler, Request $request, int $id): Response
    {
        $entryDto = $this->dtoFactory->createDto(GetSellersEntryDto::class,
            array_merge($request->all(), ['productId'=> $id]));

        $resultDtoArray = $handler->handle($entryDto);

        return response()->api($resultDtoArray);
    }
}
