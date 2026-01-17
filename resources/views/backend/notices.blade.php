@extends('backend.layout')
@section('title','Notices - Impurity X')
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
            <h1>Notices</h1>
            @if(Auth::user()->role == '1' || (in_array('5', $access) && in_array('1', $actions)))
            <a href="/admin/manage-notice" class="btn btn-primary">Create New</a>
            @endif
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="noticesTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Notice ID</th>
                            <th>Message</th>
                            <th>Type</th>
                            <!--<th>Status</th>-->
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notices as $notice)
                            <tr>
                                <td>{{ $notice->id }}</td>
                                <td>{{ $notice->notice_id }}</td>
                                <td>{{ strlen($notice->message) > 150 ? substr($notice->message, 0, 150) . '...' : $notice->message }}</td>
                                <td>
                                    <span class="badge {{ $notice->type == 'buyers' ? 'bg-success' : 'bg-primary' }} d-flex justify-content-center align-items-center">
                                        {{ $notice->type == 'buyers' ? 'Buyers' : 'Sellers' }}
                                    </span>

                                </td>
                                <!--<td>-->
                                <!--    <span class="badge {{ $notice->status == 'active' ? 'bg-success' : 'bg-danger' }}">-->
                                <!--        {{ $notice->status == 'active' ? 'Active' : 'Inactive' }}-->
                                <!--    </span>-->
                                <!--</td>-->
                                <td>{!! date_format(date_create($notice->created_at ?? null),'d M, Y') !!}</td>
                                <td class="text-center">
                                    @if(Auth::user()->role == '1' || (in_array('5', $access) && in_array('0', $actions)))
                                    <a href="javascript:void(0)" class="notify-btn alert-info view" id="{{ $notice->id }}" data-page="noticeview" title="View Details">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    @endif
                                    <!--<a href="javascript:void(0)" class="notify-btn alert-primary view" id="{{ $notice->id }}" data-page="noticeedit" title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </a>-->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No notices found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Notice ID</th>
                            <th>Message</th>
                            <th>Type</th>
                            <!--<th>Status</th>-->
                            <th>Created At</th>
                            <th class="text-center">Action</th>
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
            <div class="poptitle">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close"></span></div>
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
    new DataTable('#noticesTable');
</script>
@endsection