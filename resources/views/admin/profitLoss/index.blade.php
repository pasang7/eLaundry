@extends('layouts.dashboard')
@php
use App\Models\Customer;
use App\Models\Product;
use App\Models\ExpenseLedger;
@endphp
@section('content')
@include('layouts.alerts')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Profit and Loss Statement</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-9">
                <label>Search via date</label>
            </div>
            <div class="col-3">
                <div class="form-group">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <script>

                            function profitLossDaily(date){
                                  $.ajax({
                                      type:"GET",
                                      url:"{{route('admin.profitloss.daily')}}",
                                      data:{
                                          'date':date
                                      },
                                      success:function(response){ 
                                          $('#result').empty().append(response)
                                          update()
                                      }
                                  });
                                }
                                    </script>
                        <input type="text" class="form-control float-right" id="pldate" value="{{date("Y-m-d")}}" onchange="profitLossDaily(this.value)">
                    </div>
                    <!-- /.input group -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12" id="result" >
                <table id="profitandLoss" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="profitandLoss">
                    <label>Showing Total P&L</label>
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="text-align: center">Particulars</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="text-align: center">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- SALES AND PURCHASE -->
                        <tr>
                            <td style="text-align:center"> Sales</td>
                            <td style="text-align:center" id="plsales">{{$salesAmount}}</td>
                        </tr>
                        <tr>
                            <td style="text-align:center">(-)Purchase</td>
                            <td style="text-align:center" id="plpurchase">{{$purchase}}</td>
                        </tr>
                        <tr>
                            <th style="text-align:right" rowspan="1" colspan="1"><b>Gross Profit</b></th>
                            <th id="grossprofit" rowspan="1" style="text-align:center" colspan="1"></th>
                            <!--   <th rowspan="1" colspan="1">Action</th> -->
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center"><b> Expense</b></td>

                        </tr>
                        @foreach($expenses as $item)
                        <tr>
                            <td style="text-align:center">{{ExpenseLedger::where('id',$item->expense_ledger_id)->first()->name}}</td>
                            {{-- <td  style="text-align:center">{{$item->expense_ledger_id}}</td> --}}
                            <td style="text-align:center" class="plexpenseamt"> {{$item->amount}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align:right" rowspan="1" colspan="1"><b>Net Profit/Loss</b></th>

                            <th rowspan="1" colspan="1" id="plnetprofit" style="text-align:center"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    //GROSS PROFIT AND NET PROFIT
function update(){
    var sales=$('#plsales').html()
    var purchase=$('#plpurchase').html()

    $('#grossprofit').html(sales-purchase)

 
    var totalExpense = 0;
        $('.plexpenseamt').each(function(input) {
            totalExpense += parseInt($(this).html());
        })

        $('#plnetprofit').html($('#grossprofit').html()-totalExpense)
}
  

    </script>
<!-- /.card-body -->
@endsection
