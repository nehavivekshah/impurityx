@extends('backend.layout')
@section('title','Orders - Impurity X')

@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection

@section('content')
@php
    $settings = session('settings');
    $access = explode(',', $settings[0]->access ?? '');
    $actions = explode(',', $settings[0]->actions ?? '');
@endphp
<style>
    .cursor-pointer {
      cursor: pointer;
    }
</style>
<section class="task__section">
    <div class="text header-text">Management Panel <span>Total Queries: <b>{{ count($orders) }}</b></span></div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>Orders</h1>
            @if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('3', $actions)))
            <form method="POST" action="/admin/buyer-orders/export" class="row m-none">
                @csrf
                <div class="d-flex g-1">
                    <input type="date" name="from_date" class="form-control me-2" required>
                    <input type="date" name="to_date" class="form-control me-2" required>
                    
                    <select name="with_attachments" class="form-control me-2">
                        <option value="">Include Attachments?</option>
                        <option value="yes">Yes</option>
                        <option value="no" selected>No</option>
                    </select>
                
                    <select name="status" class="form-control me-2">
                        <option value="all">All</option>
                        <option value="pending">Initiate</option>
                        <option value="active">Active</option>
                        <option value="selected">Selected</option>
                        <option value="awarded">Awarded</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="closed">Closed</option>
                    </select>
                    
                    <button type="submit" class="btn btn-success bg-success text-white me-2">Export</button>
                </div>
            </form>
            @endif
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Order ID</th>
                            <th>Buyer Details</th>
                            <th>Product Details</th>
                            <th>Order Details</th>
                            <th>Requirements</th>
                            <!--<th>Attachments</th>-->
                            <th>Auction End</th>
                            <th>Status</th>
                            <th>Seller Status</th>
                            <th>Seller Offer Status</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            
                            $now = \Carbon\Carbon::now();
                            
                        @endphp
                        
                        @foreach($orders as $key => $order)
                        
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
                            <td>{{ $key + 1 }}</td>
                            <td><strong>{{ $displayId }}</strong></td>
                            <td>
                                {!! $order->first_name . ' ' . $order->last_name !!}
                                <br><small>{{ $order->email }}</small>
                            </td>
                            <td>
                                {!! $order->sku ?? 'N/A' !!}<br>
                                {{ $order->name ?? 'N/A' }}
                            </td>
                            <td>
                                Qty: {{ $order->quantity }} {{ $order->uom }}<br>
                                Delivery: {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M, Y') }}<br>
                                Location: {{ $order->delivery_location }}
                            </td>
                            <!--<td>{{ $order->specific_requirements ?? 'N/A' }}</td>-->
                            <td>
                                @php $attachments = json_decode($order->attachments, true); @endphp
                                @if(!empty($attachments))
                                    @foreach($attachments as $file)
                                        <a href="{{ asset('public/' . $file) }}" target="_blank">View</a><br>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->auction_end)->format('d M, Y H:i') }}</td>
                            <td>
                                @if($order->status == 'requested')
                                    <a href="javascript:void(0)" class="badge bg-light border td-none text-dark">Buyer's Requested</a>
                                @elseif($order->status == 'pending')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Initiate</a>
                                @elseif($order->status == 'active')
                                    @if($order->auction_end > $now)
                                        <a href="javascript:void(0)" class="badge bg-success td-none">Active</a>
                                    @else
                                    
                                        @if($order->display_status === 'No Offer Recd')
                                            <a href="javascript:void(0)" class="badge bg-secondary td-none">No Offer Recd</a>
                                        @else
                                        <a href="javascript:void(0)" class="badge bg-warning text-dark td-none">Pending From Buyer</a>
                                        @endif
                                        
                                    @endif
                                @elseif($order->status == 'awarded')
                                    <a href="javascript:void(0)" class="badge bg-primary td-none">Order Awarded</a>
                                @elseif($order->status == 'selected')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Pending Confirmation</a>
                                @elseif($order->status == 'cancelled' && !empty($order->reject_order))
                                    <a href="javascript:void(0)" class="badge bg-danger td-none">Rejected From Buyer</a>
                                    <br><small class="text-center">{{ $order->reject_order ?? '' }}</small>
                                @elseif($order->status == 'cancelled')
                                    <a href="javascript:void(0)" class="badge bg-secondary td-none">Cancelled</a>
                                @else
                                    <a href="javascript:void(0)" class="badge bg-danger td-none">closed</a>
                                @endif
                            </td>
                            <td>
                                @if($order->seller_status == 'order-initiated')
                                    <a href="javascript:void(0)" class="badge bg-light border td-none text-dark">Order Initiated</a>
                                @elseif($order->seller_status == 'order-task-completed')
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Order Task Completed</a>
                                @elseif($order->seller_status == 'delivery-initiated')
                                    <a href="javascript:void(0)" class="badge bg-primary td-none">Delivery Initiated</a>
                                @elseif($order->seller_status == 'delivery-completed')
                                    <a href="javascript:void(0)" class="badge bg-success td-none">Delivery Completed</a>
                                @elseif($order->seller_status == 'accepted')
                                    <a href="javascript:void(0)" class="badge bg-success td-none">Buyer Accepted</a>
                                @else
                                    <a href="javascript:void(0)" class="badge bg-light text-dark text-center td-none">--</a>
                                @endif
                            </td>
                            <td>
                                @if($order->bid_view_status == '1')
                                    <a href="javascript:void(0)" id="{{ $order->id }}" data-page="orderSellerView" data-status="0" class="notify alert-success status">Active</a>
                                @else
                                    <a href="javascript:void(0)" id="{{ $order->id }}" data-page="orderSellerView" data-status="1" class="notify alert-danger status">Inactive</a>
                                @endif
                            </td>
                            <td style="min-width:100px;">{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                            <td style="min-width:80px;">
                                @if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('0', $actions)))
                                <a href="javascript:void(0)" id="{{ $order->id }}" class="notify-btn alert-info view" title="View Details" data-page="orders">
                                    <i class="bx bx-show"></i>
                                </a>
                                @endif
                                @if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('2', $actions)))
                                <a href="javascript:void(0)" class="notify-btn alert-warning edit-auction"
                                   data-id="{{ $order->id }}"
                                   data-status="{{ $order->status }}"
                                   data-sellerstatus="{{ $order->seller_status }}"
                                   data-date="{{ \Carbon\Carbon::parse($order->auction_end)->format('Y-m-d\TH:i') }}" title="Change Status">
                                   <i class="bx bx-cog"></i>
                                </a>
                                @endif
                                @if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('2', $actions)))
                                <a href="javascript:void(0)" class="notify-btn alert-dark edit-order"
                                   data-id="{{ $order->id }}"
                                   data-date="{{ \Carbon\Carbon::parse($order->auction_end)->format('Y-m-d\TH:i') }}" title="Edit Order Details">
                                   <i class="bx bx-edit"></i>
                                </a>
                                @endif
                                @if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('4', $actions)))
                                <a href="javascript:void(0)" class="notify alert-danger delete mt-1" id="{{ $order->id }}" data-page="delOrderStatus" title="Delete"><i class="bx bx-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sr No.</th>
                            <th>Order ID</th>
                            <th>Buyer Details</th>
                            <th>Product Details</th>
                            <th>Order Details</th>
                            <th>Requirements</th>
                            <!--<th>Attachments</th>-->
                            <th>Auction End</th>
                            <th>Status</th>
                            <th>Seller Status</th>
                            <th>Seller Offer Status</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

<section class="editAuctionModal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">Edit Auction End Date/Time</div>
            <div class="dismiss"><span class="bx bx-window-close close-edit-modal"></span></div>
        </div>
        <div class="editContent p-3">
            <form id="editAuctionForm" method="POST" action="/admin/update-auction-end">
                @csrf
                <input type="hidden" name="order_id" id="edit-order-id">
                <div class="mb-3">
                    <label for="auction_end">Auction End</label>
                    <input type="datetime-local" class="form-control" name="auction_end" id="auction-end-input" min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>
                </div>
                <div class="mb-3">
                    <label for="auction_end">Order Status</label>
                    <select name="status" id="edit-status" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <!--<option value="selected">Selected</option>-->
                        <option value="awarded">Awarded</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="editOrderModal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">Edit Order Details</div>
            <div class="dismiss"><span class="bx bx-window-close close-edit-order"></span></div>
        </div>
        <div class="editContent p-3">
            <form id="editOrderForm" method="POST" action="/admin/update-order-details" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" id="edit-orderid">
                
                <div class="mb-3">
                    <label>Quantity</label>
                    <input type="number" class="form-control" name="quantity" id="edit-quantity" min="1" required>
                </div>

                <div class="mb-3">
                    <label>Delivery Date</label>
                    <input type="date" class="form-control" name="delivery_date" id="edit-delivery-date" required>
                </div>

                <div class="mb-3">
                    <label>Delivery Location</label>
                    <input type="text" class="form-control" name="delivery_location" id="edit-delivery-location" required>
                </div>

                <div class="mb-3">
                    <label>Specific Requirements</label>
                    <textarea class="form-control" name="specific_requirements" id="edit-specific-req" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label>Attachments (optional)</label>
                    <input type="file" name="attachments[]" multiple class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="modal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close"></div>
        </div>
        <div class="content"></div>
    </div>
</section>

@endsection

@section('footlink')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    
    new DataTable('#example');
    
    $(document).ready(function(){
            
        // Open edit modal
        $(document).on('click', '.edit-auction', function () {
            let currentStatus = $(this).data('status');
            let currentsellerStatus = $(this).data('sellerstatus');
    
            $('#edit-order-id').val($(this).data('id'));
            $('#auction-end-input').val($(this).data('date'));
            $('#edit-status').val(currentStatus);
    
            // =============================
            // Keep your existing disable rules
            // =============================
            let disabledStatuses = ["selected", "awarded", "cancelled"];
            let disabledStatuses1 = ["awarded", "cancelled"];
            let disabledSellerStatuses = ["accepted"];
            
            if (disabledStatuses.includes(currentStatus)) {
                $('#auction-end-input').prop("readonly", true);
                
                if (disabledStatuses1.includes(currentStatus) 
                    && !disabledSellerStatuses.includes(currentsellerStatus)) {
                    $('#updateBtn').prop("disabled", true);
                }
            } else {
                $('#auction-end-input').prop("readonly", false);
                $('#updateBtn').prop("disabled", false);
            }
    
            // =============================
            // New rule for dropdown options
            // =============================
            $('#edit-status option').prop('disabled', false); // reset all
    
            if (currentStatus === "active") {
                $('#edit-status option[value="awarded"]').prop('disabled', true);
                $('#edit-status option[value="closed"]').prop('disabled', true);
            }
    
            if (currentStatus === "selected") {
                $('#edit-status option[value="pending"]').prop('disabled', true);
                $('#edit-status option[value="active"]').prop('disabled', true);
                $('#edit-status option[value="close"]').prop('disabled', true);
            }
    
            if (currentsellerStatus === "accepted") {
                $('#edit-status option[value="pending"]').prop('disabled', true);
                $('#edit-status option[value="active"]').prop('disabled', true);
                $('#edit-status option[value="awarded"]').prop('disabled', true);
                $('#edit-status option[value="cancelled"]').prop('disabled', true);
            }
    
            // Refresh if using bootstrap-select
            if ($.fn.selectpicker) {
                $('#edit-status').selectpicker('refresh');
            }
    
            $('.editAuctionModal').attr("style","display:flex;width:100%;height:100vh;");
        });
    
        $('.close-edit-modal').on('click', function () {
            $('.editAuctionModal').removeAttr("style");
        });
        
    });
    
    $(document).ready(function () {
    
        // Open "Edit Order Details" Modal
        $(document).on('click', '.edit-order', function () {
            const id = $(this).data('id');
    
            // Fetch order details via AJAX
            $.ajax({
                url: '/admin/get-order-edit-details/' + id,
                method: 'GET',
                success: function (response) {
                    if (response.success) {
                        let order = response.data;
                        $('#edit-orderid').val(order.id);
                        $('#edit-quantity').val(order.quantity);
                        $('#edit-delivery-date').val(order.delivery_date);
                        $('#edit-delivery-location').val(order.delivery_location);
                        $('.note-editable').html(order.specific_requirements ?? '');
    
                        $('.editOrderModal').attr("style","display:flex;width:100%;height:100vh;");
                    } else {
                        alert('Failed to fetch order details.');
                    }
                },
                error: function () {
                    alert('Error fetching order details.');
                }
            });
        });
    
        // Close modal
        $('.close-edit-order').on('click', function () {
            $('.editOrderModal').removeAttr("style");
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
    
<script type="text/javascript">
    $(document).ready(function () {
        $('#edit-specific-req').summernote({
            height: 300,
        });
    });
</script>

<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
@endsection