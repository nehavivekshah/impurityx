@extends('backend.layout')
@section('title','Manage Page - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />
<!-- Link Styles -->
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection
@section('content')
<section class="task__section">
    <div class="text header-text">Management Panel</div>
    <div class="scrum-board-container">
        <div class="flex justify-content-center">
            <div class="col-md-12 rounded bg-white">
                <h1 class="h3 box-title pb-2">
                    <a href="/pages" class="text-small mr-3" title="Back"><img src="{{ asset('/assets/backend/icons/back.svg'); }}" class="back-icon" /></a>
                    @if(count($pages)=='0') 
                        New Page 
                    @else
                        Edit Page Details
                    @endif
                </h1><hr>
                <form action="{{ route('managePage') }}" method="POST" class="card-body pb-3 px-3" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="small">Title*</label><br>
                        <div class="input-group">
                            <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                            <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" />
                            <input type="text" name="page_title" class="form-control" placeholder="Enter Title*" value="{{ $pages[0]->title ?? '' }}" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small">Content*</label><br>
                        <textarea name="page_des" class="form-control" id="summernote" placeholder="Enter Title*" required>{{ $pages[0]->content ?? '' }}</textarea>
                    </div>
                    <div class="form-group text-center mt-3 mb-0">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
    
<script type="text/javascript">
    $(document).ready(function () {
        $('#summernote').summernote({
            height: 300,
        });
    });
</script>
    
<!-- Scripts -->
<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
@endsection