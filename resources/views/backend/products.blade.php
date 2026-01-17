@extends('backend.layout')
@section('title','Products - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
    <div class="text header-text">Management Panel <span>Total Products: <b>{{ count($products) }}</b></span></div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>Products</h1>
            <div>
                @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('3', $actions)))
                <a href="/admin/products/export" class="btn btn-success bg-success text-white me-2">Export</a>
                @endif
                @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('1', $actions)))
                <a href="/admin/manage-product" class="btn btn-primary">Add New</a>
                @endif
            </div>
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            @if(Auth::user()->role=='0')
                            <th>Branch</th>
                            @endif
                            <th>Title</th>
                            <th>SKU</th>
                            <th>CAS No</th>
                            <th>UoM</th>
                            <th>HSN</th>
                            <th>GST</th>
                            <th>Featured</th>
                            <th>New</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-content">
                        @foreach($products as $key=>$product)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            @if(Auth::user()->role=='0')
                            <td>{{ $product->branch }}</td>
                            @endif
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->cas_no }}</td>
                            <td>{{ $product->uom }}</td>
                            <td>{{ $product->hsn_code }}</td>
                            <td>{{ $product->gst }}%</td>
                            <td>{{ $product->featured == 1 ? 'Yes' : 'No' }}</td>
                            <td>{{ $product->new == 1 ? 'Yes' : 'No' }}</td>
                            <td>
                                @if($product->status=='1')
                                <a href="javascript:void(0)" class="notify alert-success status" id="{{ $product->id }}" data-status="2" data-page="productStatus">Active</a>
                                @else
                                <a href="javascript:void(0)" class="notify alert-danger status" id="{{ $product->id }}" data-status="1" data-page="productStatus">Inactive</a>
                                @endif
                            </td>
                            <td><img src="{{ asset('public/assets/frontend/img/products/'.$product->img) }}" class="input-img rounded" height="50" /></td>
                            <td>{!! date_format(date_create($product->updated_at),'d M, Y h:i A') !!}</td>
                            <td style="width:80px;">
                                @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('2', $actions)))
                                <a href="/admin/manage-product?id={{ $product->id }}" class="notify-btn alert-primary" title="Edit Details"><i class="bx bx-edit"></i></a>
                                @endif
                                @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('4', $actions)))
                                <a href="javascript:void(0)"  class="notify-btn alert-danger delete" id="{{ $product->id }}" data-page="productDelete" title="Delete"><i class="bx bx-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sr No.</th>
                            @if(Auth::user()->role=='0')
                            <th>Branch</th>
                            @endif
                            <th>Title</th>
                            <th>SKU</th>
                            <th>CAS No</th>
                            <th>UoM</th>
                            <th>HSN</th>
                            <th>GST</th>
                            <th>Featured</th>
                            <th>New</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
<section class="modal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close"></span></div>
        </div>
        <div class="content"></div>
    </div>
</section>
@endsection
@section('footlink')
<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#example');
</script>
@endsection
