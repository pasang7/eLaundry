<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function create()
    {

        $purchases = Purchase::all();
        return view('admin.purchase.create', compact('purchases'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'amount' => 'required'
        ]);

        $name = $request->name;
        $amount = $request->amount;
        $created_by = Auth::user()->id;
        $purchaseType = $request->purchaseType;
        $purchase = new Purchase();
        $purchase->name = $name;
        $purchase->amount = $amount;
        if ($purchaseType == "cash") {
            $purchase->type = 1;
            //1 is cash
            //2 is bank
        } elseif ($purchaseType == "bank") {
            $purchase->type = 1;
            //1 is cash
            //2 is bank
        }
        $purchase->description = $request->description;
        $purchase->created_by = $created_by;

        if ($purchaseType == "cash") {
            $getcashLedger = Ledger::where('name', 'cash')->first();
            if ($getcashLedger->opening_balance >= $request->amount) {
                $purchase->save();
                $getcashLedger->update(['opening_balance' => $getcashLedger->opening_balance - $request->amount]);
            } else {
                return redirect()->route('admin.purchase.create')->with('error', 'You do not have enough cash to make this purchase');
            }
        } elseif ($purchaseType == "bank") {
            $purchase->save();
            $getbankLedger = Ledger::where('name', 'bank')->first();
            $getbankLedger->update(['opening_balance' => $getbankLedger->opening_balance - $request->amount]);
        }
        // $getExpenseLedger = Ledger::where('name', 'expense')->first();
        // $getExpenseLedger->update(['opening_balance' => $getExpenseLedger->opening_balance + $amount]);
        return redirect()->route('admin.purchase.create')->with('success', 'Purchase created successfully');
    }
}
