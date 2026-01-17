<form action="/my-account/request-order" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="dashboard-area box--shadow my-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-5 border rounded @if(!request()->has('id')) p-4 @else p-0 @endif">

                    @if(request()->has('id') && $getRnpo)
                        <div class="card p-0 border-0">
                            <!-- Header -->
                            <div class="card-header bg-light text-dark">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="text-left flex-grow-1">
                                        <h5 class="mb-1 d-flex align-items-center gap-2">
                                            #{{ $getRnpo->request_id }}
                                            <!--<span class="badge {{ $getRnpo->status == 0 ? 'bg-warning' : 'bg-success' }}">
                                                {{ $getRnpo->status == 0 ? 'Inprocess' : 'Live' }}
                                            </span>-->
                                            <span class="badge 
                                                {{ $getRnpo->status == 0 ? 'bg-warning text-dark' : ($getRnpo->status == 1 ? 'bg-success' : 'bg-danger') }}">
                                                {{ $getRnpo->status == 0 ? 'Inprocess' : ($getRnpo->status == 1 ? 'Live' : 'Cancelled') }}
                                            </span>
                                        </h5>
                                    </div>
                                    <a href="{{ url('/my-account/request-order') }}" class="btn btn-sm btn-dark">
                                        <i class="bx bx-reply"></i> Back
                                    </a>
                                </div>
                            </div>
                    
                            <!-- Body -->
                            <div class="card-body" style="background-color: #f4f6f9; max-height: 450px; overflow-y: auto;">
                                @if(!empty($getRnpo->name))
                                    <p><strong>Product Name:</strong> {{ $getRnpo->name }}</p>
                                @endif
                                @if(!empty($getRnpo->cas_no))
                                    <p><strong>CAS Number:</strong> {{ $getRnpo->cas_no }}</p>
                                @endif
                                @if(!empty($getRnpo->synonym))
                                    <p><strong>Synonym:</strong> {{ $getRnpo->synonym }}</p>
                                @endif
                                @if(!empty($getRnpo->impurity_type))
                                    <p><strong>Type:</strong> {{ ucfirst($getRnpo->impurity_type) }}</p>
                                @endif
                                @if(!empty($getRnpo->purity))
                                    <p><strong>Purity:</strong> {{ $getRnpo->purity }}%</p>
                                @endif
                                @if(!empty($getRnpo->potency))
                                    <p><strong>Potency:</strong> {{ $getRnpo->potency }}</p>
                                @endif
                                @if(!empty($getRnpo->des))
                                    <p><strong>Description:</strong> {{ $getRnpo->des }}</p>
                                @endif
                    
                                @if(!empty($getRnpo->quantity))
                                    <p><strong>Quantity:</strong> {{ $getRnpo->quantity }} {{ $getRnpo->uom ?? '' }}</p>
                                @endif
                                @if(!empty($getRnpo->delivery_date))
                                    <p><strong>Delivery Date:</strong> {{ \Carbon\Carbon::parse($getRnpo->delivery_date)->format('d M Y') }}</p>
                                @endif
                                @if(!empty($getRnpo->delivery_location))
                                    <p><strong>Delivery Location:</strong> {{ $getRnpo->delivery_location }}</p>
                                @endif
                                @if(!empty($getRnpo->specific_requirements))
                                    <p><strong>Specific Requirements:</strong> {{ $getRnpo->specific_requirements }}</p>
                                @endif
                                @if(!empty($getRnpo->attachments))
                                    <p><strong>Attachments:</strong></p>
                                    <ul>
                                        @foreach(json_decode($getRnpo->attachments, true) as $file)
                                            <li>
                                                <a href="{{ asset('/public/assets/frontend/img/products/files/'.$file) }}" class="btn btn-sm btn-dark" target="_blank">View File</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                    
                            <!-- Footer -->
                            <div class="card-footer bg-light text-center small text-muted">
                                Last updated: {{ $getRnpo->updated_at ? \Carbon\Carbon::parse($getRnpo->updated_at)->format('d M Y, h:i A') : 'N/A' }}
                            </div>
                        </div>
                    @endif

                    @if(!request()->has('id'))
                        <div class="row gy-3">
                            
                            <div class="col-12">
                                <h6 class="fw-bold border-bottom pb-1">Request Details</h6>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="requestID" class="form-label-small">Request ID *</label>
                                <input type="text" placeholder="Request ID" id="requestID" value="{{ $reqId ?? '' }}" name="requestID" required class="form-control">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="casNumber" class="form-label-small">CAS Number *</label>
                                <input type="text" placeholder="(Only numerics and hyphens allowed)" required id="casNumber" name="casNumber" class="form-control">
                            </div>

                            <div class="col-12 mt-4">
                                <h6 class="fw-bold border-bottom pb-1">Product Information</h6>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="impurityName" class="form-label-small">Product Name *</label>
                                <input type="text" placeholder="Product Name" required id="impurityName" name="impurityName" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="synonynName" class="form-label-small">Synonym Name *</label>
                                <input type="text" placeholder="Synonym Name" required id="synonynName" name="synonynName" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="impuritytype" class="form-label-small">Product Type *</label>
                                <select class="form-control selectpicker" name="impuritytype" id="impuritytype" data-live-search="true" required>
                                    <option value="">Select</option>
                                    <option value="process">Process</option>
                                    <option value="genotoxic">Genotoxic</option>
                                    <option value="unknown">Unknown</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="impurityDescription" class="form-label-small">Product Description</label>
                                <textarea class="form-control" placeholder="Product Description" id="impurityDescription" name="impurityDescription" style="height: 80px;"></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <h6 class="fw-bold border-bottom pb-1">Specifications</h6>
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label-small">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity">
                            </div>
                            <div class="col-md-6">
                                <label for="uom" class="form-label-small">UOM</label>
                                <select name="uom" id="uom" class="form-control" required>
                                    <option value="">Select UoM</option>
                                    <option value="mg">Milligram (mg)</option>
                                    <option value="g">Gram (g)</option>
                                    <option value="kg">Kilogram (kg)</option>
                                    <option value="mcg">Microgram (mcg)</option>
                                    <option value="ml">Milliliter (ml)</option>
                                    <option value="l">Liter (l)</option>
                                    <option value="IU">International Unit (IU)</option>
                                    <option value="pcs">Pieces (pcs)</option>
                                    <option value="pack">Pack</option>
                                    <option value="box">Box</option>
                                    <option value="bottle">Bottle</option>
                                    <option value="can">Can</option>
                                    <option value="jar">Jar</option>
                                    <option value="tube">Tube</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="purity" class="form-label-small">Purity %</label>
                                <input type="number" class="form-control" id="purity" name="purity" placeholder="Purity" step="0.01">
                            </div>
                            <div class="col-md-6">
                                <label for="potency" class="form-label-small">Potency</label>
                                <input type="number" class="form-control" id="potency" name="potency" placeholder="Potency" step="0.01">
                            </div>
                            <div class="col-md-6">
                                <label for="deliveryTime" class="form-label-small">Delivery Time (days)</label>
                                <input type="number" class="form-control" id="deliveryTime" name="deliveryTime" placeholder="Delivery Time">
                            </div>
                            <div class="col-md-6">
                                <label for="deliveryPlace" class="form-label-small">Delivery Place</label>
                                <input type="text" class="form-control" id="deliveryPlace" name="deliveryPlace" placeholder="Delivery Place">
                            </div>
                            <div class="col-md-6">
                                <label for="certification" class="form-label-small">Required Certification</label>
                                <input type="text" class="form-control" id="certification" name="certification" placeholder="Required Certification">
                            </div>
                            <div class="col-md-12">
                                <label for="supportingDocuments" class="form-label-small">Other Supporting Documents</label>
                                <textarea class="form-control" placeholder="Other Supporting Documents" id="supportingDocuments" name="supportingDocuments" style="height: 80px;"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="small">Attach File(s) (Excel, PDF, Doc)</label>
                                <input type="file" name="Product_files[]" class="form-control" accept="jpg,png,jpeg,.pdf,.doc,.docx,.xls,.xlsx" multiple />
                            </div>

                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary account-btn form-control">SUBMIT</button>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-7">
                    <table class="table table-bordered table-striped table-hover rounded" id="example" style="font-size: 14px;">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Request ID</th>
                                <th>Product Details</th>
                                <th>Attachments</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $sr = 1; @endphp
                            @forelse($rnpo as $k=>$com)
                                <tr>
                                    <td>{!! $sr; $sr++ !!}</td>
                                    <td>{{ $com->request_id }}</td>
                                    <td>{{ $com->name ?? '' }}<br>{{ $com->sku ?? '' }}</td>
                                    <td>Qty: {{ $com->quantity ?? '' }}{{ $com->uom ?? '' }}<br>EDD: {!! date_format(date_create($com->delivery_date ?? null), 'd M, Y') !!}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $com->status == 0 ? 'bg-warning text-dark' : ($com->status == 1 ? 'bg-success' : 'bg-danger') }}">
                                            {{ $com->status == 0 ? 'Inprocess' : ($com->status == 1 ? 'Live' : 'Cancelled') }}
                                        </span>
                                    </td>
                                    <td>{{ $com->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/my-account/request-order?id=' . $com->id) }}" class="btn btn-sm btn-info" title="View Details">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No Product order request found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .bg-gradient-success { background: linear-gradient(135deg, #28a745, #218838); color: #fff; }
    .bg-gradient-danger { background: linear-gradient(135deg, #dc3545, #b02a37); color: #fff; }
    .table-hover tbody tr:hover { background-color: #f8f9fa; }
</style>

@section('footlink')

<script>
    
    new DataTable('#example');
    
</script>

<script src="https://cdn.tiny.cloud/1/lm91u59zbi9ehgp0ku57df4j1asfy1web6ap6b6h74jz6txl/tinymce/6/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: 'textarea',
  });
</script>

@endsection
