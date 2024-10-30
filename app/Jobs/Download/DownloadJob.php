<?php

namespace App\Jobs\Download;

use App\Jobs\Download\Suppressions\BadmailSuppression;
use App\Jobs\Download\Suppressions\ComplaintSuppression;
use App\Jobs\Download\Suppressions\DndSuppression;
use App\Jobs\Download\Suppressions\EspBadmailSuppression;
use App\Jobs\Download\Suppressions\OfferSuppression;
use App\Jobs\Download\Suppressions\OptOutSuppression;
use App\Jobs\Download\Suppressions\UnsubscribeSuppression;
use App\Models\Data;
use App\Models\Download;
use App\Models\Suppression;
use App\Traits\InteractsWithTempTable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DownloadJob implements ShouldQueue
{
    use Queueable;

    private Download $download;

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
        $suppressions = [
            'offer_suppression' => OfferSuppression::class,
            'complaints_suppression' => ComplaintSuppression::class,
            'optout_suppression' => OptOutSuppression::class,
            'unsubsribe_suppression' => UnsubscribeSuppression::class,
            'badmail_suppression' => BadmailSuppression::class,
            'espbadmail_suppression' => EspBadmailSuppression::class,
            'dnd_suppression' => DndSuppression::class,
        ];

        foreach ($suppressions as $name => $suppression) {
            if (is_callable($suppression)) {
                $dataClass = (new class {
                    use InteractsWithTempTable;
                });

                $dataQuery = $dataClass
                    ->createTable($this->download->identifier, "SELECT * FROM data WHERE identifier = '" . $this->download->identifier . "'")
                    ->getModel()->query();

                    if ($name == 'offer_suppression') {
                        $suppressionQuery = Suppression::query()->where('type', 'offer')
                            ->where('offer_id', $this->download->offer_id);
                    } else {
                        $suppressionQuery = Suppression::query()->where('type', str_replace('_suppression', '', $name));
                    }

                (new $suppression())->handle($this->download, $dataQuery, $suppressionQuery);
            }
        }
    }
}
