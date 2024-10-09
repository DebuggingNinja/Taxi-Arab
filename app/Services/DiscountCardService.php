<?php

namespace App\Services;

use App\Models\DiscountCard;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class ZoneService
 * @package App\Services
 */
class DiscountCardService
{
    public static function charge(Request $request)
    {
        $card = DiscountCard::where('card_number', $request->card_number)
            ->whereColumn('repeat_limit', '>', 'charge_count')
            ->whereDate('valid_from', '<=', date('Y-m-d'))
            ->whereDate('valid_to', '>=', date('Y-m-d'))->first();

        if(!$card) return failMessageResponse("البطاقة غير موجودة");

        $user = User::findOrFail(user_auth()->id());

        if(!$card->allow_user_to_reuse
            && Ride::where([['user_id', $user->id], ['discount_card_id', $card->id]])->count())
            return failMessageResponse("لا يمكن إستخدام نفس البطاقة مرتين");

        if($user->discount_card_id && !Ride::where('discount_card_id', $user->discount_card_id)->count()){
            $prevCard = DiscountCard::find($user->discount_card_id);
            if($prevCard) {
                if($prevCard->id == $card->id) return successMessageResponse('تم تفعيل البطاقة مسبقا');
                else if($prevCard?->charge_count) $prevCard->update(['charge_count' => (--$prevCard->charge_count)]);
            }
        }

        return !$user->update(['discount_card_id' => $card->id])
        || !$card->update(['charge_count' => (++$card->charge_count)]) ?
            failMessageResponse("فشل الشحن، رجاء حاول مرة أخرى") :
            successMessageResponse('تم شحن البطاقة');
    }

    public static function validate(Request $request)
    {
        $card = DiscountCard::where('card_number', $request->card_number)
            ->whereColumn('repeat_limit', '>', 'charge_count')
            ->whereDate('valid_from', '<=', date('Y-m-d'))
            ->whereDate('valid_to', '>=', date('Y-m-d'))->first();
        return $card ? successMessageResponse('البطاقة صالحة') :
            failMessageResponse("لم يتم العثور على البطاقة");
    }
}
