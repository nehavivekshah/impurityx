@extends('backend.layout')
@section('title', 'Permission Settings - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- Link Styles -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection
@section('content')
@php
    $cur_settings = session('settings');
    $access = explode(',', $cur_settings[0]->access ?? '');
    $actions = explode(',', $cur_settings[0]->actions ?? '');
@endphp
<section class="task__section">
    <div class="text header-text">{{ session('sc') }} <span>Total Permissions: <b>{{ count($settings) }}</b></span></div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>Permissions</h1>
            <!--<a href="/admin/manage-permission" class="btn btn-primary">Add New</a>-->
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:50px;">Sr. No.</th>
                            @if(Auth::user()->role == '11')
                            <th>Society</th>
                            @endif
                            <th>Role</th>
                            <th>Permissions</th>
                            <th style="width:100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($settings as $key=>$setting)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            @if(Auth::user()->role == '11')
                            <td>{{ $setting->name }}</td>
                            @endif
                            <td class="text-success">
                                @if ($setting->role=='1') Admin @endif
                                @if ($setting->role=='2') Manager @endif
                                @if ($setting->role=='3') Agent @endif
                            </td>
                            <td>
                                @php $access = explode(',',($setting->access ?? '')); @endphp

                                @if(in_array('1', $access ?? [])) Blogs Management @endif
                                @if(in_array('2', $access ?? [])) | Users Management @endif
                                @if(in_array('3', $access ?? [])) | Products Management @endif
                                @if(in_array('4', $access ?? [])) | Orders Management @endif
                                @if(in_array('5', $access ?? [])) | Support Management @endif
                                @if(in_array('6', $access ?? [])) | Pages Management @endif
                                @if(in_array('7', $access ?? [])) | Settings Management @endif
                            </td>
                            <td>
                                <!-- <a class="notify alert-info" title="View Details"><i class="bx bx-show"></i></a> -->
                                @if(Auth::user()->role == '1' || (in_array('7', $access) && in_array('2', $actions)))
                                <a href="/admin/manage-permission?id={{ $setting->id }}" class="notify alert-primary" title="Edit Details"><i class="bx bx-edit"></i></a>
                                @endif
                                @if(Auth::user()->role == '1' || (in_array('7', $access) && in_array('4', $actions)))
                                <!--<a href="javascript:void(0)" class="notify alert-danger deletesettings" id="{{ $setting->id }}" data-page="psetting" title="Delete"><i class="bx bx-trash"></i></a>-->
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sr. No.</th>
                            @if(Auth::user()->role == '11')
                            <th>Society</th>
                            @endif
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            <div>
        </div>
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