<?php

namespace App\Http\Controllers\Frontend;

use App\Events\VotingEvent;
use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Kandidat;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function index()
    {
        try {
            $data['kandidat'] = Kandidat::all();
            return view('frontend.voting.index', compact('data'));
        } catch (\Throwable $th) {
            return view('error.index', ['message' => $th->getMessage()]);
        }
    }

    public function store($id)
    {
        try {
            if (auth()->user()->kandidat_id != null) {
                return redirect()->route('dashboard');
            }
            $vote_date_start = Config::where(['name' => 'vote_date_start'])->first()['value'] ?? '-';
            $vote_date_end = Config::where(['name' => 'vote_date_end'])->first()['value'] ?? '-';
            $vote_open = Config::where(['name' => 'vote_open'])->first()['value'] ?? '-';
            $vote_closed = Config::where(['name' => 'vote_closed'])->first()['value'] ?? '-';
            $open = strtotime($vote_date_start.' '.$vote_open);
            $close = strtotime($vote_date_end.' '.$vote_closed);

            if (strtotime(date('Y-m-d H:i')) >= strtotime($open) && strtotime(date('Y-m-d H:i')) <= strtotime($close)) {
                $message = auth()->user()->name . ' Telah Memilih';
                event(new VotingEvent($message));
                auth()->user()->update([
                    'kandidat_id' => $id
                ]);
            } 
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            return view('error.index', ['message' => $th->getMessage()]);
        }
    }
}
