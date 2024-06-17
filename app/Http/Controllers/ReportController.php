<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ledger;
use App\Models\Payable;
use App\Models\SalesEntry;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function salesReport()
    {
        $sales = SalesEntry::where('is_sales', 1)->get();
        return view('admin.report.sales', compact('sales'));
    }

    public function markComplete($receipt_number)
    {
        $getItem = SalesEntry::where('receipt_number', $receipt_number)->get();
        foreach ($getItem as $item) {
            $item->update(array('is_complete' => 1));
        }
        return redirect()->route('home');
    }



    // public function markSales($receipt_number)
    // {
    // dd($receipt_number);
    // $getItem = SalesEntry::where('receipt_number', $receipt_number)->get();

    // $getIndividual = SalesEntry::where('receipt_number', $receipt_number)->first();
    // foreach ($getItem as $item) {
    //     SalesEntry::where('receipt_number', $item->receipt_number)->update(array('is_sales' => 1));
    // }
    // if ($getIndividual->is_partial_cash == 1) {
    //     $getPayable = Payable::where('receipt_id', $getIndividual->receipt_number)->first();

    //     $getLedger = Ledger::where('name', 'cash')->first();
    //     $getLedger->update(array(['opening_balance' => $getLedger->opening_balance + $getPayable->total_paid], ['is_full_paid' => 1]));
    // } elseif ($getIndividual->is_partial_bank == 1) {
    //     $getPayable = Payable::where('receipt_id', $getIndividual->receipt_number)->first();
    //     $getLedger = Ledger::where('name', 'bank')->first();
    //     $getLedger->update(array(['opening_balance' => $getLedger->opening_balance + $getPayable->total_paid], ['is_full_paid' => 1]));
    // } elseif ($getIndividual->is_full_credit == 1) {
    //     $getPayable = Payable::where('receipt_id', $getIndividual->receipt_number)->first();
    //     $getLedger = Ledger::where('name', 'debtors')->first();
    //     $getLedger->update(array(['opening_balance' => $getLedger->opening_balance - $getPayable->total_payable], ['is_full_paid' => 1]));
    // }
    // $getPayable = Payable::where('receipt_id', $receipt_number)->first();
    // $getPayable->update(array('total_paid' => $getPayable->total_payable));
    // return redirect()->route('home');
    // }


    public function payment(Request $request, $receipt_number)
    {
        $paymentOption = $request->paymentOption;
        $getSalesInstance = SalesEntry::where('receipt_number', $receipt_number)->get();
        if (isset($paymentOption)) {
            if ($paymentOption == 'cash') {
                $getSalesEntry = SalesEntry::where('receipt_number', $receipt_number)->first();
                if ($getSalesEntry->is_full_credit == 1) {
                    $getPaybale = Payable::where('receipt_id', $receipt_number)->first();
                    $TotalPayable = $getPaybale->total_payable;
                    $getPaybale->update(array('total_paid' => $TotalPayable, 'is_full_paid' => 1));
                    $getLedger = Ledger::where('name', 'debtors')->first();
                    $openingBalance = $getLedger->opening_balance;
                    $debtOpening = $openingBalance - $TotalPayable;
                    $getLedger->update(array('opening_balance' => $debtOpening));
                    $getSalesInstance = $getSalesEntry = SalesEntry::where('receipt_number', $receipt_number)->get();
                    foreach ($getSalesInstance as $instance) {
                        SalesEntry::where('receipt_number', $instance->receipt_number)->update(array('is_sales' => 1));
                    }
                }
                $getPaybale = Payable::where('receipt_id', $receipt_number)->first();
                $remainingAMt = $getPaybale->total_payable - $getPaybale->total_paid;
                // $TotalPayable = $getPaybale->total_payable;
                $TotalPayable = $getPaybale->total_payable;
                $getPaybale->update(array('total_paid' => $TotalPayable, 'is_full_paid' => 1));
                $getLedger = Ledger::where('name', 'cash')->first();
                $openingBalance = $getLedger->opening_balance;
                $cashOpening = $openingBalance + $remainingAMt;
                $getLedger->update(array('opening_balance' => $cashOpening));
                $getSalesInstance = $getSalesEntry = SalesEntry::where('receipt_number', $receipt_number)->get();
                foreach ($getSalesInstance as $instance) {
                    SalesEntry::where('receipt_number', $instance->receipt_number)->update(array('is_sales' => 1));
                }
                return redirect()->route('home')->with('success', 'Payment Successfully Updated');
            } else {
                $getSalesEntry = SalesEntry::where('receipt_number', $receipt_number)->first();
                if ($getSalesEntry->is_full_credit == 1) {
                    $getPaybale = Payable::where('receipt_id', $receipt_number)->first();
                    $TotalPayable = $getPaybale->total_payable;
                    $getPaybale->update(array('total_paid' => $TotalPayable, 'is_full_paid' => 1));
                    $getLedger = Ledger::where('name', 'debtors')->first();
                    $openingBalance = $getLedger->opening_balance;
                    $debtOpening = $openingBalance - $TotalPayable;
                    $getLedger->update(array('opening_balance' => $debtOpening));
                    $getSalesInstance = $getSalesEntry = SalesEntry::where('receipt_number', $receipt_number)->get();
                    foreach ($getSalesInstance as $instance) {
                        SalesEntry::where('receipt_number', $instance->receipt_number)->update(array('is_sales' => 1));
                    }
                }
                $getPaybale = Payable::where('receipt_id', $receipt_number)->first();
                // $TotalPayable = $getPaybale->total_payable;
                $remainingAMt = $getPaybale->total_payable - $getPaybale->total_paid;

                $TotalPayable = $getPaybale->total_payable;
                $getPaybale->update(array('total_paid' => $TotalPayable, 'is_full_paid' => 1));
                $getLedger = Ledger::where('name', 'bank')->first();
                $openingBalance = $getLedger->opening_balance;
                $bankOpening = $openingBalance + $remainingAMt;
                $getLedger->update(array('opening_balance' => $bankOpening));
                $getSalesInstance = $getSalesEntry = SalesEntry::where('receipt_number', $receipt_number)->get();
                foreach ($getSalesInstance as $instance) {
                    SalesEntry::where('receipt_number', $instance->receipt_number)->update(array('is_sales' => 1));
                }
                return redirect()->route('home')->with('success', 'Payment Successfully Updated');
            }
        }
    }

    public function debtorsList()
    {

        // $debtors = SalesEntry::where('is_full_credit', 1)->get();
       

        $debtors= Customer::where('opening_balance','>=',1)->get();
    
        return view('admin.report.debtors', compact('debtors'));
    }

    public function creditorsList(){

        $creditors= Customer::where('opening_balance','<',0)->get();
    
        return view('admin.report.creditors', compact('creditors'));

    }

    public function markDelivered($receipt_id)
    {
        $findReceipt = Payable::where('receipt_id', $receipt_id)->first();
        $findEntry = SalesEntry::where('receipt_number', $receipt_id)->first();
        if ($findEntry->is_complete == 1) {
            $findReceipt->update(array('is_delivered' => 1));
            return redirect()->route('home')->with('success', 'Delivered Successfully');
        } else {
            return redirect()->route('home')->with('error', 'Order is not complete yet');
        }
    }
}
