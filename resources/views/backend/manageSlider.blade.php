@extends('backend.layout')
@section('title','Manage Slider - Impurity X')
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
                    <a href="/admin/sliders" class="text-small mr-3" title="Back"><img src="{{ asset('/assets/backend/icons/back.svg'); }}" class="back-icon" /></a>
                    @if(count($slider)=='0') 
                        New Slider 
                    @else
                        Edit Slider Details
                    @endif
                </h1><hr>
                <form action="{{ route('manageSlider') }}" method="POST" class="card-body pb-3 px-3" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="small">Title*</label><br>
                        <div class="input-group">
                            <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                            <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" />
                            <input type="text" name="gallery_title" class="form-control" placeholder="Enter Title*" value="{{ $slider[0]->title ?? '' }}" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small">SubTitle</label><br>
                        <textarea type="text" name="gallery_subtitle" class="form-control" placeholder="Enter SubTitle">{{ $slider[0]->subtitle ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="small">Banner Link</label><br>
                        <div class="input-group">
                            <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                            <input type="url" name="gallery_link" class="form-control" placeholder="Enter Link Url" value="{{ $slider[0]->link ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small">Button Text</label><br>
                        <div class="input-group">
                            <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                            <input type="text" name="gallery_btntext" class="form-control" placeholder="Enter Button Text" value="{{ $slider[0]->btntext ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small">Image*</label><br>
                        <div class="input-group">
                            @if(empty($slider[0]->imgs))
                            <img src="{{ asset('/assets/backend/icons/image-plus.svg'); }}" class="input-icon" />
                            @else
                            <img src="/public/assets/frontend/img/sliders/{{ $slider[0]->imgs }}" class="input-icon input-imgs" />
                            @endif
                            <input type="file" name="gallery_imgs" class="form-control" placeholder="Choose Image*" value="{{ $slider[0]->imgs ?? '' }}" @if(empty($slider[0]->imgs)) required @endif />
                        </div>
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
<!-- Scripts -->
<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
@endsection