<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiUrl = 'https://api.exchangerate.host/latest'; // رابط API المجاني

    /**
     * تحويل مبلغ من عملة إلى أخرى.
     *
     * @param string $fromCurrency رمز العملة الأصلية (مثل USD)
     * @param string $toCurrency رمز العملة المستهدفة (مثل EGP)
     * @param float $amount المبلغ المراد تحويله
     * @return float المبلغ بعد التحويل
     * @throws \Exception
     */
    public function convert($fromCurrency, $toCurrency, $amount)
    {
        // استدعاء API لجلب أسعار الصرف
        $response = Http::get($this->apiUrl, [
            'base' => $fromCurrency,
            'symbols' => $toCurrency,
        ]);

        // التحقق من نجاح الاستجابة
        if ($response->failed()) {
            throw new \Exception('Failed to fetch exchange rates from API.');
        }

        $rates = $response->json()['rates'];

        // التحقق من صحة رمز العملة المستهدفة
        if (!isset($rates[$toCurrency])) {
            throw new \Exception('Invalid target currency code.');
        }

        // حساب المبلغ المحول
        $convertedAmount = $amount * $rates[$toCurrency];

        return round($convertedAmount, 2);
    }
}
