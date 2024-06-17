<?php

namespace App\Http\Controllers;

use App\Models\BalanceTrack;
use App\Models\ExpenseLedger;
use App\Models\Ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LedgerController extends Controller
{
    //
    public function index()
    {
        $ledgers = Ledger::all();
        return view('admin.ledger.index', compact('ledgers'));
    }

    public function update(Request $request)
    {

        $ledger = Ledger::find($request->id);
        $ledger->opening_balance = $request->opening_balance;

        if ($request->opening_balance) {
            Ledger::where('id', $request->id)->update(array('opening_balance' =>  $ledger->opening_balance));
            return redirect()->route('admin.ledgers')->with('success', "Opening Balance updated successfully.");
        }
    }

    public function createExpenseLedger()
    {

        $expenses = DB::select(DB::raw("SELECT expense_ledger_id as expid,  SUM(amount) as amount  FROM expenses  GROUP BY expense_ledger_id"));

        // dd($expenses);
        $expenseLedgers= ExpenseLedger::all();

        return view('admin.expenseLedger.create', compact('expenses','expenseLedgers'));
    }

    public function storeExpenseLedger(Request $request)
    {

        $request->validate([
            'name' => 'required' | 'unique:expense_ledgers'
        ]);
        $expenseLedger = new ExpenseLedger();
        $expenseLedger->name = $request->expenseName;
        $expenseLedger->save();

        return redirect()->route('admin.expenseLedger.create')->with('success', 'Expense Ledger Created Successfully !');
    }


    public function contra()
    {

        return view('admin.ledger.contra');
    }
    public function makeContra(Request $request)
    {
        $request->validate([
            'contraType' => 'required',
            'amount' => 'required',

        ]);
        $contraAmount = $request->amount;
        $contraType = $request->contraType;
        $getcashLedger = Ledger::where('name', 'cash')->first();
        $getBankLedger = Ledger::where('name', 'bank')->first();
        if (isset($contraAmount)) {
            if ($contraType == "cashToBank") {
                $getcashLedger->update(['opening_balance' => $getcashLedger->opening_balance - $contraAmount]);
                $getBankLedger->update(['opening_balance' => $getBankLedger->opening_balance + $contraAmount]);
                $track = new BalanceTrack();
                $track->action = "Contra";
                $track->from = $getcashLedger->id;
                $track->to = $getBankLedger->id;
                $track->created_by = Auth::user()->id;
                $track->amount = $contraAmount;
                $track->save();
            } elseif ($contraType == "bankToCash") {
                $getcashLedger->update(['opening_balance' => $getcashLedger->opening_balance + $contraAmount]);
                $getBankLedger->update(['opening_balance' => $getBankLedger->opening_balance - $contraAmount]);
                $track = new BalanceTrack();
                $track->action = "Contra";
                $track->from = $getBankLedger->id;
                $track->to = $getcashLedger->id;
                $track->created_by = Auth::user()->id;
                $track->amount = $contraAmount;
                $track->save();
            }
            return redirect()->route('home')->with('success', 'Contra Successfull');
        } else {
            return redirect()->route('home')->with('error', 'Something went wrong');
        }
    }


    public function balance()
    {
        $cash = Ledger::where('name', 'cash')->first()->opening_balance;
        $bank = Ledger::where('name', 'bank')->first()->opening_balance;
        return view('admin.ledger.addBalance', compact('cash', 'bank'));
    }

    public function addBalance(Request $request)
    {


        $request->validate([
            'balanceType' => 'required',
            'amount' => 'required',

        ]);
        $balanceType = $request->balanceType;
        $amount = $request->amount;
        $getCash = Ledger::where('name', 'cash')->first();
        $getBank = Ledger::where('name', 'bank')->first();
        if ($balanceType == "addToCash") {
            $getCash->update(['opening_balance' => $getCash->opening_balance + $amount]);
            $track = new BalanceTrack();
            $track->action = "Amount to cash added";
            $track->created_by = Auth::user()->id;
            $track->amount = $amount;
            $track->save();
            return redirect()->route('home')->with('success', 'Amount to Cash Added Successfully');
        } elseif ($balanceType == "addToBank") {
            $getBank->update(['opening_balance' => $getBank->opening_balance + $amount]);
            $track = new BalanceTrack();
            $track->action = "Amount to bank added";
            $track->created_by = Auth::user()->id;
            $track->amount = $amount;
            $track->save();
            return redirect()->route('home')->with('success', 'Amount to Bank Added Successfully');
        }
    }
}
