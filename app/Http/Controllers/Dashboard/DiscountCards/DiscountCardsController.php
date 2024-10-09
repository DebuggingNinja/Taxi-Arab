<?php

namespace App\Http\Controllers\Dashboard\DiscountCards;

use App\Exports\ArrayExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DiscountCards\CreateDiscountCardsRequest;
use App\Models\DiscountCard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DiscountCardsController extends Controller
{

    public function index(request $request)
    {
        user_can('List.DiscountCard');
        $records = DiscountCard::with('creator')->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.discount_cards.index', compact('records'));
    }

    public function create()
    {
        user_can('Create.DiscountCard');
        return view('dashboard.discount_cards.create');
    }
    public function store(CreateDiscountCardsRequest $request)
    {
        user_can('Create.DiscountCard');

        $id = Auth::id();

        DiscountCard::create([
            'percentage_amount' => $request->percentage_amount,
            'card_number' => $request->card_number,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'repeat_limit' => $request->repeat_limit,
            'allow_user_to_reuse' => $request?->allow_user_to_reuse == "on",
            'created_at' => now(),
            'creator_id' => $id
        ]);

        return redirect()->route('dashboard.discount_cards.create')->with('Success', 'تم إنشاء بطاقة الخصم بنجاح');
    }

    public function export($data)
    {
        $currentTime = Carbon::now()->format('Ymd_His'); // Get the current time formatted as 'Ymd_His'

        $fileName = 'DISC0UNT_CARDS_BATCH_' . $currentTime . '.csv';

        return Excel::download(new ArrayExport($data), $fileName);
    }

    private function generateUniqueCardNumber()
    {
        $prefix = ''; // Adjust as needed
        $numericId = mt_rand(10000000000000, 99999999999999); // Generates a random 14-digit number

        $cardNumber = $prefix . $numericId;

        return $cardNumber;
    }
}
