<?php

namespace App\Jobs;

use App\Models\Dataset;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCsvImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 1800;// 30 minutes
    private $csvFilePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($csvFilePath)
    {
        $this->csvFilePath = $csvFilePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Open the CSV file for reading
        Log::info($this->csvFilePath);
        $filepath = storage_path('app/'.$this->csvFilePath);
        $file = fopen($filepath, 'r');

        // Skip the first row (header)
        fgetcsv($file);
        $i = 0;
        // Read and process each row of the CSV file
        while (($row = fgetcsv($file)) !== false) {
            // Save the dataset model to the database
            Dataset::updateOrCreate(
                [
                    'email' => $row[3]
                ],
                [
                    'category' => $row[0],
                    'firstname' => $row[1],
                    'lastname' => $row[2],
                    'gender' => $row[4],
                    'birthDate' => $row[5]
                ]
            );
            $i++;
        }

        // Close the CSV file
        fclose($file);

        Log::info('CSV file imported successfully. Rows added: ' . $i);
    }
}
