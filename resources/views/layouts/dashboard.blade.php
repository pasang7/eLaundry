@php
use App\Models\Settings;
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{Settings::find(1)->first()->name}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->

    <link rel="stylesheet" href=" {{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">


</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Home</a>
                </li>

            </ul>

            <!-- SEARCH FORM -->


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/logout') }}" role="button">
                        <i class="fas fa-power-off"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <img src="{{ asset('images/'.Settings::find(1)->first()->logo) }}" alt="No Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{Settings::find(1)->first()->name}}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        @if (Auth::user()->hasRole('superadmin') ||Auth::user()->hasRole('admin') )

                        <li class="nav-item has-treeview  {{ (request()->is(['admin/users*'],['admin/roles*'],['admin/permissions*'],['admin/rolePermission'])) ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-lock"></i>
                                <p>
                                    User Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users') }}" class="nav-link {{ (request()->is(['admin/users*'])) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                                @if (Auth::user()->hasRole('superadmin') )
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles') }}" class="nav-link {{ (request()->is(['admin/roles*'])) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                                @endif
                                {{-- @if (Auth::user()->hasRole('superadmin') )
                                <li class="nav-item">
                                    <a href="{{ route('admin.permissions') }}" class="nav-link {{ (request()->is(['admin/permissions*'])) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Permissions</p>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->hasRole('superadmin') )
                                <li class="nav-item">

                                    <a href="{{ route('admin.role.permission') }}" class="nav-link {{ (request()->is(['admin/rolePermission*'])) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>

                                        <p>Role and Permission</p>
                                    </a>
                                </li>
                                @endif --}}

                            </ul>
                        </li>
                        @endif

                        @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('user') )
                        <li class="nav-item has-treeview {{ (request()->is(['admin/category*'],['admin/product*'])) ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->is(['admin/category*'],['admin/product*'])) ? 'active' : '' }}">
                                <i class="nav-icon fab fa-product-hunt"></i>

                                <p>
                                    Product
                                    <i class="fas fa-angle-left right"></i>

                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item ">
                                    <a href="{{ route('admin.categories') }}" class="nav-link {{ (request()->is('admin/category*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Category</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item ">
                                    <a href="{{ route('admin.products') }}" class="nav-link {{ (request()->is('admin/product*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Product</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @endif
                        @if (Auth::user()->hasRole('account') ||Auth::user()->hasRole('admin')||Auth::user()->hasRole('superadmin') )
                        <li class="nav-item has-treeview {{ (request()->is(['admin/baseLedger*','admin/expenseLedger*'])) ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->is(['admin/baseLedger*'])) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Ledgers
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.ledgers') }}" class="nav-link  {{ (request()->is(['admin/baseLedger*'])) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Base Ledgers</p>
                                    </a>
                                </li>
                            </ul>
                            @endif
                            <ul class="nav nav-treeview">
                                <li class="nav-item ">
                                    <a href="{{route('admin.expenseLedger.create')}}" class="nav-link  {{ (request()->is(['admin/expenseLedger*'])) ? 'active' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Expense Ledgers</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @endif
                        @if (Auth::user()->hasRole('staff') ||Auth::user()->hasRole('admin') ||Auth::user()->hasRole('superadmin')   )
                        <li class="nav-item">
                            <a href="{{ route('admin.customer') }}" class="nav-link {{ (request()->is(['admin/customers*'])) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Customers
                                </p>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasRole('staff') ||Auth::user()->hasRole('admin') ||Auth::user()->hasRole('superadmin'))
                        <li class="nav-item">
                            <a href="{{ route('admin.sales.create') }}" class="nav-link {{ (request()->is(['admin/sales/create'])) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>
                                    Sales Entry
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.expense.create') }}" class="nav-link {{ (request()->is(['admin/expense/create'])) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-share"></i>
                                <p>
                                    Expense Entries
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.purchase.create') }}" class="nav-link {{ (request()->is(['admin/purchase/create'])) ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>
                                    Purchase
                                </p>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasRole('admin') ||Auth::user()->hasRole('superadmin') ||Auth::user()->hasRole('account')  )
                        <li class="nav-item has-treeview {{ (request()->is(['admin/sales/salesReport','admin/sales/debtorsList','admin/sales/creditorsList','admin/profitLoss'])) ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class=" nav-icon fa fa-book"></i>
                                <p>
                                    Report
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.sales.report') }}" class="nav-link {{ (request()->is(['admin/sales/salesReport'])) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sales Report</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.debtors.report') }}" class="nav-link  {{ (request()->is(['admin/sales/debtorsList'])) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Debtors List
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.creditors.report') }}" class="nav-link  {{ (request()->is(['admin/sales/creditorsList'])) ? 'active' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Creditors List
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.profitloss') }}" class="nav-link {{ (request()->is(['admin/profitLoss'])) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Profit and Loss
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Auth::user()->hasRole('admin') ||Auth::user()->hasRole('superadmin') ||Auth::user()->hasRole('account')  )
                        <li class="nav-item">
                            <a href="{{ route('admin.contra') }}" class="nav-link {{ (request()->is(['admin/contra'])) ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-people-arrows"></i>
                                <p>
                                    Contra
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.balance') }}" class="nav-link {{ (request()->is(['admin/balance'])) ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Add Balance
                                </p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('admin.settings') }}" class="nav-link {{ (request()->is(['admin/settings'])) ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Settings
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active">E-Laundry</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="https://pocketstudionepal.com" target="_blank">Pocket Studio</a>.</strong>
            All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->

    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    {{-- <script src="{{ asset('admin/plugins/sparklines/sparkline.js')}}"></script> --}}
    <!-- JQVMap -->
    <script src="{{ asset('admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
    {{-- <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('admin/dist/js/pages/dashboard.js') }}"></script> --}}
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('admin/dist/js/demo.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Data Tables -->

    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>




    <!-- Bootstrap Select Multiple Javascript -->
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/addon/repeater.js') }}"></script>

    <script type="text/javascript">
        $('.orderlist').repeater({
            show: function() {
                $(this).slideDown();
            }
            , hide: function(deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {}
                $(this).slideUp(deleteElement);
            }
            , ready: function(setIndexes) {

            }
        });

    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        $('input[name="new_delivery_date"]').daterangepicker();
        $('#date').daterangepicker();
        $('#pldate').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

    </script>



    <!-- Sales Form Javascript -->
    <script>
        function productDetail(product_id) {


            var rate = $(event.currentTarget).parent().parent().siblings().eq(0).children().children().eq(1);
            $.ajax({
                async: false
                , method: 'GET'
                , url: '{{ route('admin.sales.getdetail') }}'
                , data: {
                    product_id: product_id
                , }
                , dataType: "json"
                , success: function(response) {

                    rate.val(response.product_rate)
                }
                , error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown)
                }
            });
        }

        function itemTotal() {
            var qty = $(event.currentTarget).val()
            var rate = $(event.currentTarget).parent().parent().siblings().eq(1).children().children().eq(1).val()
            var totalPayable = $(event.currentTarget).parent().parent().parent().parent().parent().siblings().eq(3).children().siblings().eq(1).children().children().eq(1).val();
            var itemTotal = $(event.currentTarget).parent().parent().siblings().eq(2).children().children().eq(1)
            total = rate * qty
            itemTotal.val(rate * qty)


            var x = 0;
            $('.prc').each(function(input) {
                x += parseInt($(this).val()); // Or this.innerHTML, this.innerText

            });

            //TOTA PAYABLE AMOUNTS FOR
            $('#total_payable').val(x)

            $('#bank_amount').val(x)

            $('#partialCashPayable').val(x)
            $('#partialBankPayable').val(x)


        }

        function hideAll() {
            $('#radio_and_form').hide();
        }

        function showBankOption() {

            $('#bank_partial_form').hide();
            $('#cash_partial_form').hide();
            $("#bank_form").show();
        }

        function cashOption() {
            $("#partial_option").hide();
            $("#bank_form").hide();
        }

        function partialOption() {
            cashOption()
            $('#partial_option').show();
        }

        function cashPartialOption() {
            $('#bank_partial_form').hide();
            $('#cash_partial_form').show();
        }



        function bankPartialOption() {
            $('#cash_partial_form').hide();
            $('#bank_partial_form').show();

        }

        function cashPartialCalculation() {
            var partialPaid = $('#partial_paid_cash_amount').val()
            var totalPayable = $('#total_payable').val()
            var partialRemaining = totalPayable - partialPaid

            $('#remaining_cash_amount').val(partialRemaining)
        }

        function bankPartialCalculation() {
            var partialPaid = $('#partial_bank_amount').val()
            var totalPayable = $('#total_payable').val()
            var partialRemaining = totalPayable - partialPaid
            $('#remaining_bank_amount').val(partialRemaining)
        }

    </script>



    <script>
        $(document).ready(function() {
            $("#search-box").keyup(function() {
                $.ajax({
                    type: "GET"
                    , url: "{{route('admin.sales.getcustomer')}}"
                    , data: 'keyword=' + $(this).val()
                    , beforeSend: function() {}
                    , success: function(data) {
                        $("#suggesstion-box").show();
                        $("#suggesstion-box").html(data);
                        $("#search-box").css("background", "#FFF");

                    }
                });
            });

        });

        function test(id) {
            $('#search-box').val(id);
            $("#suggesstion-box").hide();


        }

    </script>


    <!-- Datatable Javascript -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true
                , "lengthChange": false
                , "autoWidth": false
                , "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true
                , "lengthChange": false
                , "searching": false
                , "ordering": true
                , "info": true
                , "autoWidth": false
                , "responsive": true
            , });
        });
        $(function() {
            $("#closedSalesTable").DataTable({
                "responsive": true
                , "lengthChange": false
                , "autoWidth": false
                , "buttons": ["copy", "csv", "excel", "pdf", "print"]
                , "paging": true
                , "searching": true
                , "ordering": true
                , "info": true
                , "autoWidth": false
                , "responsive": true
            }).buttons().container().appendTo('#closedSalesTable_wrapper .col-md-6:eq(0)');
        });
        //PROFIT AND LOSS TABLE //
        // $(function() {
        //     $("#profitandLoss").DataTable({
        //         "responsive": true
        //         , "lengthChange": false
        //         , "autoWidth": false
        //         , "buttons": ["copy", "csv", "excel", "pdf", "print"]
        //         , "paging": true
        //         , "searching": true
        //         , "ordering": true
        //         , "info": true
        //         , "autoWidth": false
        //         , "responsive": true
        //     }).buttons().container().appendTo('#profitandLoss_wrapper .col-md-6:eq(0)');
        // });

    </script>

    <script>
        //GROSS PROFIT AND NET PROFIT

        var sales = $('#plsales').html()
        var purchase = $('#plpurchase').html()

        $('#grossprofit').html(sales - purchase)


        var totalExpense = 0;
        $('.plexpenseamt').each(function(input) {
            totalExpense += parseInt($(this).html());
        })

        $('#plnetprofit').html($('#grossprofit').html() - totalExpense)

    </script>

    <script>
        //TOTAL DEBT AMOUNT-DEBTORS LIST
        var d = 0;
        $('.debtPayable').each(function(input) {
            d += parseInt($(this).html()); // Or this.innerHTML, this.innerText
        })

        $('#totalDebt').html(d)

        //TOTAL QUANTITY-SALES REPORT
        var salesQuantity = 0;
        $('.salesQuantity').each(function(input) {
            salesQuantity += parseInt($(this).html());
        })
        $('#salesQuantity').html(salesQuantity)


        //TOTAL SALES -SALES REPORT
        var salesAmount = 0;
        $('.salesAmount').each(function(input) {
            salesAmount += parseInt($(this).html());
        })

        $('#salesAmount').html(salesAmount)



        //TOTAL REMAINING-OPEN LIST
        var remainingTotal = 0;
        $('.remainingTotal').each(function(input) {

            remainingTotal += parseInt($(this).html());
        })

        $('#remainingTotal').html(remainingTotal)

        //TOTAL PAID-OPEN LIST
        var paid = 0;
        $('.openPaid').each(function(input) {


            paid += parseInt($(this).html());

        })
        $('#paid').html(paid)


        //TOTAL PAID CLOSED LIST
        var closedPaid = 0;
        $('.closedPaid').each(function(input) {


            closedPaid += parseInt($(this).html());

        })
        $('#closedPaid').html(closedPaid)

    </script>

    <script>
        var totalPurchase = 0;
        $('.purchaseAmount').each(function(input) {
            totalPurchase += parseInt($(this).html()); // Or this.innerHTML, this.innerText

        });
        //TOTAL Purchase AMOUNTS FOR
        $('#totalPurchase').html(totalPurchase)

    </script>


</body>
</html>
