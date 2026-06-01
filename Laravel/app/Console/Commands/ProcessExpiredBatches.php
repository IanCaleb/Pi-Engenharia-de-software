<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Batch;
use App\Models\Movement;

class ProcessExpiredBatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-expired-batches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredBatches = Batch::whereDate(
            'expiration_date',
            '<',
            now()
        )
        ->where('quantity', '>', 0)
        ->get();

        foreach ($expiredBatches as $batch) {

            Movement::create([
                'product_id' => $batch->product_id,
                'batch_id' => $batch->id,
                'movement_type' => 'Expiração',
                'moved_quantity' => $batch->quantity,
                'unit_price' => 0,
                'movement_date' => now(),
            ]);

            $batch->update([
                'quantity' => 0,
            ]);
        }
    }
}
