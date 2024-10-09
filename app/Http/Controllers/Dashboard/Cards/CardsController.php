<?php

namespace App\Http\Controllers\Dashboard\Cards;

use App\Exports\ArrayExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Cards\CreateCardsRequest;
use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CardsController extends Controller
{

    public function index(request $request)
    {
        user_can('List.Card');
        $records = Card::whereNotNull('used_at')->orderBy('used_at', 'desc')->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.cards.index', compact('records'));
    }

    public function create()
    {
        user_can('Create.Card');
        return view('dashboard.cards.create');
    }
    public function store(CreateCardsRequest $request)
    {
        user_can('Create.Card');
        $cards = [];

        $id = Auth::id();

        for ($i = 1; $i <= $request->card_repeat; $i++) {
            $cards[] = [
                'category' => $request->category,
                'amount' => $request->amount, // Adjust as needed
                'card_number' => $this->generateUniqueCardNumber(),
                'created_at' => now(),
                'creator_id' => $id
            ];
        }
        Card::insert($cards);
        return $this->export(array_merge([[
            'category' => 'category',
            'amount' => 'amount', // Adjust as needed
            'card_number' => 'card_number',
            'created_at' => 'created_at'
        ]], $cards));
    }
    public function export($data)
    {
        $currentTime = Carbon::now()->format('Ymd_His'); // Get the current time formatted as 'Ymd_His'

        $fileName = 'CARDS_BATCH_' . $currentTime . '.csv';

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
