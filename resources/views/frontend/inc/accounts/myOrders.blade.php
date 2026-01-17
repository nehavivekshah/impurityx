<style>
    @media(max-width: 767px) {
        .form-control {
            padding: .375rem 3px;
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

                <div class="mb-3 col-md-4">
                    <label>Date Range</label>
                    <div class="d-flex">
                        <input type="date" name="from_date" class="form-control me-2" required>
                        <input type="date" name="to_date" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3 col-md-4">
                    <label>Include Attachments?</label>
                    <select name="with_attachments" class="form-control">
                        <option value="yes">Yes</option>
                        <option value="no" selected>No</option>
                    </select>
                </div>

                <div class="mb-3 col-md-4">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="all">All</option>
                        <option value="pending">Initiate</option>
                        <option value="active">Active</option>
                        <option value="selected">Selected</option>
                        <option value="awarded">Awarded</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="col-md-12 px-3 bg-white">
            <table id="example" class="table table-striped border rounded" style="width:100%;font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center" style="min-width:50px!important;">#</th>
                        <th style="min-width:70px!important;">OrderID</th>
                        <th style="min-width:170px!important;">Product Details</th>
                        <th style="min-width:170px!important;">Order Details</th>
                        <!--<th>Requirements</th>-->
                        <th class="text-center">Attachments</th>
                        <th class="text-center" style="min-width:70px!important;">L1 Rate</th>
                        <th class="text-center" style="min-width:120px!important;">Award Date</th>
                        <th class="text-center" style="min-width:120px!important;">Offer End by</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="min-width:120px!important;">Created On</th>
                        <th class="text-center sticky-column" style="min-width:90px!important;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php

                        $now = \Carbon\Carbon::now();

                    @endphp
                    @foreach($myorders as $key => $order)

                        @if(!empty($order->financial_year) && !empty($order->fy_sequence))
                            @php $displayId = $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT); @endphp
                        @else
                            @php
                                $month = date('m', strtotime($order->created_at));
                                if ($month >= 4) {
                                    $fy_start = date('y', strtotime($order->created_at));
                                    $fy_end = date('y', strtotime('+1 year', strtotime($order->created_at)));
                                } else {
                                    $fy_start = date('y', strtotime('-1 year', strtotime($order->created_at)));
                                    $fy_end = date('y', strtotime($order->created_at));
                                }
                                $displayId = $fy_start . '' . $fy_end . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
                            @endphp
                        @endif
                        <tr>
                            <td class="text-center" style="min-width:50px!important;">{{ $key + 1 }}</td>
                            <td style="min-width:70px!important;"><strong>{{ $displayId }}</strong></td>
                            <td style="min-width:170px!important;">
                                {!! $order->sku ?? '' !!}<br>
                                {{ $order->name ?? '' }}<br>
                                <b>CAS No.:</b> {{ $order->cas_no ?? '' }}
                            </td>
                            <td style="min-width:170px!important;">
                                Qty: {{ $order->quantity }} {{ $order->uom }}<br>
                                Delivery: {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M, Y') }}
                            </td>
                            <!--<td>{{ $order->specific_requirements ?? 'N/A' }}</td>-->
                            <td class="text-center">
                                @php $attachments = json_decode($order->attachments, true); @endphp
                                @if(!empty($attachments))
                                    @foreach($attachments as $file)
                                        <a href="{{ asset('public/' . $file) }}" class="btn btn-primary btn-sm" target="_blank"
                                            style="font-size:12px;font-weight:600;">View</a>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-center" style="min-width:70px!important;">
                                @if(!empty($order->l1_rate) && ($order->l1_rate > 0)) Rs. {{ $order->l1_rate }} @else --
                                @endif</td>
                            <td class="text-center" style="min-width:120px!important;">
                                @if($order->status == 'awarded'){{ \Carbon\Carbon::parse($order->awarded_date)->format('d M, Y') }}@endif
                            </td>
                            <td class="text-center" style="min-width:120px!important;">@if(!empty($order->auction_end))
                            {{ \Carbon\Carbon::parse($order->auction_end)->format('d M, Y H:i') }} @else -- @endif</td>
                            <td class="text-center">
                                @if($order->status == 'pending')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Initiate</a>
                                @elseif($order->status == 'active')
                                    @if($order->auction_end > $now)
                                        <a href="javascript:void(0)" class="badge bg-success td-none">Active</a>
                                    @else

                                        @if($order->display_status === 'No Offer Recd')
                                            <a href="javascript:void(0)" class="badge bg-secondary td-none">No Offer Recd</a>
                                        @else
                                            <a href="javascript:void(0)" class="badge bg-warning text-dark td-none">Select Offer</a>
                                        @endif

                                    @endif
                                @elseif($order->status == 'awarded')
                                    <a href="javascript:void(0)" class="badge bg-primary td-none">Order Awarded</a>
                                @elseif($order->status == 'selected')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Admin to confirm</a>
                                @elseif($order->status == 'requested')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Requested</a>
                                @elseif($order->status == 'cancelled')
                                    @if(!empty($order->reject_order))
                                        <a href="javascript:void(0)" class="badge bg-danger td-none">Rejected</a>
                                        <br><span class="small mt-1">{{ $order->reject_order ?? '' }}</span>
                                    @else
                                        <a href="javascript:void(0)" class="badge bg-danger td-none">Cancelled</a>
                                    @endif
                                @else
                                    <a href="javascript:void(0)" class="badge bg-danger td-none">closed</a>
                                @endif
                            </td>
                            <td class="text-center" style="min-width:120px!important;">
                                {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                            <td class="text-center sticky-column" style="min-width:90px!important;">
                                <a href="javascript:void(0)" id="{{ $order->id }}" class="btn btn-sm btn-info view"
                                    title="View Order Details" data-page="orders">
                                    <i class="bx bx-show"></i>
                                </a>

                                @if(empty($order->reject_order))
                                    <a href="javascript:void(0)" id="{{ $order->id }}" class="btn btn-sm btn-warning view"
                                        title="View Bidding Details" data-page="bids">
                                        <i class="fas fa-gavel fa-flip-horizontal"></i>
                                    </a>
                                @endif

                                @if($order->status == 'active' && $order->auction_end < $now)
                                    <a href="javascript:void(0)" id="{{ $order->id }}" class="btn btn-sm btn-danger reject"
                                        title="Reject Order" data-page="reject_order">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                @endif

                                @if($order->status == 'closed')
                                    <a href="/product/{{ $order->slog ?? '' }}" class="btn btn-sm btn-primary" title="Re-Order">
                                        <i class="bx bx-repeat"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center" style="min-width:50px!important;">#</th>
                        <th style="min-width:70px!important;">OrderID</th>
                        <th style="min-width:170px!important;">Product Details</th>
                        <th style="min-width:170px!important;">Order Details</th>
                        <!--<th>Requirements</th>-->
                        <th class="text-center">Attachments</th>
                        <th class="text-center" style="min-width:70px!important;">L1 Rate</th>
                        <th class="text-center" style="min-width:120px!important;">Award Date</th>
                        <th class="text-center" style="min-width:120px!important;">Offer End by</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="min-width:120px!important;">Created On</th>
                        <th class="text-center sticky-column" style="min-width:90px!important;">Action</th>
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
                    data: { selectorId: selectorId, pagename: pagename },

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

            $('.reject').click(function () {
                var selector = $(this);
                var rowid = selector.attr("id");
                var pagename = selector.attr("data-page");

                // Check if buyer really wants to reject
                var confirmReject = confirm("Are you sure you want to reject this order?");
                if (confirmReject) {
                    // Ask for reason
                    var reason = prompt("Please enter the reason for rejecting this order:");

                    if (reason !== null && reason.trim() !== "") {
                        $.ajax({
                            type: 'get',
                            url: "/dbaction",
                            data: {
                                //_token: $('meta[name="csrf-token"]').attr('content'),
                                selectorId: rowid,
                                pagename: pagename,
                                reason: reason
                            },
                            success: function (response) {
                                console.log(response);
                                if (response.status === 'success') {
                                    alert(response.message);
                                    // Optionally hide reject button
                                    selector.hide();
                                } else {
                                    alert("Error: " + response.message);
                                }
                            },
                            error: function () {
                                alert("Something went wrong!");
                            }
                        });
                    } else if (reason !== null) {
                        alert("You must provide a reason to reject the order!");
                    }
                } else {
                    alert("Order rejection cancelled.");
                }
            });

        });
    </script>

    <script>
        document.querySelector('.dismiss').addEventListener('click', function () {
            document.querySelector('.modal').style.display = 'none';
        });
    </script>

@endsection