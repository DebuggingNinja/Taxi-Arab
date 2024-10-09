<?php

namespace App\Services;

use App\Models\Card;
use App\Models\Driver;
use App\Models\User;
use App\Models\UserAddress;

class CardManagment
{
    public $configuration; // User/Driver
    public function __construct()
    {
    }
    public function setConfigurations($model)
    {
        $this->configuration['model'] = $model;
        if ($model == User::class) {
            $this->configuration['foreign'] = 'user_id';
            $this->configuration['foreign_value'] = user_auth()->id();
        } else {
            $this->configuration['foreign'] = 'driver_id';
            $this->configuration['foreign_value'] = driver_auth()->id();
        }
        return $this;
    }
    public function getCards()
    {
        return Card::whereNull('used_at');
    }

    public function charge($card_number)
    {
        $card = $this->getCards()->where('card_number', $card_number)->whereNull('used_at')->first();
        if ($card) {
            $record = $this->configuration['model']::find($this->configuration['foreign_value']);
            $record->update(['current_credit_amount' => $record->current_credit_amount + $card->amount]);
            $card->update(['used_at' => now(), $this->configuration['foreign'] => $this->configuration['foreign_value']]);
            return [
                'status' => true,
                'message' => __('app.Successfully charged :amount to your account using the card', ['amount' => $card->amount])
            ];
        }
        return [
            'status' => false,
            'message' => __('app.Card not found or already used')
        ];
    }

    public function chargedCardsHistory($request)
    {
        return Card::where($this->configuration['foreign'] , $this->configuration['foreign_value'])->whereNotNull('used_at')->orderBy('used_at', 'desc');
    }

}
