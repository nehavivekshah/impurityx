@extends('backend.layout')
@section('title','Manage Review - Impurity X')
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
                    <a href="/reviews" class="text-small mr-3" title="Back"><img src="{{ asset('/assets/backend/icons/back.svg'); }}" class="back-icon" /></a>
                    @if(count($reviews)=='0') 
                        New Review 
                    @else
                        Edit Review Details
                    @endif
                </h1><hr>
                <form action="{{ route('manageReview') }}" method="POST" class="card-body pb-3 px-3" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="small">Name*</label><br>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                                    <input type="text" name="review_name" class="form-control" placeholder="Enter Name*" value="{{ $reviews[0]->name ?? '' }}" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small">Designation*</label><br>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                                    <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" />
                                    <input type="text" name="review_title" class="form-control" placeholder="Enter Designation*" value="{{ $reviews[0]->title ?? '' }}" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small">Photo*</label><br>
                                <div class="input-group">
                                    @if(!empty($reviews[0]->imgs))
                                    <img src="{{ asset('/assets/images/testimonial/'.$reviews[0]->imgs) }}" class="img-icon" />
                                    @else
                                    <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                                    @endif
                                    <input type="file" name="review_file" class="form-control" @if(empty($reviews[0]->imgs)) required @endif />
                                </div>
                            </div>
                                
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="small">Star*</label><br>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                                    <input type="number" name="review_star" class="form-control" placeholder="Enter Star*" value="{{ $reviews[0]->rating ?? '' }}" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small">Content*</label><br>
                                <textarea name="review_content" class="form-control" rows="5" placeholder="Write your review*" required>{{ $reviews[0]->content ?? '' }}</textarea>
                            </div>
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