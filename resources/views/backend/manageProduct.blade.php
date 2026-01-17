@extends('backend.layout')
@section('title','Manage Product - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
<style>
    span.select2-selection.select2-selection--multiple {
        padding: 0px;
    }
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        align-items: center;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        margin: 2px 2px;
    }
    ul#select2-color-p6-container {
        height: auto!important;
        overflow: hidden;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border: 1px solid #dddddd!important;
        outline: 0;
        overflow: hidden;
    }
    .was-validated input:invalid,
    .was-validated select:invalid,
    .was-validated textarea:invalid {
        border: 1px solid red !important;
    }
</style>
@endsection

@section('content')
<section class="task__section">
    <div class="text header-text">Management Panel</div>
    <div class="scrum-board-container pb-3">
        <div class="flex justify-content-center">
            <div class="col-md-10 rounded bg-white p-4">
                <h1 class="h4 box-title pb-2">
                    <a @if(($_GET['p'] ?? '') == 'rpa') href="/admin/request-product-addition" @else href="/admin/products" @endif class="text-small mr-3" title="Back">
                        <img src="{{ asset('/assets/backend/icons/back.svg'); }}" class="back-icon" />
                    </a>
                    @if(count($products)=='0') New Product @else Edit Product Details @endif
                </h1><hr>

                <form id="productForm" action="{{ route('manageProduct') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" />

                    {{-- Product Info --}}
                    <div class="card p-3 mb-4 shadow-sm">
                        <h5 class="text-primary mb-3">Product Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="small">SKU*</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="Product_sku" class="form-control" placeholder="Enter SKU" value="{{ $sku ?? '' }}" readonly="" required />
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="small">Category*</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/list-down.svg') }}" class="input-icon" />
                                    <select class="form-control selectpicker" name="Product_category" data-live-search="true" required>
                                        <option value="">Select</option>
                                        @php echo $categoriesOptions; @endphp
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small">Product Name*</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="Product_title" class="form-control" placeholder="Enter Product Name*" value="{{ $products[0]->name ?? '' }}" required />
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small">Synonym Name</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="Product_synonym" class="form-control" placeholder="Enter Synonym Name" value="{{ $products[0]->synonym ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Chemical Info --}}
                    <div class="card p-3 mb-4 shadow-sm">
                        <h5 class="text-success mb-3">Chemical & Technical Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="small">CAS Number*</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="Product_cas" class="form-control" placeholder="Enter CAS Number" value="{{ $products[0]->cas_no ?? '' }}" required />
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small">UoM*</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <select name="Product_uom" class="form-control" required>
                                        <option value="">Select UoM</option>
                                        <option value="mg" {{ old('Product_uom', $products[0]->uom ?? '') == 'mg' ? 'selected' : '' }}>Milligram (mg)</option>
                                        <option value="g" {{ old('Product_uom', $products[0]->uom ?? '') == 'g' ? 'selected' : '' }}>Gram (g)</option>
                                        <option value="kg" {{ old('Product_uom', $products[0]->uom ?? '') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                        <option value="mcg" {{ old('Product_uom', $products[0]->uom ?? '') == 'mcg' ? 'selected' : '' }}>Microgram (mcg)</option>
                                        <option value="ml" {{ old('Product_uom', $products[0]->uom ?? '') == 'ml' ? 'selected' : '' }}>Milliliter (ml)</option>
                                        <option value="l" {{ old('Product_uom', $products[0]->uom ?? '') == 'l' ? 'selected' : '' }}>Liter (l)</option>
                                        <option value="IU" {{ old('Product_uom', $products[0]->uom ?? '') == 'IU' ? 'selected' : '' }}>International Unit (IU)</option>
                                        <option value="pcs" {{ old('Product_uom', $products[0]->uom ?? '') == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                        <option value="pack" {{ old('Product_uom', $products[0]->uom ?? '') == 'pack' ? 'selected' : '' }}>Pack</option>
                                        <option value="box" {{ old('Product_uom', $products[0]->uom ?? '') == 'box' ? 'selected' : '' }}>Box</option>
                                        <option value="bottle" {{ old('Product_uom', $products[0]->uom ?? '') == 'bottle' ? 'selected' : '' }}>Bottle</option>
                                        <option value="can" {{ old('Product_uom', $products[0]->uom ?? '') == 'can' ? 'selected' : '' }}>Can</option>
                                        <option value="jar" {{ old('Product_uom', $products[0]->uom ?? '') == 'jar' ? 'selected' : '' }}>Jar</option>
                                        <option value="tube" {{ old('Product_uom', $products[0]->uom ?? '') == 'tube' ? 'selected' : '' }}>Tube</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small">Related API / Product*</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="Product_rapi" class="form-control" placeholder="Enter Related API / Product" value="{{ $products[0]->related_products ?? '' }}" required />
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small">Purity (%)</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="Product_purity" class="form-control" placeholder="Enter Purity (%)" value="{{ $products[0]->purity ?? '' }}" />
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small">Potency (%)</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="Product_potency" class="form-control" placeholder="Enter Potency (%)" value="{{ $products[0]->potency ?? '' }}" />
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small">Product Type*</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/list-down.svg') }}" class="input-icon" />
                                    <select class="form-control selectpicker" name="impurity_type" data-live-search="true" required>
                                        <option value="">Select</option>
                                        <option value="process" {{ old('impurity_type', $products[0]->impurity_type ?? '') == 'process' ? 'selected' : '' }}>Process</option>
                                        <option value="genotoxic" {{ old('impurity_type', $products[0]->impurity_type ?? '') == 'genotoxic' ? 'selected' : '' }}>Genotoxic</option>
                                        <option value="unknown" {{ old('impurity_type', $products[0]->impurity_type ?? '') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                                        <option value="other" {{ old('impurity_type', $products[0]->impurity_type ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small">Molecular Name</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="molecular_name" class="form-control" placeholder="Enter Molecular Name" value="{{ $products[0]->molecular_name ?? '' }}" />
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small">Molecular Weight</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="molecular_weight" class="form-control" placeholder="Enter Molecular Weight" value="{{ $products[0]->molecular_weight ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Images --}}
                    <div class="card p-3 mb-4 shadow-sm">
                        <h5 class="text-warning mb-3">Product Images</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="small">Product Image 1*</label>
                                <div class="input-group">
                                    @if(!empty($products[0]->img))
                                        <img src="{{ asset('/public/assets/frontend/img/products/'.$products[0]->img) }}" class="input-img" />
                                    @else
                                        <img src="{{ asset('/assets/backend/icons/image-plus.svg') }}" class="input-icon" />
                                    @endif
                                    <input type="file" name="Product_img1" class="form-control" @if(empty($products[0]->img)) required @endif />
                                </div>
                            </div>
                            @for($i=2; $i<=5; $i++)
                            <div class="form-group col-md-6">
                                <label class="small">Product Image {{ $i }}</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/image-plus.svg') }}" class="input-icon" />
                                    <input type="file" name="Product_img{{ $i }}" class="form-control" />
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    {{-- Descriptions --}}
                    <div class="card p-3 mb-4 shadow-sm">
                        <h5 class="text-info mb-3">Descriptions & Tags</h5>
                        <div class="form-group">
                            <label class="small">Description</label>
                            <textarea name="Product_des" class="form-control" id="summernote">{{ $products[0]->des ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="small">Additional Information</label>
                            <textarea name="Product_ainfo" class="form-control" id="summernote1">{{ $products[0]->ainfo ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="small">Short Description</label>
                            <textarea name="Product_sdes" class="form-control">{{ $products[0]->sdes ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="small">Tags (Use ',' for Separator)</label>
                            <textarea name="Product_tags" class="form-control">{{ $products[0]->tags ?? '' }}</textarea>
                        </div>
                    </div>

                    {{-- Settings & Attachments --}}
                    <div class="card p-3 mb-4 shadow-sm">
                        <h5 class="text-dark mb-3">Product Settings & Attachments</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="small">HSN Code</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="Product_hsn" class="form-control" value="{{ $products[0]->hsn_code ?? '' }}" />
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small">GST (%)</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/edit.svg') }}" class="input-icon" />
                                    <input type="text" name="Product_gst" class="form-control" value="{{ $products[0]->gst ?? '' }}" />
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="small">Featured</label>
                                <select class="form-control" name="Product_featured">
                                    <option value="0" {{ isset($products[0]) && $products[0]->featured == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ isset($products[0]) && $products[0]->featured == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="small">New Addition</label>
                                <select class="form-control" name="Product_new">
                                    <option value="0" {{ isset($products[0]) && $products[0]->new == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ isset($products[0]) && $products[0]->new == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="small">Active</label>
                                <select class="form-control" name="Product_active">
                                    <option value="0" {{ isset($products[0]) && $products[0]->status == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ isset($products[0]) && $products[0]->status == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="small">Attach File(s) (Excel, PDF, Doc)</label>
                                <div class="input-group">
                                    <img src="{{ asset('/assets/backend/icons/file.svg') }}" class="input-icon" />
                                    <input type="file" name="Product_files[]" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx" multiple />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-light border">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footlink')
<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#summernote').summernote({ height: 300 });
        $('#summernote1').summernote({ height: 300 });
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('productForm');
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>
@endsection