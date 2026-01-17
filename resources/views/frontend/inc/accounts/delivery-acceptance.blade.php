<style>
    @media(max-width:768px) {
        .form-control {
            padding: .375rem 3px !important;
        }

        .w-45 input {
            width: 100%;
        }
    }
</style>
<div class="dashboard-area box--shadow">
    <div class="row gy-4 mt-0 mb-4">
        <div class="col-md-12 px-4">
            <form method="POST" action="/my-account/my-orders/export" class="row bg-light border py-3">
                @csrf
                <div class="col-md-12">
                    <div class="row">
                        <div class="col">
                            <h4>Export Orders</h4>
                        </div>
                        <div class="col" style="text-align:right;">
                            <button type="submit" class="btn btn-success">Export</button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-md-7">
                    <label>Date Range</label>
                    <div class="d-flex w-45">
                        <input type="date" name="from_date" class="form-control me-2" required>
                        <input type="date" name="to_date" class="form-control" required>
                    </div>
                </div>
                <!--<div class="mb-3 col-md-4">
                    <label>Include Attachments?</label>
                    <select name="with_attachments" class="form-control">
                        <option value="yes">Yes</option>
                        <option value="no" selected>No</option>
                    </select>
                </div>-->
                <div class="mb-3 col-md-5">
                    <label>Status</label>
                    <select name="seller_status" class="form-control">
                        <option value="all">All</option>
                        <option value="order-initiated">Order Initiated</option>
                        <option value="order-task-completed">Order Task Completed</option>
                        <option value="delivery-initiated">Delivery Initiated</option>
                        <option value="delivery-completed">Delivery Completed</option>
                        <option value="accepted">Buyer Accepted</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="col-md-12 px-3 bg-white">
            <table id="example" class="table table-striped border rounded" style="width:100%;font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center" width="50px">#</th>
                        <th>Order ID</th>
                        <th>Product Details</th>
                        <th>Order Details</th>
                        <!--<th class="text-center">Applications</th>-->
                        <th>Seller</th>
                        <th>Order Val.</th>
                        <th class="text-center">Seller Status</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created On</th>
                        <th class="text-center" width="90px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $now = \Carbon\Carbon::now();
                    @endphp
                    @foreach($myorders as $key => $order)
                        @php

                            $month = date('m', strtotime($order->created_at));
                            $year = date('Y', strtotime($order->created_at));

                            if ($month >= 3) {
                                // March to Dec
                                $fy_start = date('y', strtotime($order->created_at));
                                $fy_end = date('y', strtotime('+1 year', strtotime($order->created_at)));
                            } else {
                                // Jan-Feb
                                $fy_start = date('y', strtotime('-1 year', strtotime($order->created_at)));
                                $fy_end = date('y', strtotime($order->created_at));
                            }

                            $financialYear = $fy_start . '' . $fy_end;

                        @endphp
                        <tr>
                            <td class="text-center" width="50px">{{ $key + 1 }}</td>
                            <td><strong>
                                    @if(!empty($order->financial_year) && !empty($order->fy_sequence))
                                        {{ $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT) }}
                                    @else
                                        {{ $financialYear . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                    @endif
                                </strong></td>
                            <td>
                                {!! $order->sku ?? 'N/A' !!}<br>
                                {{ $order->name ?? 'N/A' }}
                            </td>
                            <td>
                                Qty: {{ $order->quantity }} {{ $order->uom }}<br>
                                Delivery:
                                {{ \Carbon\Carbon::parse($order->awarded_date)->addDays($order->days)->format('d M, Y') }}
                            </td>
                            <td>
                                {!! $order->first_name ?? '' !!} {!! $order->last_name ?? '' !!}<br>
                                Price: {{ $order->price ?? '' }} /-
                            </td>
                            <td>
                                Rs. {!! ($order->price ?? 0) * ($order->quantity ?? 0) !!} /-
                            </td>
                            <td class="text-center">
                                @if($order->status == 'pending')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Initiate</a>
                                @elseif($order->status == 'active')
                                    @if($order->auction_end > $now)
                                        <a href="javascript:void(0)" class="badge bg-success td-none">Acitve</a>
                                    @else
                                        <a href="javascript:void(0)" class="badge bg-danger td-none">Select Bid</a>
                                    @endif
                                @elseif($order->status == 'awarded')
                                    <a href="javascript:void(0)" class="badge bg-primary td-none">Order Awarded</a>
                                @elseif($order->status == 'selected')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Admin to confirm</a>
                                @elseif($order->status == 'cancelled')
                                    <a href="javascript:void(0)" class="badge bg-secondary td-none">Cancelled</a>
                                @else
                                    <a href="javascript:void(0)" class="badge bg-danger td-none">closed</a>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($order->seller_status == 'order-initiated')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Order Initiated</a>
                                @elseif($order->seller_status == 'order-task-completed')
                                    <a href="javascript:void(0)" class="badge bg-primary td-none">Order Task Completed</a>
                                @elseif($order->seller_status == 'delivery-initiated')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Delivery
                                        Initiated</a>
                                @elseif($order->seller_status == 'delivery-completed')
                                    <a href="javascript:void(0)" class="badge bg-success td-none">Delivery Completed</a>
                                @elseif($order->seller_status == 'accepted')
                                    <a href="javascript:void(0)" class="badge bg-success td-none">Delivery Accepted</a>
                                @else
                                    <a href="javascript:void(0)" class="badge bg-secondary td-none">--</a>
                                @endif
                            </td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                            <td class="text-center" width="90px">
                                <a href="javascript:void(0)" id="{{ $order->id }}" class="btn btn-sm btn-info view"
                                    title="View Details" data-page="awardedorders">
                                    <i class="bx bx-show"></i>
                                </a>
                                @if($order->seller_status == 'delivery-completed')
                                    <a href="/my-account/delivery-acceptance?id={{ $order->id }}&status=accepted"
                                        class="btn btn-sm btn-success" title="Accepted" data-page="accepted"
                                        onclick="return confirm('Please check for order completeness in terms of quality and quantity before Delivery Acceptance.')">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center" width="50px">#</th>
                        <th>Order ID</th>
                        <th>Product Details</th>
                        <th>Order Details</th>
                        <!--<th>Requirements</th>-->
                        <!--<th class="text-center">Applications</th>-->
                        <th>Seller</th>
                        <th>Order Val.</th>
                        <th class="text-center">Seller Status</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created On</th>
                        <th class="text-center" width="90px">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<section class="modal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close"></div>
        </div>
        <div class="content"></div>
    </div>
</section>
@section('footlink')
    <script>
        new DataTable('#example');
    </script>
    <script>
        $(document).ready(function () {
            $('.view').click(function () {
                var selector = $(this);
                var selectorId = selector.attr("id");
                var pagename = selector.attr("data-page");
                $('.content').html("<div class='spinner'><p style='text-align: center; margin: 35px; font-size: 14px; font-weight: 500; opacity: 0.9;'>Loading...</p></div>");
                $.ajax({
                    type: 'get',
                    url: "/dbaction",
                    data: {
                        selectorId: selectorId,
                        pagename: pagename
                    },
                    beforeSend: function () {
                        $('.modal').attr("style", "display:flex;width:100%;height:100vh;");
                    },
                    success: function (response) {
                        $('.content').html(response);
                        //alert(response);
                        console.log(response);
                    },
                    complete: function (response) {
                        //alert(response);
                        //console.log(response);
                    }
                });
            });
        });
    </script>
    <script>
        document.querySelector('.dismiss').addEventListener('click', function () {
            document.querySelector('.modal').style.display = 'none';
        });
    </script>
@endsection