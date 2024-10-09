<?php

namespace App\Http\Controllers\API\Driver\Cards;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cards\CardCollection;
use App\Models\Driver;
use App\Services\CardManagment;
use Illuminate\Http\Request;

class CardController extends Controller
{
    function __construct(protected CardManagment $cardService)
    {
        $this->cardService->setConfigurations(Driver::class);
    }

    public function index(request $request)
    {
        $cards = $this->cardService->chargedCardsHistory($request)->paginate($request->per_page ?? $request->limit ?? 10);
        return successResponse(new CardCollection($cards));
    }

    public function charge(Request $request)
    {
        $success = $this->cardService->charge($request->card_number);
        if ($success['status']) return successMessageResponse($success['message']);
        return failMessageResponse($success['message']);
    }
}
