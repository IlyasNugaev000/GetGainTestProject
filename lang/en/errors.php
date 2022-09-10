<?php

use App\Exceptions\ApiException;

return [
    ApiException::HTTP_BAD_REQUEST => 'Bad request data',

    ApiException::OFFER_NOT_BELONG_USER => "Offer does not belong user",
];
