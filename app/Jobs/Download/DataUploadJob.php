<?php

namespace App\Jobs\Download;

use App\Models\Data;
use App\Models\DataUpload;
use Exception;
use Generator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;

class DataUploadJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, Dispatchable;

    private DataUpload $dataUpload;

    private $sleepTime = false;

    /**
     * Create a new job instance.
     */
    public function __construct(DataUpload $dataUpload)
    {
        $this->dataUpload = $dataUpload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filename = $this->dataUpload->getFirstMedia('data-uploads')->getPath();

        try {
            foreach ($this->process($filename) as $extracted) {

                $this->validate($extracted);

                Data::query()->create($extracted);

                $this->dataUpload->update([
                    'count' => $this->dataUpload->count + 1,
                    'status' => 'processing',
                ]);
            }

            $this->dataUpload->update([
                'status' => 'completed',
            ]);
        } catch (Throwable $ex) {
            $this->dataUpload->update([
                'status' => 'failed',
                'error' => $ex->getMessage(),
            ]);
        }
    }

    private function process($filename): Generator
    {
        $file = fopen($filename, 'r');

        while (!feof($file)) {

            try {

                $line = trim(fgets($file));

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
                    'flag',
                    'identifier',
                ];
                $extracted = explode('|', $line);
                array_push($extracted, str_replace('.txt', '', $this->dataUpload->filename));

                if (count($extracted) !== count($fields)) {
                    throw new DataException('Invalid data format');
                }

                yield array_combine($fields, $extracted);
            } catch (DataException $ex) {
                continue;
            }
        }

        fclose($file);

        if ($this->sleepTime) {
            sleep($this->sleepTime);
        }
    }

    private function validate($data) {}
}
