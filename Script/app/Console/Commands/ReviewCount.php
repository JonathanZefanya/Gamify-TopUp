<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\Review;
use App\Models\TopUp;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReviewCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:review-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Review and average review count';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all reviewable IDs for TopUp and Card in a single query
        $reviewableIds = DB::table('reviews')->where('status', 1)
            ->where('created_at', '>', Carbon::now()->subHours(2))
            ->whereIn('reviewable_type', [TopUp::class, Card::class])
            ->select('reviewable_id', 'reviewable_type')
            ->get()
            ->groupBy('reviewable_type');

        $topUpIds = isset($reviewableIds[TopUp::class]) ? $reviewableIds[TopUp::class]->pluck('reviewable_id')->toArray() : [];
        $cardIds = isset($reviewableIds[Card::class]) ? $reviewableIds[Card::class]->pluck('reviewable_id')->toArray() : [];

        $reviewStats = Review::selectRaw('reviewable_type, reviewable_id, COUNT(*) as total_reviews, AVG(rating) as average_rating')
            ->where('status', 1)
            ->whereIn('reviewable_type', [TopUp::class, Card::class])
            ->whereIn('reviewable_id', array_merge($topUpIds, $cardIds))
            ->groupBy('reviewable_type', 'reviewable_id')
            ->get()
            ->keyBy(function ($item) {
                return $item->reviewable_type . '_' . $item->reviewable_id;
            });

        DB::table('top_ups')->whereIn('id', $topUpIds)->get()->each(function ($topUp) use ($reviewStats) {
            $key = TopUp::class . '_' . $topUp->id;
            if (isset($reviewStats[$key])) {
                DB::table('top_ups')
                    ->where('id', $topUp->id)
                    ->update([
                        'total_review' => $reviewStats[$key]->total_reviews,
                        'avg_rating' => $reviewStats[$key]->average_rating,
                    ]);
            }
        });

        // Update Card records
        DB::table('cards')->whereIn('id', $cardIds)->get()->each(function ($card) use ($reviewStats) {
            $key = Card::class . '_' . $card->id;
            if (isset($reviewStats[$key])) {
                DB::table('cards')
                    ->where('id', $card->id)
                    ->update([
                        'total_review' => $reviewStats[$key]->total_reviews,
                        'avg_rating' => $reviewStats[$key]->average_rating,
                    ]);
            }
        });
    }
}
