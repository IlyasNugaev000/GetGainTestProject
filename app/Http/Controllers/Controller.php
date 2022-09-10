<?php

namespace App\Http\Controllers;

use App\Dto\DtoFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected DtoFactory $dtoFactory;

    public function __construct(DtoFactory $dtoFactory)
    {
        $this->dtoFactory = $dtoFactory;
    }
}
