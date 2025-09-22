<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CodeSendBuyer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    /**
     * Create a new job instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = $this->order;
        $orderStatus = 1;
        foreach ($order->orderDetails as $detail) {
            $service = $detail->detailable;
            if (!$service) {
                continue;
            }

            $codeLists = $service->codes()->where('status', 1)->take($detail->qty)->get(['id', 'status', 'passcode']);
            $sendCodeList = $codeLists->pluck('passcode');
            $stock_short = max(0, $detail->qty - count($sendCodeList));

            $detail->card_codes = $sendCodeList;
            $detail->stock_short = $stock_short;
            $detail->status = ($stock_short == 0) ? 1 : 3;
            $detail->save();

            if ($stock_short) {
                $orderStatus = 3;
            }

            $codeLists->each(function ($code) {
                $code->delete();
            });

            $this->addedSellList($service->card()->select(['id', 'sell_count'])->first());
        }

        $order->status = $orderStatus;
        $order->save();
    }

    public function addedSellList($card): void
    {
        if ($card) {
            $card->sell_count += 1;
            $card->save();
        }
    }
}
