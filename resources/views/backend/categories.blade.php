@extends('backend.layout')
@section('title','Categories - Impurity X')
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
            <h1>Category</h1>
            <div>
                @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('3', $actions)))
                <a href="/admin/categories/export" class="btn btn-success bg-success text-white me-2">Export</a>
                @endif
                @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('1', $actions)))
                <a href="/admin/manage-category" class="btn btn-primary">Add New</a>
                @endif
            </div>
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="50px">Sr No.</th>
                            <th>Icon</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-content">
                        
                        @php echo $categoryLists; @endphp
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sr No.</th>
                            <th>Icon</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created On</th>
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