<?php
class RequestDTO
{
    public $payment_method;
}


class payment
{
    public function payWithCredit()
    {
    }

    public function payWithPaypal()
    {
    }
}

class main
{
    public function pay(RequestDTO $request)
    {
        $payment = new payment();
        if ($request->payment_method == 'paypal')
            $payment->payWithPaypal();
        else
            $payment->payWithCredit();
    }
}


////

interface PaymentMethod
{
    public function pay();
}

class CreditCardPayment implements PaymentMethod
{
    public function pay()
    {
        return '';
    }
}

class CashPayment implements PaymentMethod
{
    public function pay()
    {
        return '';
    }
}

class PaymentHandler
{
    protected $paymentMethod;
}