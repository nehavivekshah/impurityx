@extends('backend.layout')
@section('title','Reviews - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- Link Styles -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection
@section('content')
<section class="task__section">
    <div class="text header-text">Management Panel <span>Total Reviews: <b>{{ count($reviews) }}</b></span></div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>Reviews</h1>
            <a href="/admin/manage-review" class="btn btn-primary">Add New</a>
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
                            <th>Photo</th>
                            <th>Username</th>
                            <th>Review</th>
                            <th>Created On</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-content">
                        @foreach($reviews as $key=>$review)
                        <tr>
                            <!--branch	title	name	imgs	rating	content	status-->
                            <td>{{ $key+1 }}</td>
                            @if(Auth::user()->role=='0')
                            <td>{{ $review->name }}</td>
                            @endif
                            <td><img src="{{ asset('/assets/images/testimonial/'.$review->imgs) }}" class="input-img rounded" /></td>
                            <td>{{ $review->name.' - '.$review->title }}</td>
                            <td><span class="text-success font-weight-bold">{{ $review->rating }} Stars</span><br />{{ $review->content }}</td>
                            <td>{{ date_format(date_create($review->created_at), 'd M, Y') }}</td>
                            <td>
                                @if($review->status=='1')
                                <a href="javascript:void(0)" class="notify alert-success status" id="{{ $review->id }}" data-status="2" data-page="reviewStatus">Active</a>
                                @else
                                <a href="javascript:void(0)" class="notify alert-danger status" id="{{ $review->id }}" data-status="1" data-page="reviewStatus">Deactive</a>
                                @endif
                            </td>
                            <td style="width:150px;">
                                <a href="/admin/manage-review?id={{ $review->id }}" class="notify-btn alert-primary" title="Edit Details"><i class="bx bx-edit"></i></a>
                                <a href="javascript:void(0)"  class="notify-btn alert-danger delete" id="{{ $review->id }}" data-page="delreviewStatus" title="Delete"><i class="bx bx-trash"></i></a>
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
                            <th>Photo</th>
                            <th>Username</th>
                            <th>Review</th>
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