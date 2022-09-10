<?php

namespace App\Exceptions;

use Exception, Throwable;

class OfferNotBelongUserException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Offer does not belong user");
    }
}
