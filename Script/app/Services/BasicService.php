<?php

namespace App\Services;

use App\Models\Deposit;
use App\Models\Order;
use App\Models\Payout;
use App\Models\Transaction;
use App\Traits\MakeOrder;
use App\Traits\Notify;

class BasicService
{
    use Notify, MakeOrder;

    public function setEnv($value)
    {
        $envPath = base_path('.env');
        $env = file($envPath);
        foreach ($env as $env_key => $env_value) {
            $entry = explode("=", $env_value, 2);
            $env[$env_key] = array_key_exists($entry[0], $value) ? $entry[0] . "=" . $value[$entry[0]] . "\n" : $env_value;
        }
        $fp = fopen($envPath, 'w');
        fwrite($fp, implode($env));
        fclose($fp);
    }

    public function preparePaymentUpgradation($deposit): void
    {
        try {
            if ($deposit->status == 0 || $deposit->status == 2) {
                $deposit->status = 1;
                $deposit->save();

                if ($deposit->depositable_type == Order::class) {
                    $order = $deposit->depositable;
                    if ($order) {
                        $this->orderCompleteAction($order, $deposit);
                    }
                } elseif (!$deposit->depositable_type) {
                    $user = $deposit->user;
                    $user->balance += $deposit->amount_in_base;
                    $user->save();

                    $this->makeTransaction($user->id, $deposit->amount_in_base, '+', $deposit->trx_id, 'Add Fund Via ' . $deposit->gateway?->name, $deposit->id, Deposit::class);
                    $this->notifyToAll($deposit);
                }
            }
        } catch (\Exception $e) {

        }
    }

    public function makeTransaction($userId, $amount, $trxType, $trxId, $remark, $transactionalId = null, $transactionalType = null, $charge_in_base_currency = null)
    {
        $transaction = new Transaction();
        $transaction->user_id = $userId;
        $transaction->amount_in_base = $amount;
        $transaction->trx_type = $trxType;
        $transaction->remarks = $remark;
        $transaction->transactional_id = $transactionalId;
        $transaction->transactional_type = $transactionalType;
        $transaction->save();
    }

    public function preparePayoutComplete($payout): void
    {
        if ($payout->status == 1) {
            $payout->status = 2;
            $payout->save();
            $this->userPayoutNotify($payout);
        }
    }

    public function preparePayoutFail($payout)
    {
        if ($payout->status == 1) {
            $payout->status = 3;
            $payout->save();

            updateBalance($payout->user_id, $payout->net_amount_in_base_currency, 1);

            $this->makeTransaction($payout->user_id, $payout->net_amount_in_base_currency, '+',
                $payout->trx_id, 'Payout Amount Refunded', $payout->id, Payout::class);

            $receivedUser = $payout->user;
            $params = [
                'amount' => getAmount($payout->amount),
                'currency' => $payout->payout_currency_code,
                'transaction' => $payout->trx_id,
            ];

            $action = [
                "link" => "#",
                "icon" => "fa fa-money-bill-alt text-white"
            ];
            $firebaseAction = "#";
            $this->sendMailSms($receivedUser, 'PAYOUT_CANCEL', $params);
            $this->userPushNotification($receivedUser, 'PAYOUT_CANCEL', $params, $action);
            $this->userFirebasePushNotification($receivedUser, 'PAYOUT_CANCEL', $params, $firebaseAction);
        }
    }

    public function userPayoutNotify($payout):void
    {
        try {
            $msg = [
                'amount' => getAmount($payout->amount),
                'currency' => $payout->payout_currency_code,
                'transaction' => $payout->trx_id,
            ];
            $action = [
                "link" => '#',
                "icon" => "fas fa-money-bill-alt text-white"
            ];
            $fireBaseAction = "#";
            $this->userPushNotification($payout->user, 'PAYOUT_APPROVED', $msg, $action);
            $this->userFirebasePushNotification('PAYOUT_APPROVED', $msg, $fireBaseAction);
            $this->sendMailSms($payout->user, 'PAYOUT_APPROVED', $msg);
        }catch (\Exception $e){

        }
    }

    public function cryptoQR($wallet, $amount, $crypto = null)
    {
        $varb = $wallet . "?amount=" . $amount;
        return "https://quickchart.io/chart?cht=qr&chs=150x150&chl=$varb";
//        return "https://quickchart.io/chart?cht=qr&chl=$cryptoQr";
    }
}
