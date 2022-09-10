<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\OfferRepositoryInterface;
use Illuminate\Console\Command;

class DeleteOffersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offers:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete offers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function __construct(
        private OfferRepositoryInterface $offerRepository
    ){
        parent::__construct();
    }

    public function handle()
    {
        $this->offerRepository->forceDeleteOffers();

        return 0;
    }
}
