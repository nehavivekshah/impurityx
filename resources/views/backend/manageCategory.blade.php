@extends('backend.layout')
@section('title','Manage Category - Impurity X')
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
                    <a href="/admin/categories" class="text-small mr-3" title="Back"><img src="{{ asset('/assets/backend/icons/back.svg'); }}" class="back-icon" /></a>
                    @if(count($categories)=='0') 
                        New Category 
                    @else
                        Edit Category Details
                    @endif
                </h1><hr>
                <form action="{{ route('manageCategory') }}" method="POST" class="card-body pb-3 px-3" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="small">Title*</label><br>
                        <div class="input-group mb-3">
                            <img src="{{ asset('/assets/backend/icons/edit.svg'); }}" class="input-icon" />
                            <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" />
                            <input type="text" name="cate_title" class="form-control" placeholder="Enter Title*" value="{{ $categories[0]->title ?? '' }}" required />
                        </div>
                    </div>
                    <div class="form-group cgl">
                        <label class="small">Parent</label><br>
                        <div class="input-group mb-3">
                            <img src="{{ asset('/assets/backend/icons/list-down.svg'); }}" class="input-icon" />
                            <select class="form-control" id="cate_parent" name="cate_parent">
                                <option value="">Default</option>
                                @foreach($categoryList as $item)
                                @if($item->id != ($categories[0]->id ?? ''))
                                <option value="{{ $item->id }}" @if($item->id == ($categories[0]->parent ?? '')) {{ "selected" }} @endif>{{ $item->title }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="small">Icon</label><br>
                        <div class="input-group mb-3">
                            @if(!empty($categories[0]->icon))
                            <img src="{{ asset('/public/assets/frontend/img/category/icons/'.$categories[0]->icon); }}" class="input-img" />
                            @else
                            <img src="{{ asset('/assets/backend/icons/image-plus.svg'); }}" class="input-icon" />
                            @endif
                            <input type="file" name="cate_icon" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="small">Image</label><br>
                        <div class="input-group mb-3">
                            @if(!empty($categories[0]->img))
                            <img src="{{ asset('/public/assets/frontend/img/category/'.$categories[0]->img); }}" class="input-img" />
                            @else
                            <img src="{{ asset('/assets/backend/icons/image-plus.svg'); }}" class="input-icon" />
                            @endif
                            <input type="file" name="cate_img" class="form-control" />
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
<script>
    $(document).ready(function(){
        $('#cate_division').change(function(){
            if($(this).val() == '1'){
                $("#discount").css("display","none");
                $(".cgl").css("display","none");
                $(".ccl").css("display","block");
                $("#catec_parent").attr("name","cate_parent");
                $("#cate_parent").removeAttr("name","cate_parent");
            }else{
                $("#discount").css("display","block");
                $(".ccl").css("display","none");
                $(".cgl").css("display","block");
                $("#cate_parent").attr("name","cate_parent");
                $("#catec_parent").removeAttr("name","cate_parent");
            }
        });
    });
</script>
@endsection