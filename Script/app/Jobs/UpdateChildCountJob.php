<?php

namespace App\Jobs;

use App\Models\Card;
use App\Models\Category;
use App\Models\Game;
use App\Models\TopUp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateChildCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $categoryId;
    public $type;

    /**
     * Create a new job instance.
     */
    public function __construct($categoryId, $type)
    {
        $this->categoryId = $categoryId;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $activeChildren = 0;
        switch ($this->type) {
            case 'card':
                $activeChildren = Card::where('category_id', $this->categoryId)
                    ->where('status', 1)->whereHas('activeServices')->count();
                break;

            case 'top_up':
                $activeChildren = TopUp::where('category_id', $this->categoryId)
                    ->where('status', 1)->whereHas('activeServices')->count();
                break;
        }

        Category::where('id', $this->categoryId)->update([
            'active_children' => $activeChildren,
        ]);
    }
}
