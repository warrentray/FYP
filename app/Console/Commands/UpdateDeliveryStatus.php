<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Delivery;
use Carbon\Carbon;

class UpdateDeliveryStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:update-delivery-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update delivery statuses based on time elapsed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
   public function handle()
{
    // Get the current date
    $currentDate = now()->toDateString();

    // Query delivery notes with a status of 'Pending'
    $notes = Delivery::where('status', 'Pending')->get();

    foreach ($notes as $note) {
        // Check if the delivery note's date is the same as the current date
        if ($note->date === $currentDate) {
            // Calculate the time elapsed since the delivery note was created
            $timeElapsed = now()->diffInMinutes($note->created_at);

            if ($timeElapsed >= 1 && $note->status === 'Pending') {
                // Change status to 'On Road' after 1 minute
                $note->status = 'On Road';
                $note->save();
            }
        }
    }

    $notes = Delivery::where('status', 'On Road')->get();
    foreach ($notes as $note) {
        // Check if the delivery note's date is the same as the current date
        if ($note->date === $currentDate) {
            // Calculate the time elapsed since the delivery note was created
            $timeElapsed = now()->diffInMinutes($note->created_at);

            if ($timeElapsed >= 15 && $note->status === 'On Road') {
                // Change status to 'Delivered' after 2 minutes
                $note->status = 'Delivered';
                $note->save();
            }
        }
    }
}

}
