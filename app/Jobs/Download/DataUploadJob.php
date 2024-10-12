<?php

namespace App\Jobs\Download;

use App\Models\Data;
use Generator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class DataUploadJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, Dispatchable;

    private array $params;

    /**
     * Create a new job instance.
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filename = $this->params['filename'];

        foreach ($this->process($filename) as $extracted) {
            $this->validate($extracted);

            Data::query()->create($extracted);
        }
    }

    private function process($filename): Generator
    {
        $file = fopen($filename, 'r');

        while ($line = trim(fgets($file))) {
            $fields = [
                'emid',
                'email',
                'ds',
                'isp',
                'edate',
                'e_ip',
                'fname',
                'lname',
                'suburl',
                'subdate',
                'click',
                'open',
                'flag'
            ];
            $extracted = explode('|', $line);
            yield array_combine($fields, $extracted);
        }

        fclose($file);
    }

    private function validate($data) {}
}
