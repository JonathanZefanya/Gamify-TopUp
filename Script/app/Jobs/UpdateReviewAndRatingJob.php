<?php

namespace App\Jobs;

use App\Models\Review;
use App\Models\TopUp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateReviewAndRatingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $rating;
    private $model;
    private $item;

    /**
     * Create a new job instance.
     */
    public function __construct($rating , $model, $item)
    {
        $this->rating = $rating;
        $this->model = $model;
        $this->item = $item;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $reviewData = Review::where('reviewable_id', $this->item)
            ->where('reviewable_type', $this->model)
            ->selectRaw('COUNT(*) as total, AVG(rating) as avg_rating')
            ->first();

        $totalReviews = $reviewData->total ?? 0;
        $avgRating = $reviewData->avg_rating ?? 0;
        $topup = TopUp::find($this->item);
        if ($topup) {
            $topup->total_review = $totalReviews;
            $topup->avg_rating = $avgRating;
            $topup->save();
        }
    }
}
