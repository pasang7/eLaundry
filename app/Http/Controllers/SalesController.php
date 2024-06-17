<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ledger;
use App\Models\Payable;
use App\Models\Product;
use App\Models\ReceiptNumber;
use App\Models\SalesEntry;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function create()
    {
        $receipt = ReceiptNumber::latest()->first('receipt_number');
    
        $new_receipt_number = $receipt->receipt_number + 1;
        $products = Product::where('status', 1)->get();
        return view('admin.sales.create', compact('products', 'new_receipt_number'));
    }

    public function searchCustomer(Request $request)
    {
        $keyword = $request->get('keyword');
        $result = '';
        if (!empty($keyword)) {
            $query = Customer::where('phone_number', 'LIKE', "%$keyword%")->get();
            $result .= '<ul id="mycustomer" style="list-style: none;">';
            foreach ($query as $customer) {
                $name = $customer->name ? $customer->name : 'Cash Customer';

                $result .= '<a href="javascript:void(0)" id="' . $customer->phone_number . ' (' . $name . ')" onclick="test(this.id)"><li class="listing">' . $customer->phone_number . ' (' . $name . ') </li></a>';
            }
            $result .= '</ul>';
        }
        return $result;
    }
    public function getProductDetails(Request $request)
    {
        $product_id = $request->get('product_id');
        $product_detail = Product::where('id', $product_id)->first();
        if ($product_detail != null) {
            $response = [

                'product_id' => $product_detail->id,
                'product_rate' => $product_detail->rate,

            ];
            return response()->json($response);
        } else {
            return 0;
        }
    }


    public function store(Request $request)
    {

        //create_sales_entry
        $receipt = ReceiptNumber::latest()->first('receipt_number');

        $new_receipt_number = $receipt->receipt_number + 1;

        $numberAndName = $request->search_key;
        $number = preg_replace('/[^0-9]/', '', $numberAndName);

        foreach ($request->get('arrayName') as $entry) {
            $sales_entry = new SalesEntry();
            $sales_entry->customer_id = Customer::where('phone_number', $number)->first()->id;
            $sales_entry->receipt_number = $new_receipt_number;
            $sales_entry->estimated_delivery_date = $request->estimated_delivery_date;
            $sales_entry->product_id = $entry['product_id'];
            $sales_entry->product_rate = Product::where('id', $entry['product_id'])->first()->rate;
            $sales_entry->product_quantity = $entry['quantity'];
            $sales_entry->item_total = $sales_entry->product_rate * $sales_entry->product_quantity;
            if ($request->paymentOption == "cashFull") {
                $sales_entry->is_full_cash = 1;
                $sales_entry->is_sales = 1;
            } elseif ($request->paymentOption == "bankFull") {
                $sales_entry->is_full_bank = 1;
                $sales_entry->bank_name = $request->fullBankName;
                $sales_entry->bank_code = $request->fullBankCode;
                $sales_entry->is_sales = 1;
            } elseif ($request->paymentOption == "creditFull") {
                $sales_entry->is_full_credit = 1;
            } elseif ($request->paymentOption == "partial") {
                if ($request->partialPaymentOption == "partialCash") {
                    $sales_entry->is_partial_cash = 1;
                } elseif ($request->partialPaymentOption == "partialBank") {
                    $sales_entry->is_partial_bank = 1;
                    $sales_entry->bank_name = $request->partialBankName;
                    $sales_entry->bank_code = $request->partialBankCode;
                }
            }
            $sales_entry->save();
        }
        if ($request->paymentOption == "cashFull") {
              $findLedger = Ledger::where('name', 'cash')->first();
              $findLedger->update(array('opening_balance' =>  $findLedger->opening_balance +  $sales_entry->item_total));
        }elseif ($request->paymentOption == "bankFull") {
             $findLedger = Ledger::where('name', 'bank')->first();
                $findLedger->update(array('opening_balance' =>  $findLedger->opening_balance +  $sales_entry->item_total));
        }elseif($request->paymentOption == "creditFull") {
                $findLedger = Ledger::where('name', 'debtors')->first();
                $findLedger->update(array('opening_balance' =>  $findLedger->opening_balance +  $sales_entry->item_total));
        }elseif($request->paymentOption == "partial") {
            if ($request->partialPaymentOption == "partialCash") {
                $findLedger = Ledger::where('name', 'cash')->first();
                $findLedger->update(array('opening_balance' =>  $findLedger->opening_balance +  $request->partialCashPaid));
            } elseif($request->partialPaymentOption == "partialBank"){
                $findLedger = Ledger::where('name', 'bank')->first();
                $findLedger->update(array('opening_balance' =>  $findLedger->opening_balance +  $request->partialBankPaid));
            }
        }

        $newReceipt = new ReceiptNumber();
        $newReceipt->receipt_number =   $sales_entry->receipt_number;
        $newReceipt->save();
        //create_payment_track

        $total_payable = SalesEntry::where('receipt_number',  $new_receipt_number)->get();

        $payable = 0;
        foreach ($total_payable as $amount) {
            $payable += $amount->item_total;
        }
        $paytrack = new Payable();
        $paytrack->receipt_id = $sales_entry->receipt_number;
        $paytrack->total_payable = $payable;
        $paytrack->is_delivered = 0;

        if ($request->paymentOption == "cashFull") {
            $paytrack->total_paid = $payable;
            $paytrack->is_full_paid = 1;
        } elseif ($request->paymentOption == "bankFull") {

            $paytrack->total_paid = $payable;
            $paytrack->is_full_paid = 1;
        } elseif ($request->paymentOption == "creditFull") {
            $paytrack->total_paid = 0;
            $paytrack->is_full_paid = 0;
        } elseif ($request->paymentOption == "partial") {
            if ($request->partialPaymentOption == "partialCash") {

                $paytrack->total_paid = $request->partialCashPaid;
            } elseif ($request->partialPaymentOption == "partialBank") {

                $paytrack->total_paid = $request->partialBankPaid;
            }
        }
        $paytrack->save();
       return $this->printView($new_receipt_number);
    }

    public function changeDeliverDate(Request $request, $receipt_id)
    {
        $newDate = $request->new_delivery_date;
        $getSalesEntry = SalesEntry::where('receipt_number', $receipt_id)->get();

        foreach ($getSalesEntry as $entry) {
            $entry->update(array('new_delivery_date' => $newDate));
        }
        return redirect()->route('home')->with('success', 'Successfully Changed Delivery Date');
    }

    public function printView($receipt_number)
    {
        $settings = Settings::find(1)->first();
        $saleEntry = SalesEntry::where('receipt_number', $receipt_number)->get();
        $totalPaid = DB::table('payables')->where('receipt_id', $receipt_number)->first()->total_paid;
      
        return view('admin.printReceipt.print', compact('saleEntry', 'settings', 'totalPaid'));
    }
}
