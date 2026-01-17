<style>
    .nice-select {
        width: 100%;
        height: 45px !important;
        line-height: 30px !important;
        float: unset;
    }

    .is-readonly {
        background-color: #f1f1f1;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .w-45 input {
            width: 50%;
        }
    }
</style>
<div class="dashboard-area box--shadow">
    <div class="row gy-4 mt-0 mb-4">

        <div class="col-md-12 px-4">
            <form method="POST" action="/seller/my-account/my-orders/export" class="row bg-light border py-3">
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
                    <div class="d-flex w-45">
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
                    <label>Seller Status</label>
                    <select name="seller_status" class="form-control">
                        <option value="all">All</option>
                        <option value="order-initiated">Order Initiated</option>
                        <option value="order-task-completed">Order Task Completed</option>
                        <option value="delivery-initiated">Delivery Initiated</option>
                        <option value="delivery-completed">Delivery Completed</option>
                        <option value="accepted">Delivery Accepted</option>
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
                        <!--<th>Requirements</th>-->
                        <th class="text-center">Attachments</th>
                        <th class="text-center">Auction End</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Seller Status</th>
                        <th class="text-center">Created On</th>
                        <th class="text-center" width="90px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php

                        $now = \Carbon\Carbon::now();

                    @endphp
                    @foreach($myorders as $key => $order)
                        <tr>
                            <td class="text-center" width="50px">{{ $key + 1 }}</td>
                            <td><strong>
                                    @if(!empty($order->financial_year) && !empty($order->fy_sequence))
                                        {{ $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT) }}
                                    @else
                                        {{ date('y', strtotime($order->created_at)) . (date('y', strtotime($order->created_at)) + 1) . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                    @endif
                                </strong><br>
                                {{ $order->first_name . ' ' . $order->last_name }}<br>
                                @if($order->status == 'awarded')<small>{{ $order->email }}</small>@endif
                            </td>
                            <td>
                                {!! $order->sku ?? '' !!}<br>
                                {{ $order->name ?? '' }}<br>
                                <small><strong>CAS No.:</strong> {{ $order->cas_no ?? '' }}</small>
                            </td>
                            <td>
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
                            <td class="text-center">@if(!empty($order->auction_end))
                            {{ \Carbon\Carbon::parse($order->auction_end)->format('d M, Y H:i') }} @else -- @endif</td>
                            <td class="text-center">
                                @if($order->status == 'pending')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Initiate</a>
                                @elseif($order->status == 'active')
                                    @if($order->auction_end > $now)
                                        <a href="javascript:void(0)" class="badge bg-success td-none">Acitve</a>
                                    @else
                                        <a href="javascript:void(0)" class="badge bg-warning text-dark td-none">Select Bid</a>
                                    @endif
                                @elseif($order->status == 'awarded')
                                    <a href="javascript:void(0)" class="badge bg-primary td-none">Order Awarded</a>
                                @elseif($order->status == 'selected')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Admin to confirm</a>
                                @elseif($order->status == 'cancelled')
                                    <a href="javascript:void(0)" class="badge bg-secondary td-none">Cancelled</a>
                                @elseif($order->seller_status == 'accepted')
                                    <a href="javascript:void(0)" class="badge bg-success td-none">Delivery Accepted</a>
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
                                    title="View Details" data-page="sellerawardedorders">
                                    <i class="bx bx-show"></i>
                                </a>
                                @if($order->seller_status != 'accepted')
                                    <a href="javascript:void(0)" class="btn btn-sm btn-dark edit-auction"
                                        data-id="{{ $order->id }}" data-sellerstatus="{{ $order->seller_status }}"
                                        data-invoiceno="{{ $order->invoice_no }}" data-couriername="{{ $order->courier_name }}"
                                        data-trackingid="{{ $order->tracking_id }}"
                                        data-courierdate="{{ $order->courier_date }}"
                                        data-invoicedate="{{ $order->invoice_date }}"
                                        data-date="{{ \Carbon\Carbon::parse($order->invoice_date)->format('Y-m-d\TH:i') }}">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                @endif
                                <a href="/seller/dbaction?selectorId={{ $order->id }}&pagename=sellerawardedordersexport"
                                    class="btn btn-sm btn-primary" title="Download Order's Details">
                                    <i class="bx bx-download"></i>
                                </a>
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
                        <th class="text-center">Attachments</th>
                        <th class="text-center">Auction End</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Seller Status</th>
                        <th class="text-center">Created On</th>
                        <th class="text-center" width="90px">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<section class="editAuctionModal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">Edit Order Details</div>
            <div class="dismiss"><span class="bx bx-window-close close-edit-modal"></span></div>
        </div>
        <div class="editContent p-3">
            <form id="editOrderForm" method="POST" action="/seller/update-order-seller-status"
                style="min-height: 290px;">
                @csrf
                <input type="hidden" name="order_id" id="edit-order-id">
                <div class="mb-3">
                    <label for="order-status">Order Status</label>
                    <select name="seller_status" id="edit-status" class="form-control">
                        <option value="order-initiated">Order initiated</option>
                        <option value="order-task-completed">Order task completed</option>
                        <option value="delivery-initiated">Delivery Initiated</option>
                        <option value="delivery-completed">Delivery Completed</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="invoice_no">Invoice No.</label>
                    <input type="text" class="form-control" name="invoice_no" maxlength="15" id="invoice_no">
                </div>
                <div class="mb-3">
                    <label for="courier_name">Courier Name</label>
                    <input type="text" class="form-control" name="courier_name" maxlength="50" id="courier_name">
                </div>
                <div class="mb-3">
                    <label for="tracking_id">Tracking ID</label>
                    <input type="text" class="form-control" name="tracking_id" maxlength="50" id="tracking_id">
                </div>
                <div class="mb-3">
                    <label for="courier_date">Courier Date</label>
                    <input type="date" class="form-control" name="courier_date" id="courier_date">
                </div>
                <div class="mb-3">
                    <label for="invoice_date">Invoice Date</label>
                    <input type="date" class="form-control" name="invoice_date" id="invoice_date"
                        max="{{ date('Y-m-d') }}">
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="modal modal-popup">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close close-modal-popup"></div>
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

            // Initialize once (safe even if already initialized)
            $(function () {
                if ($.fn.niceSelect && !$('#edit-status').next().hasClass('nice-select')) {
                    $('#edit-status').niceSelect();
                }
            });

            // Normalize any status string to the option value format
            function normalizeStatus(v) {
                if (!v) return "";
                v = String(v).trim();
                const map = {
                    "Order initiated": "order-initiated",
                    "Order task completed": "order-task-completed",
                    "Delivery Initiated": "delivery-initiated",
                    "Delivery Completed": "delivery-completed"
                };
                return map[v] || v.toLowerCase().replace(/\s+/g, "-");
            }

            // Show/hide and enable/readonly invoice fields
            function toggleInvoiceFields(val) {
                const status = normalizeStatus(val);
                const show = status === "delivery-initiated" || status === "delivery-completed";
                const readonly = status === "delivery-completed";

                const $fields = $('#invoice_no, #courier_name, #tracking_id, #courier_date, #invoice_date');
                const $groups = $fields.closest('.mb-3');

                if (show) {
                    $groups.show();
                    // Keep enabled so values submit; use readonly to “disable” editing
                    $fields.prop('disabled', false)
                        .prop('readonly', readonly)
                        .toggleClass('is-readonly', readonly);
                    // Required only when user must input (delivery-initiated)
                    $fields.prop('required', !readonly);
                } else {
                    $groups.hide();
                    $fields.prop({ disabled: false, readonly: false, required: false })
                        .removeClass('is-readonly');
                }
            }

            // Status sequence
            const statusFlow = [
                { label: "Order initiated", value: "order-initiated" },
                { label: "Order task completed", value: "order-task-completed" },
                { label: "Delivery Initiated", value: "delivery-initiated" },
                { label: "Delivery Completed", value: "delivery-completed" }
            ];

            // Helper to rebuild <select> based on current status
            function updateStatusOptions(current) {
                let idx = statusFlow.findIndex(s => s.value === normalizeStatus(current));
                let $select = $('#edit-status');
                $select.empty();

                if (idx === -1) {
                    // No status yet → allow first step
                    $select.append(`<option value="${statusFlow[0].value}">${statusFlow[0].label}</option>`);
                } else {
                    // Show current as disabled (for display)
                    $select.append(`<option value="${statusFlow[idx].value}" selected readonly>
                  ${statusFlow[idx].label}
                </option>`);

                    // Add next step if available
                    if (idx + 1 < statusFlow.length) {
                        $select.append(`<option value="${statusFlow[idx + 1].value}">
                    ${statusFlow[idx + 1].label}
                  </option>`);
                    }
                }

                // Refresh nice-select if active
                if ($.fn.niceSelect) {
                    $select.niceSelect('update');
                }
            }

            // OPEN MODAL: set values and options
            $(document).on('click', '.edit-auction', function () {
                let currentStatus = normalizeStatus($(this).data('sellerstatus') || "");

                $('#edit-order-id').val($(this).data('id'));
                $('#invoice_no').val($(this).data('invoiceno') || "");
                $('#courier_name').val($(this).data('couriername') || "");
                $('#tracking_id').val($(this).data('trackingid') || "");
                $('#courier_date').val($(this).data('courierdate') || "");
                $('#invoice_date').val($(this).data('invoicedate') || "");

                let raw = $(this).data('date') || "";
                let dateOnly = String(raw).split('T')[0] || "";
                $('#invoice_date').val(dateOnly);

                // Build select dynamically
                updateStatusOptions(currentStatus);

                // Trigger invoice field toggle
                $('#edit-status').trigger('change');

                $('.editAuctionModal').attr("style", "display:flex;width:100%;height:100vh;");
            });

            // On change, handle invoice field visibility
            $(document).on('change', '#edit-status', function () {
                toggleInvoiceFields(this.value);
            });

            // Fallback: capture clicks on nice-select options
            $(document).on('click', '#edit-status + .nice-select .option', function () {
                const val = $(this).data('value');
                $('#edit-status').val(val).trigger('change');
            });

            // Start hidden by default (in case the page loads with open modal)
            toggleInvoiceFields($('#edit-status').val());


            $('.close-edit-modal').on('click', function () {
                $('.editAuctionModal').removeAttr("style");
            });

            $('.view').click(function () {
                var selector = $(this);
                var selectorId = selector.attr("id");
                var pagename = selector.attr("data-page");
                $('.content').html("<div class='spinner'><p style='text-align: center; margin: 35px; font-size: 14px; font-weight: 500; opacity: 0.9;'>Loading...</p></div>");
                $.ajax({
                    type: 'get',
                    url: "/seller/dbaction",
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

            $('.close-modal-popup').on('click', function () {
                $('.modal-popup').removeAttr("style");
            });

        });

    </script>

@endsection