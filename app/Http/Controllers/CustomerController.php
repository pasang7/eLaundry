<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ledger;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }


    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|unique:customers|max:14',

        ]);
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone_number = $request->phone_number;
        $customer->pan = $request->pan;
        $customer->other_details = $request->other_details;
        $customer->opening_balance = $request->opening_balance;
        $customer->save();
        if ($customer->save()) {
            if ($customer->opening_balance != null) {
                if ($customer->opening_balance < 0) {
                    $debt_ledger = Ledger::where('name', 'debtors')->first();
                    $debt_ledger->update(array('opening_balance' => $debt_ledger->opening_balance + $customer->opening_balance));
                }
            }
        }
        return redirect()->route('admin.customer')->with('success', 'Customer Added Successfully');
    }
    public function modalStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|unique:customers|max:14',

        ]);
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone_number = $request->phone_number;
        $customer->pan = $request->pan;
        $customer->other_details = $request->other_details;
        $customer->opening_balance = $request->opening_balance;
        $customer->save();
        if ($customer->save()) {
            if ($customer->opening_balance != null) {
                if ($customer->opening_balance < 0) {
                    $debt_ledger = Ledger::where('name', 'debtors')->first();
                    $debt_ledger->update(array('opening_balance' => $debt_ledger->opening_balance + $customer->opening_balance));
                }
            }
        }
        return redirect()->route('admin.sales.create')->with('success', 'Customer Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
        ]);
        $customer = Customer::find($id)->first();
        $customer->update(array('name' => $request->name, 'phone_number' => $request->phone_number, 'other_details' => $request->other_details, 'pan' => $request->pan, 'opening_balance' => $request->opening_balance));
        return redirect()->route('admin.customer')->with('success', 'User Updated Successfully');
    }
}
