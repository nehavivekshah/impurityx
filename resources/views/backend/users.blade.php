<?php $page_title = $page; ?>
@extends('backend.layout')
@section('title', ucfirst($page_title).'- Impurity X')
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
    <div class="text header-text">Management Panel <span>Total Member: <b>{{ count($users) }}</b></span></div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>{{ $page_title }}</h1>
            @if($page!='all users')
            @if(Auth::user()->role == '1' || (in_array('2', $access) && in_array('1', $actions)))
            <!--<a href="manage-user?dir={{ $page[1] }}" class="btn btn-primary">Add New</a>-->
            @endif
            @if(Auth::user()->role == '1' || (in_array('2', $access) && in_array('3', $actions)))
            <form method="POST" action="/admin/{{$page}}/exportUser" class="row m-none">
                @csrf
                <div class="d-flex g-1">
                    <input type="date" name="from_date" class="form-control me-2" required>
                    <input type="date" name="to_date" class="form-control me-2" required>
                    <button type="submit" class="btn btn-success bg-success text-white me-2">Export</button>
                </div>
            </form>
            @endif
            @endif
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile No.</th>
                            <th>Email Id</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $k=>$user)
                        <tr>
                            <td>{!! $k+1 !!}</td>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->mob }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role=='1')
                                <span class="fw-bold text-primary">Admin</span>
                                @elseif($user->role=='2')
                                <span class="fw-bold text-danger">Manager</span>
                                @elseif($user->role=='3')
                                <span class="fw-bold text-info">Agent</span>
                                @elseif($user->role=='4')
                                <span class="fw-bold text-success">Seller</span>
                                @else
                                <span class="fw-bold text-secondary">Buyer</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status=='1')
                                <a href="javascript:void(0)" class="notify alert-success status" id="{{ $user->id }}" data-status="2" data-page="userStatus">Active</a>
                                @else
                                <a href="javascript:void(0)" class="notify alert-danger status" id="{{ $user->id }}" data-status="1" data-page="userStatus">Deactive</a>
                                @endif
                            </td>
                            <td>{{ date_format(date_create($user->updated_at), 'd M, Y') }}</td>
                            <td>{{ date_format(date_create($user->created_at), 'd M, Y') }}</td>
                            <td width="120px">
                                @if(Auth::user()->role == '1' || (in_array('2', $access) && in_array('0', $actions)))
                                <a href="javascript:void(0)" class="notify alert-info view" id="{{ $user->id }}" data-page="User" title="View Details"><i class="bx bx-show"></i></a>
                                @endif
                                @if(Auth::user()->role == '1' || (in_array('2', $access) && in_array('2', $actions)))
                                <a href="manage-user?id={{ $user->id }}" class="notify alert-primary" title="Edit Details"><i class="bx bx-edit"></i></a>
                                @endif
                                @if(Auth::user()->role == '1' || (in_array('2', $access) && in_array('4', $actions)))
                                <a href="javascript:void(0)" class="notify alert-danger delete" id="{{ $user->id }}" data-page="delUserStatus" title="Delete"><i class="bx bx-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile No.</th>
                            <th>Email Id</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Date</th>
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