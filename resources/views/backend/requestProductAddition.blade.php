@extends('backend.layout')
@section('title','Request Product Addition - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- Link Styles -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection
@section('content')
@php
    $settings = session('settings');
    $access = explode(',', $settings[0]->access ?? '');
    $actions = explode(',', $settings[0]->actions ?? '');
@endphp
<section class="task__section">
    <div class="text header-text">Management Panel</div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>Request Product Addition</h1>
            <!--<a href="/admin/manage-category" class="btn btn-primary">Add New</a>-->
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Request ID</th>
                            <th>Buyer Name</th>
                            <th>Product Details</th>
                            <th>Attachments</th>
                            <th>Order Status</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rnpo as $k=>$com)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $com->request_id }}</td>
                                <td>{{ $com->first_name ?? '' }}<br>{{ $com->last_name ?? '' }}</td>
                                <td>{{ $com->name ?? '' }}<br>{{ $com->sku ?? '' }}</td>
                                <td>Qty: {{ $com->quantity ?? '' }}{{ $com->uom ?? '' }}<br>EDD: {!! date_format(date_create($com->delivery_date ?? null), 'd M, Y') !!}</td>
                                <td>
                                    <span class="badge 
                                        {{ $com->status == 0 ? 'bg-warning text-dark' : ($com->status == 1 ? 'bg-success' : 'bg-danger') }}">
                                        {{ $com->status == 0 ? 'Inprocess' : ($com->status == 1 ? 'Live' : 'Cancelled') }}
                                    </span>

                                </td>
                                <td>{{ $com->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('0', $actions)))
                                    <a href="javascript:void(0)"  class="notify-btn alert-info view" id="{{ $com->id }}" data-page="rnpo" title="View Details"><i class="bx bx-show"></i></a>
                                    @endif
                                    @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('2', $actions)))
                                    <a href="/admin/manage-product?id={{ $com->product_id }}&p=rpa" class="notify-btn alert-dark" title="Edit Product Details"><i class="bx bx-edit"></i></a>
                                    @endif
                                    @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('0', $actions)))
                                    <a href="javascript:void(0)"  class="notify-btn alert-primary view" id="{{ $com->order_id }}" data-page="orders" title="View Order Details"><i class="bx bx-cart"></i></a>
                                    @endif
                                    @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('2', $actions)))
                                    <a href="javascript:void(0)" class="notify-btn alert-dark edit-auction"
                                       data-id="{{ $com->order_id }}"
                                       data-status="{{ $com->status }}"
                                       data-date="{{ \Carbon\Carbon::parse($com->updated_at)->format('Y-m-d\TH:i') }}">
                                       <i class="bx bx-edit"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No Product order request found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Request ID</th>
                            <th>Buyer Name</th>
                            <th>Product Details</th>
                            <th>Attachments</th>
                            <th>Order Status</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
            <div>
        </div>
    </div>
</section>
<section class="editAuctionModal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">Publish a product add request</div>
            <div class="dismiss"><span class="bx bx-window-close close-edit-modal"></span></div>
        </div>
        <div class="editContent p-3">
            <form id="editAuctionForm" method="POST" action="/admin/update-auction-end">
                @csrf
                <input type="hidden" name="order_id" id="edit-order-id">
                <div class="mb-3">
                    <label for="auction_end">Auction End</label>
                    <input type="datetime-local" class="form-control" name="auction_end" id="auction-end-input" required>
                </div>
                <div class="mb-3">
                    <label for="auction_end">Order Status</label>
                    <select name="status" id="edit-status" class="form-control">
                        <option value="active">Published</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
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
<!-- Scripts -->
<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#example');
    
    $(document).ready(function(){
            
        // Open edit modal
        $(document).on('click', '.edit-auction', function () {
            let currentStatus = $(this).data('status');
    
            $('#edit-order-id').val($(this).data('id'));
            $('#auction-end-input').val($(this).data('date'));
            $('#edit-status').val(currentStatus);
    
            // =============================
            // Keep your existing disable rules
            // =============================
            let disabledStatuses = ["selected", "awarded", "cancelled"];
            let disabledStatuses1 = ["awarded", "cancelled"];
            
            if (disabledStatuses.includes(currentStatus)) {
                $('#auction-end-input').prop("readonly", true);
                
                if (disabledStatuses1.includes(currentStatus)) {
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
</script>
@endsection