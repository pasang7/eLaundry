<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseLedger;
use App\Models\Ledger;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {


        $expense = Expense::all();
      

        return view('admin.expense.index', compact('expense',));
    }
    public function create()
    {
        $expense = Expense::all();
        $expenseLedgers = ExpenseLedger::all();
        $ledgers = Ledger::where('name', 'bank')->orWhere('name', 'cash')->get();
        return view('admin.expense.create', compact('ledgers', 'expenseLedgers', 'expense'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'expense_ledger_id' => 'required',
            'description' => 'required'
        ]);
        $expense = new Expense();
        $expenseType = $request->expenseType;
        if ($expenseType == "cash") {
            $expense->type = 1;
            //1 is cash
            //2 is bank

        } elseif ($expenseType == "bank") {
            $expense->type = 2;
            //1 is cash
            //2 is bank
        }
        $expense->expense_ledger_id = $request->expense_ledger_id;
        $expense->name = $request->name;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        if ($expenseType == "cash") {
            $getcashLedger = Ledger::where('name', 'cash')->first();
            if ($getcashLedger->opening_balance >= $request->amount) {
                $expense->save();
                $getcashLedger->update(['opening_balance' => $getcashLedger->opening_balance - $request->amount]);
            } else {
                return redirect()->route('admin.expense')->with('error', 'You do not have enough cash balance');
            }
        } elseif ($expenseType == "bank") {
            $expense->save();
            $getbankLedger = Ledger::where('name', 'bank')->first();
            $getbankLedger->update(['opening_balance' => $getbankLedger->opening_balance - $request->amount]);
        }
        $getbaseLedger = Ledger::where('name', 'expense')->first();
        $getbaseLedger->update(['opening_balance' => $getbaseLedger->opening_balance + $request->amount]);
        return redirect()->route('admin.expense')->with('success', 'Expense added successfully ');
    }
    public function storeExpenseLedger(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:expense_ledgers',
        ]);
        $expenseLedger = new ExpenseLedger();
        $expenseLedger->name = $request->name;
        $expenseLedger->save();

        return redirect()->route('admin.expense.create')->with('success', 'Expense Ledger Created Successfully');
    }
}
