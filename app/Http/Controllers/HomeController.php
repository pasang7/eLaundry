<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Payable;
use App\Models\Purchase;
use App\Models\SalesEntry;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cash = Ledger::where('name', 'cash')->first()->opening_balance;
        $bank = Ledger::where('name', 'bank')->first()->opening_balance;
        $expense = Ledger::where('name', 'expense')->first()->opening_balance;
        $debtors = Ledger::where('name', 'debtors')->first()->opening_balance;
        $openSales = DB::select('SELECT * FROM payables WHERE total_paid!=total_payable');
        $closedSales = DB::select('SELECT * FROM payables WHERE total_paid=total_payable AND is_delivered!=1');


        //TODAYS SALES PURCHASES AND EXPENSES

        // $sales=SalesEntry::where('is_sales',1)->where('DATE_FORMAT(created_at,'%Y-%m-%d')',date('Y-m-d'))->get();
        $today = date('Y-m-d');

        $sales = DB::select(DB::raw("SELECT * FROM sales_entries WHERE is_sales=1 AND DATE_FORMAT(created_at,'%Y-%m-%d')='$today'"));
        $salesAmount = 0;
        foreach ($sales as $sale) {
            $rate = $sale->product_rate;
            $quantity = $sale->product_quantity;
            $total = $rate * $quantity;
            $salesAmount += $total;
        }
        $total_purchase = 0;
        $purchases = DB::select(DB::raw("SELECT amount,SUM(amount) as amount FROM purchases WHERE DATE_FORMAT(created_at,'%Y-%m-%d')='$today' GROUP BY amount"));
        foreach ($purchases as $purchase) {
            $total_purchase += $purchase->amount;
        }
        return view('home', compact('openSales', 'closedSales', 'cash', 'bank', 'expense', 'debtors', 'salesAmount','total_purchase'));
    }
    public function unauthorised()
    {
        return view('pages.unauthorised');
    }


    public function settings(){

        $setting=Settings::find(1)->first();
        return view('admin.settings.update',compact('setting'));
    }


    public function settingsUpdate(Request $request){

        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

       $name=$request->name;
       $email=$request->email_address;
       $phone=$request->phone;
       $pan=$request->pan;
       $address=$request->address;

       //IMAGES
       $logo=$request->logo;
       $banner=$request->banner;

       $getSetting=Settings::first();
       $logoName=$getSetting->logo;
       $bannerName=$getSetting->banner;
       if(isset($logo)){
        $logoName = time().'.'.$logo->extension();
        $logo->move(public_path('images'), $logoName);
       }
       if(isset($banner)){
        $bannerName = time().'.'.$banner->extension();
        $banner->move(public_path('images'), $bannerName);
       }

       $getSetting->update(['name'=>$name,'email'=>$email,'phone'=>$phone,'pan'=>$pan,'logo'=>$logoName,'banner'=>$bannerName,'address'=>$address]);

       return redirect()->route('admin.settings')->with('success','Settings updated successfully');
    }
}
