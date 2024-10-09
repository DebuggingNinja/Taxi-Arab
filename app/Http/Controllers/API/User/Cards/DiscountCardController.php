<?php

namespace App\Http\Controllers\API\User\Cards;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscountCard\DiscountCardCollection;
use App\Models\DiscountCard;
use App\Models\Ride;
use App\Models\User;
use App\Services\DiscountCardService;
use Illuminate\Http\Request;

class DiscountCardController extends Controller
{
    public function index(request $request)
    {
        $cards = DiscountCard::whereNotNull('used_at')
            ->whereHas('ride', fn($q) => $q->where('user_id', user_auth()->id()))->get();
        return successResponse(new DiscountCardCollection($cards));
    }

    public function available(request $request)
    {
        $cards = DiscountCard::whereColumn('repeat_limit', '>', 'charge_count')
            ->whereDate('valid_from', '<=', date('Y-m-d'))
            ->whereDate('valid_to', '>=', date('Y-m-d'))
            ->paginate($request->per_page ?? $request->limit ?? 10);
        return successResponse(new DiscountCardCollection($cards));
    }

    public function activate(Request $request)
    {
        return DiscountCardService::charge($request);
    }

    public function validateCard(Request $request)
    {
        return DiscountCardService::validate($request);
    }

}
