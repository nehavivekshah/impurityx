@extends('backend.layout')
@section('title','Post Category - Impurity X')
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
    <div class="text header-text">Management Panel <span>Total Post Category: <b>{{ count($postCategory) }}</b></span></div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>Post Categories</h1>
            @if(Auth::user()->role == '1' || (in_array('1', $access) && in_array('1', $actions)))
            <a href="/admin/manage-post-category" class="btn btn-primary">Add New</a>
            @endif
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
                            <th>TItle</th>
                            <th>Photo</th>
                            <th>Created On</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-content">
                        @foreach($postCategory as $key=>$category)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            @if(Auth::user()->role=='0')
                            <td>{{ $category->name }}</td>
                            @endif
                            <td>{{ $category->title }}</td>
                            <td><img src="{{ asset('/public/assets/frontend/img/postCategory/'.$category->imgs) }}" class="input-img rounded" /></td>
                            <td>{{ date_format(date_create($category->created_at), 'd M, Y') }}</td>
                            <td>
                                @if($category->status=='1')
                                <a href="javascript:void(0)" class="notify alert-success status" id="{{ $category->id }}" data-status="2" data-page="postCategoryStatus">Active</a>
                                @else
                                <a href="javascript:void(0)" class="notify alert-danger status" id="{{ $category->id }}" data-status="1" data-page="postCategoryStatus">Deactive</a>
                                @endif
                            </td>
                            <td style="width:150px;">
                                @if(Auth::user()->role == '1' || (in_array('1', $access) && in_array('2', $actions)))
                                <a href="/admin/manage-post-category?id={{ $category->id }}" class="notify-btn alert-primary" title="Edit Details"><i class="bx bx-edit"></i></a>
                                @endif
                                @if(Auth::user()->role == '1' || (in_array('1', $access) && in_array('4', $actions)))
                                <a href="javascript:void(0)"  class="notify-btn alert-danger delete" id="{{ $category->id }}" data-page="delpostCategoryStatus" title="Delete"><i class="bx bx-trash"></i></a>
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
                            <th>TItle</th>
                            <th>Photo</th>
                            <th>Created On</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            <div>
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
</script>
@endsection