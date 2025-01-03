<?php

namespace App\Jobs\Download;

use App\Jobs\Download\Suppressions\BadmailSuppression;
use App\Jobs\Download\Suppressions\ComplaintSuppression;
use App\Jobs\Download\Suppressions\DndSuppression;
use App\Jobs\Download\Suppressions\EspBadmailSuppression;
use App\Jobs\Download\Suppressions\OfferSuppression;
use App\Jobs\Download\Suppressions\OptOutSuppression;
use App\Jobs\Download\Suppressions\UnsubscribeSuppression;
use App\Models\DataDownload;
use App\Models\Suppression;
use App\Models\TempData;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Throwable;

class DataDownloadJob implements ShouldQueue
{
    use Queueable;

    private DataDownload $download;

    /**
     * Create a new job instance.
     */
    public function __construct($download)
    {
        $this->download = $download;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $suppressions = [
                'offer' => OfferSuppression::class,
                'complaints' => ComplaintSuppression::class,
                'optout' => OptOutSuppression::class,
                'unsubsribe' => UnsubscribeSuppression::class,
                'badmail' => BadmailSuppression::class,
                'espbadmail' => EspBadmailSuppression::class,
                'dnd' => DndSuppression::class,
            ];

            $isp = explode('_', $this->download->identifier)[0];

            $sql = sprintf("SELECT * FROM %s_data", $isp);

            TempData::importData($sql);

            TempData::setDataCount($this->download);

            $dataQuery = TempData::query();

            foreach ($suppressions as $name => $suppression) {
                if (!array_key_exists($name, $this->download->suppressions)) continue;
                if (is_callable($suppression)) {
                    if ($name == 'offer') {
                        $suppressionQuery = Suppression::query()->where('type', 'offer')
                            ->where('offer_id', $this->download->offer_id);
                    } else {
                        $suppressionQuery = Suppression::query()->where('type', str_replace('_suppression', '', $name));
                    }

                    (new $suppression($this->download))->handle($dataQuery, $suppressionQuery);
                }
            }

            $outputFile = '/tmp/' . (time()) . '.txt';

            TempData::exportTable($outputFile);

            $this->download->addMedia($outputFile)
                ->preservingOriginal()
                ->toMediaCollection('downloads');

            TempData::truncateTable();

            $this->download->update([
                'status' => 'completed',
            ]);
        } catch (Throwable $ex) {
            $this->download->update([
                'status' => 'failed',
                'error' => $ex->getMessage(),
            ]);

            Log::error($ex->getTraceAsString());
        }
    }
}
