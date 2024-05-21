<?php

namespace App\Traits\Gateways;

use App\Models\AffiliateHistory;
use App\Models\Deposit;
use App\Models\DigitoPayPayment;
use App\Models\Gateway;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\NewDepositNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Core as Helper;

trait DigitoPayTrait
{
    /**
     * @var $uri
     * @var $clienteId
     * @var $clienteSecret
     */
    protected static string $bearerToken;
    protected static string $uri;

    /**
     * Generate Credentials
     * Metodo para gerar credenciais
     * Use Digitopay - o melhor gateway de pagamentos para sua plataforma - 048 98814-2566
     */
    private static function generateCredentials()
    {
        $setting = Gateway::first();
        if(!empty($setting)) {
            self::$uri = $setting->getAttributes()['digitopay_uri'];
            $clientId = $setting->getAttributes()['digitopay_cliente_id'];
            $clienteSecret = $setting->getAttributes()['digitopay_cliente_secret'];

            self::$bearerToken = Http::post(self::$uri.'api/token/api',
                [
                    "clientId" => $clientId,
                    "secret" => $clienteSecret
                ])->object()->accessToken;
        }
    }

    /**
     * Request QRCODE
     * Metodo para solicitar uma QRCODE PIX
    * Use Digitopay - o melhor gateway de pagamentos para sua plataforma - 048 98814-2566
     * @return array
     */
    public static function requestQrcode($request)
    {
        $setting = Helper::getSetting();
        $rules = [
            'amount' => ['required', 'max:'.$setting->min_deposit, 'max:'.$setting->max_deposit],
            'cpf'    => ['required', 'max:255'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        self::generateCredentials();

        $response = Http::withToken(self::$bearerToken)->post(self::$uri.'api/deposit', [
            "dueDate" => Carbon::now()->addDay(),
            "paymentOptions" => ["PIX"],
            "person" => [
                "cpf" => Helper::soNumero($request->cpf),
                "name" => auth()->user()->name,
            ],
            "value" => $request->amount
        ]);

        if($response->successful()) {
            $responseData = $response->json();

            self::generateTransaction($responseData['id'], Helper::amountPrepare($request->amount)); /// gerando historico
            self::generateDeposit($responseData['id'], Helper::amountPrepare($request->amount)); /// gerando deposito

            return [
                'status' => true,
                'idTransaction' => $responseData['id'],
                'qrcode' => $responseData['pixCopiaECola']
            ];
        }

        return [
            'status' => $response->json(),
        ];
    }

    /**
     * Consult Status Transaction
     * Consultar o status da transação
     * Use Digitopay - o melhor gateway de pagamentos para sua plataforma - 048 98814-2566
     *
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function consultStatusTransaction($request)
    {
        self::generateCredentials();

        $response = Http::withToken(self::$bearerToken)->get(self::$uri.'api/status/'.$request->idTransaction);
        if($response->successful()) {
            $responseData = $response->object();

            if($responseData == "REALIZADO")
            {
                if(self::finalizePayment($request->idTransaction)) {
                    return response()->json(['status' => 'PAID']);
                }

                return response()->json(['status' => $responseData], 400);
            }

            return response()->json(['status' => $responseData], 400);

        }

        return response()->json(['status' => 'ERROR'], 400);
    }

    /**
     * @param $idTransaction
     * * Use Digitopay - o melhor gateway de pagamentos para sua plataforma - 048 98814-2566
     * @return bool
     */
    public static function finalizePayment($idTransaction) : bool
    {
        $transaction = Transaction::where('payment_id', $idTransaction)->where('status', 0)->first();
        $setting = \Helper::getSetting();

        if(!empty($transaction)) {
            $wallet = Wallet::where('user_id', $transaction->user_id)->first();
            if(!empty($wallet)) {
                /// verifica se é o primeiro deposito
                $checkTransactions = Transaction::where('user_id', $transaction->user_id)->count();
                if($checkTransactions <= 1) {
                    /// pagar o bonus
                    $bonus = \Helper::porcentagem_xn($setting->initial_bonus, $transaction->price);
                    $wallet->increment('balance_bonus', $bonus);
                }

                if($wallet->increment('balance', $transaction->price)) {
                    if($transaction->update(['status' => 1])) {
                        return self::updateAffiliate($transaction->payment_id, $transaction->user_id, $transaction->price);
                    }
                    return false;
                }
                return false;
            }
            return false;
        }
        $transactionActive = Transaction::where('payment_id', $idTransaction)->where('status', 1)->first();
        if(!empty($transactionActive)) {
            return true;
        }


        return false;
    }

    /**
     * @param $idTransaction
     * @param $amount
     * @return void
     * * Use Digitopay - o melhor gateway de pagamentos para sua plataforma - 048 98814-2566
     */
    private static function generateDeposit($idTransaction, $amount)
    {
        $userId = auth()->user()->id;
        $wallet = Wallet::where('user_id', $userId)->first();

        Deposit::create([
            'payment_id'=> $idTransaction,
            'user_id'   => $userId,
            'amount'    => $amount,
            'type'      => 'pix',
            'currency'  => $wallet->currency,
            'symbol'    => $wallet->symbol,
            'status'    => 0
        ]);
    }

    /**
     * @param $idTransaction
     * @param $amount
     * Use Digitopay - o melhor gateway de pagamentos para sua plataforma - 048 98814-2566
     * @return void
     */
    private static function generateTransaction($idTransaction, $amount)
    {
        $setting = Helper::getSetting();

        Transaction::create([
            'payment_id' => $idTransaction,
            'user_id' => auth()->user()->id,
            'payment_method' => 'pix',
            'price' => $amount,
            'currency' => $setting->currency_code,
            'status' => 0
        ]);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse|void
     * * Use Digitopay - o melhor gateway de pagamentos para sua plataforma - 048 98814-2566
     */
    public static function pixCashOut(array $array): bool
    {
        self::generateCredentials();

        $response = Http::withToken(self::$bearerToken)->post(self::$uri.'api/withdraw', [
            "paymentOptions" => ["PIX"],
            "person" => [
                "pixKeyTypes" => self::FormatPixType($array['pix_type']),
                "pixKey" => $array['pix_key']
            ],
            "value" => $array['amount']
        ]);

        if($response->successful()) {
            $responseData = $response->json();
            $digitoPayPayment = DigitoPayPayment::lockForUpdate()->find($array['digitoPayPayment_id']);
            if(!empty($digitoPayPayment)) {
                if($digitoPayPayment->update(['status' => 1, 'payment_id' => $responseData['id']])) {
                    return true;
                }
                return false;
            }
            return $responseData['success'];
        }
        return false;
    }

    /**
     * @param $type
     * @return string|void
     * * Use Digitopay - o melhor gateway de pagamentos para sua plataforma - 048 98814-2566
     */
    private static function FormatPixType($type)
    {
        switch ($type) {
            case 'email':
                return 'EMAIL';
            case 'document' && strlen($type) == 11:
                return 'CPF';
            case 'document' && strlen($type) == 14:
                return 'CNPJ';
            case 'randomKey':
                return 'EVP';
            case 'phoneNumber':
                return 'PHONE';
        }
    }

}
