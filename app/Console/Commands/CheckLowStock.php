<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\stock;
use App\Models\delivery;

class CheckLowStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:check-low';

    protected $description = 'Check low stock and generate delivery notes';
  
    public function handle()
    {
        app('App\Http\Controllers\stockController')->checkLowStock();

    }
    protected $commands = [
        \App\Console\Commands\CheckLowStock::class,
    ];
}
