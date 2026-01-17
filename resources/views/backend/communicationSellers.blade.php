@extends('backend.layout')
@section('title','Communication Sellers - Impurity X')
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
            <h1>Communication Sellers</h1>
            @if(Auth::user()->role == '1' || (in_array('5', $access) && in_array('1', $actions)))
            <div class="">
                <a href="/admin/manage-communication-sellers?p=buyer" class="btn btn-primary">New Comm with Seller</a>
                <a href="/admin/manage-communication-sellers?p=seller" class="btn btn-success bg-success text-white">New Comm with Buyer</a>
            </div>
            @endif
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Communication ID</th>
                            <th>Buyer Details</th>
                            <th>Seller Details</th>
                            <th>Order No</th>
                            <th>CAS No</th>
                            <th>Impurity Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($communications as $k=>$com)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $com->communication_id }}</td>
                                <td>{{ $com->first_name.' '.$com->last_name }}<br><span class="text-secondary">{{ $com->email ?? '' }}</span></td>
                                <td>{{ $com->seller_fname.' '.$com->seller_lname }}<br><span class="text-secondary">{{ $com->seller_email ?? '' }}</span></td>
                                <td>{{ $com->order_no }}</td>
                                <td>{{ $com->cas_no }}</td>
                                <td>{{ $com->impurity_name }}</td>
                                <td>
                                    <span class="badge {{ $com->status == 'open' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $com->status == 'open' ? 'Open' : 'Closed' }}
                                    </span>
                                </td>
                                <td>
                                    @php $ty = explode("-",$com->communication_id); @endphp
                                    <span class="badge {{ $ty[0] == 'CBS' ? 'bg-warning text-dark' : 'bg-primary' }}">
                                        {{ $ty[0] == 'CBS' ? 'Buyer' : 'Seller' }}
                                    </span>
                                </td>
                                <td>{!! date_format(date_create($com->created_at ?? null),'d M, Y') !!}</td>
                                <td class="text-center">
                                    @if(Auth::user()->role == '1' || (in_array('5', $access) && in_array('0', $actions)))
                                    <a href="javascript:void(0)"  class="notify-btn alert-info view" id="{{ $com->id }}" data-page="cseller" title="View Details"><i class="bx bx-show"></i></a>
                                    @endif
                                    @if(Auth::user()->role == '1' || (in_array('5', $access) && in_array('2', $actions)))
                                    <a href="javascript:void(0)"  class="notify-btn alert-primary view" id="{{ $com->id }}" data-page="csAreply" title="Reply"><i class="bx bx-chat"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No communications found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Communication ID</th>
                            <th>Order No</th>
                            <th>CAS No</th>
                            <th>Impurity Name</th>
                            <th>Status</th>
                            <th>Type</th>
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