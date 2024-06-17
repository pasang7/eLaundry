<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\SalesEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ExpenseLedger;

class ProfitLossController extends Controller
{

    public function profitLoss()
    {

        $expenses = DB::select(DB::raw('SELECT expense_ledger_id, SUM(amount) as amount  FROM expenses GROUP BY expense_ledger_id'));
        //   dd($expenses);
        $sales = DB::select(DB::raw("SELECT * FROM sales_entries WHERE is_sales=1 "));
        $salesAmount = 0;
        foreach ($sales as $sale) {
            $rate = $sale->product_rate;
            $quantity = $sale->product_quantity;
            $total = $rate * $quantity;
            $salesAmount += $total;
        }

        $purchase = Purchase::sum('amount');

        return view('admin.profitLoss.index', compact('expenses', 'salesAmount', 'purchase'));
    }

    public function profitLossDaily(Request $request)
    {
        $sales = DB::select(DB::raw("SELECT * FROM sales_entries WHERE DATE_FORMAT(created_at,'%Y-%m-%d')='$request->date' AND is_sales=1 "));
        $purchases = DB::select(DB::raw("SELECT amount,SUM(amount) as amount FROM purchases WHERE DATE_FORMAT(created_at,'%Y-%m-%d')='$request->date' GROUP BY amount"));
        $expenses = DB::select(DB::raw("SELECT expense_ledger_id,  SUM(amount) as amount  FROM expenses WHERE DATE_FORMAT(created_at,'%Y-%m-%d')='$request->date' GROUP BY expense_ledger_id"));

        $total_sales = 0;
        $total_purchase = 0;
        $total_expense = 0;
        foreach ($sales as $sale) {
            $rate = $sale->product_rate;
            $quantity = $sale->product_quantity;
            $total = $rate * $quantity;
            $total_sales += $total;
        }
        foreach ($purchases as $purchase) {
            $total_purchase += $purchase->amount;
        }

       $response='';
       $response.='<table id="profitandLoss" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="profitandLoss">
       <thead>
       <label>Showing Day wise P&L</label>
           <tr role="row">
               <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="text-align: center">Particulars</th>
               <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="text-align: center">Amount</th>
           </tr>
       </thead>
       <tbody>
     
           <tr>
               <td style="text-align:center"> Sales</td>
               <td style="text-align:center" id="plsales">'.$total_purchase.'</td>
           </tr>
           <tr>
               <td style="text-align:center">(-)Purchase</td>
               <td style="text-align:center" id="plpurchase">'.$total_purchase.'</td>
           </tr>
           <tr>
               <th style="text-align:right" rowspan="1" colspan="1"><b>Gross Profit</b></th>
               <th id="grossprofit" rowspan="1" style="text-align:center" colspan="1"></th>
               <!--   <th rowspan="1" colspan="1">Action</th> -->
           </tr>
           <tr>
               <td colspan="2" style="text-align:center"><b> Expense</b></td>

           </tr>';          
           foreach($expenses as $item){
               $expneseName= ExpenseLedger::where('id',$item->expense_ledger_id)->first()->name;
               $response.='   <tr>

               <td style="text-align:center">'.$expneseName.'</td>
           
               <td style="text-align:center" class="plexpenseamt"> '.$item->amount.'</td>
           </tr>';
           }

           $response.=' </tbody>
           <tfoot>
               <tr>
                   <th style="text-align:right" rowspan="1" colspan="1"><b>Net Profit/Loss</b></th>
    
                   <th rowspan="1" colspan="1" id="plnetprofit" style="text-align:center"></th>
               </tr>
           </tfoot>
    
       </table>';

        return $response;
    }
}
