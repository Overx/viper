<?php

namespace App\Traits\Affiliates;

use App\Models\AffiliateHistory;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\NewDepositNotification;

trait AffiliateHistoryTrait
{

    /**
     * @param User $user
     * @param $commission
     * @return mixed
     */
    public static function saveAffiliateHistory($user)
    {
        $sponsor = User::find($user->inviter);

        if(!empty($sponsor)) {
            if($sponsor->affiliate_revenue_share > 0) {
                AffiliateHistory::create([
                    'user_id' => $user->id,
                    'inviter' => $sponsor->id,
                    'commission' => $sponsor->affiliate_revenue_share,
                    'commission_type' => 'revshare',
                    'deposited' => 0,
                    'losses' => 0,
                    'status' => 0
                ]);
            }

            if($sponsor->affiliate_cpa > 0) {
                AffiliateHistory::create([
                    'user_id' => $user->id,
                    'inviter' => $sponsor->id,
                    'commission' => $sponsor->affiliate_cpa,
                    'commission_type' => 'cpa',
                    'deposited' => 0,
                    'losses' => 0,
                    'status' => 0
                ]);
            }

            return true;
        }

        return true;
    }

    /**
     * Update Affiliate
     *
     * @param $idTransaction
     * @param $userId
     * @param $price
     * @return bool|void
     */
    public static function updateAffiliate($idTransaction, $userId, $price)
    {
        try {
            $deposit = Deposit::with(['user'])->where('payment_id', $idTransaction)->where('status', 0)->first();
            $user = User::find($userId);

            if(!empty($deposit)) {
                $deposit->update(['status' => 1]);

                /// verificar se existe sponsor
                $affHistories = AffiliateHistory::where('user_id', $userId)
                    ->where('deposited', 0)
                    ->where('status', 0)
                    ->get();

                if(count($affHistories) > 0) {
                    foreach($affHistories as $affHistory) {
                        if(!empty($affHistory)) {

                            /// atualiza os valores depositado
                            $affHistory->update(['deposited' => 1, 'deposited_amount' => $price]);
                        }
                    }

                    /// fazer o deposito em cpa
                    $affHistoryCPA = AffiliateHistory::where('user_id', $userId)
                        ->where('commission_type', 'cpa')
                        ->where('deposited', 1)
                        ->where('status', 0)
                        ->lockForUpdate()
                        ->first();

                    if(!empty($affHistoryCPA)) {
                        /// verifcia se já pode receber o cpa
                        $sponsorCpa = User::find($affHistoryCPA->inviter);
                        if(!empty($sponsorCpa)) {
                            if($affHistoryCPA->deposited_amount >= $sponsorCpa->affiliate_baseline) {
                                $walletCpa = Wallet::where('user_id', $affHistoryCPA->inviter)->first();
                                if(!empty($walletCpa)) {

                                    /// paga o valor de CPA
                                    $walletCpa->increment('refer_rewards', $sponsorCpa->affiliate_cpa); /// coloca a comissão do cpa
                                    $affHistoryCPA->update(['status' => 1, 'commission_paid' => $sponsorCpa->affiliate_cpa]); /// desativa cpa
                                }
                            }
                        }
                    }

                    /// notificar todos admin
                    if($deposit->update(['status' => 1])) {
                        $admins = User::where('role_id', 0)->get();
                        foreach ($admins as $admin) {
                            $admin->notify(new NewDepositNotification($deposit->user->name, $price));
                        }


                        return true;
                    }
                    return true;
                }else{
                    $affHistories = AffiliateHistory::where('user_id', $userId)->first();
                    if(empty($affHistories)) {

                        /// criando novo affiliate history
                        if(self::saveAffiliateHistory($user)) {
                            return true;
                        }
                    }else{
                        return true;
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::info(json_encode($e->getMessage() .' -  --- ERROR: '.$e->getLine()));
        }
    }
}
