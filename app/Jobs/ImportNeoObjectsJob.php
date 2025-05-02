<?php

namespace App\Jobs;

use App\Collections\NasaNeoDataCollection;
use App\Contracts\NeoReadRepositoryInterface;
use App\Contracts\NeoWriteRepositoryInterface;
use App\Repositories\NasaNeoReadRepository;
use App\Repositories\NasaNeoWriteRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ImportNeoObjectsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Carbon $date
    ) {}

    /**
     * @throws \Throwable
     */
    public function handle(
        NeoReadRepositoryInterface $readRepo,
        NeoWriteRepositoryInterface  $writeRepo
    ): void
    {
        $data = $readRepo->getDataForDateRange($this->date, $this->date);

        $writeRepo->storeBatch($data);
    }
}
