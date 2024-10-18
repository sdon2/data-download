<?php

namespace App\Jobs\Download;

use App\Models\Suppression;
use App\Models\SuppressionUpload;
use Generator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class SuppressionUploadJob implements ShouldQueue
{
    use Queueable;

    private SuppressionUpload $suppressionUpload;

    private $sleepTime = false;

    /**
     * Create a new job instance.
     */
    public function __construct(SuppressionUpload $suppressionUpload)
    {
        $this->suppressionUpload = $suppressionUpload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filename = $this->suppressionUpload->getFirstMedia('suppression-uploads')->getPath();

        try {
            foreach ($this->process($filename) as $line) {

                $this->validate($line);

                Suppression::query()->create([
                    'type' => $this->suppressionUpload->type,
                    'offer_id' => $this->suppressionUpload->offer_id,
                    'data' => $line,
                ]);

                $this->suppressionUpload->update([
                    'count' => $this->suppressionUpload->count + 1,
                    'status' => 'processing',
                ]);
            }

            $this->suppressionUpload->update([
                'status' => 'completed',
            ]);
        } catch (Throwable $ex) {
            $this->suppressionUpload->update([
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

                if ($line) {
                    yield $line;
                } else {
                    new DataException('Invalid data format');
                }
            } catch (Throwable $ex) {
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
