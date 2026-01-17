@extends('backend.layout')
@section('title','Manage Post Category - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<!-- Link Styles -->
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection
@section('content')
<section class="task__section">
    <div class="text header-text">Management Panel</div>
    <div class="scrum-board-container">
        <div class="flex justify-content-center">
            <div class="col-md-4 rounded bg-white">
                <h1 class="h3 box-title pb-2">
                    <a href="/admin/post-categories" class="text-small mr-3" title="Back"><img src="{{ asset('/assets/backend/icons/back.svg'); }}" class="back-icon" /></a>
                    @if(count($postCategory)=='0') 
                        New Category
                    @else
                        Edit Category Details
                    @endif
                </h1><hr>
                <form action="{{ route('managePostCategory') }}" method="POST" class="card-body pb-3 px-3" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="small">Title*</label><br>
                        <div class="input-group">
                            <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                            <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" />
                            <input type="text" name="postCategory_title" class="form-control" placeholder="Enter Title*" value="{{ $postCategory[0]->title ?? '' }}" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small">Image*</label><br>
                        <div class="input-group">
                            @if(!empty($postCategory[0]->imgs))
                            <img src="{{ asset('/public/assets/frontend/img/postCategory/'.$postCategory[0]->imgs) }}" class="img-icon" />
                            @else
                            <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                            @endif
                            <input type="file" name="postCategory_file" class="form-control" @if(empty($postCategory[0]->imgs)) required @endif />
                        </div>
                    </div>
                    <div class="form-group text-center mt-3 mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-light border">Reset</button>
                    </div>
                </form>
            <div>
        </div>
    </div>
</section>
@endsection
@section('footlink')
    
<!-- Scripts -->
<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
@endsection