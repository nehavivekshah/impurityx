<style>
    @media (max-width: 768px) {
        .w-45 input {
            width: 50%;
        }
    }
</style>
<div class="dashboard-area box--shadow mt-4 mb-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Left Column -->
            <form action="{{ url('/seller/my-account/communication-buyers') }}" method="POST" class="col-md-5 border rounded @if(!request()->has('id')) p-4 @else p-0 @endif">
                @csrf
                @if(request()->has('id'))
                <div class="card p-0 border-0">
                    <!-- Header -->
                    <div class="card-header bg-light text-dark">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <!-- Center: Communication Info -->
                            <div class="text-left flex-grow-1">
                                <h5 class="mb-1" style="display: inline-flex ; align-items: center; gap: 10px;">
                                    #{{ $getCom?->communication_id }}
                                    <span class="badge {{ $getCom->state == 0 ? 'bg-success' : 'bg-danger' }}" style="font-size: 13px; padding: 6px 10px; height: 20px; font-weight: 400;display: inline-flex ; align-items: center;">
                                        {{ $getCom->state == 0 ? 'Open' : 'Closed' }}
                                    </span>
                                </h5>
                                <small class="text-secondary d-block">
                                    <strong>Order Id:</strong> {{ $getCom?->order_no ?? 'N/A' }}
                                    <span class="mx-1">|</span>
                                    <strong>CAS No.:</strong> {{ $getCom?->cas_no ?? 'N/A' }}
                                </small>
                            </div>
                            <!-- Right: Status Badge -->
                            <div>
                                <a href="{{ url('/seller/my-account/communication-buyers') }}" class="btn btn-sm btn-dark">
                                    <i class="bx bx-reply"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                    @php $type = explode("-",($getCom?->communication_id ?? '')); @endphp
                    <!-- Chat Body -->
                    <div class="card-body" style="background-color: #f4f6f9; max-height: 450px; overflow-y: auto;">
                        <!-- Buyer Message -->
                        <div class="d-flex align-items-start mb-4 animate__animated animate__fadeIn">
                            <div class="me-2">
                                <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                    @if($type[0] == 'CBS')
                                    <i class="bx bx-user"></i>
                                    @else
                                    <i class="bx bx-store"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="p-3 rounded-3 shadow-sm" style="background: white; max-width: 70%;">
                                @if($type[0] == 'CBS')
                                <strong class="text-primary">{{ $getCom?->impurity_name ?? 'Me' }}</strong>
                                @else
                                <strong class="text-primary">Seller - </strong>
                                @endif
                                <p class="mb-1">{{ $getCom?->message }}</p>
                                <small class="text-muted">
                                    <i class="bx bx-time"></i> {{ $getCom?->created_at?->format('d M Y, h:i A') }}
                                </small>
                            </div>
                        </div>
                        <!-- Seller Reply -->
                        @if(!empty($getCom?->reply))
                        <div class="d-flex align-items-start justify-content-end mb-4 animate__animated animate__fadeIn animate__delay-1s">
                            <div class="p-3 rounded-3 shadow-sm text-white" style="background: linear-gradient(135deg, #28a745, #218838); max-width: 70%;">
                                @if($type[0] != 'CBS')
                                <strong>{{ $getCom?->impurity_name ?? 'Me' }}</strong>
                                @else
                                <strong>Seller</strong>
                                @endif
                                <p class="mb-1">{{ $getCom->reply }}</p>
                                <small class="text-light">
                                    <i class="bx bx-time"></i> {{ $getCom?->updated_at?->format('d M Y, h:i A') }}
                                </small>
                            </div>
                            <div class="ms-2">
                                <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                    @if($type[0] != 'CBS')
                                    <i class="bx bx-user"></i>
                                    @else
                                    <i class="bx bx-store"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if(!empty($getCom->reply))
                    <!-- Footer -->
                    <div class="card-footer bg-light text-center small text-muted">
                        Last updated: {{ $getCom?->updated_at?->format('d M Y, h:i A') }}
                    </div>
                    @endif
                </div>
                @endif
                @if(!request()->has('id') || empty($getCom->reply) && ($type[0] == 'CBS'))
                @if(empty($getCom->communication_id))
                <!-- Communication ID -->
                <div class="mb-3">
                    <label for="communicationId" class="fw-bold">Communication ID:</label>
                    <input type="text" class="form-control" name="communicationId"
                        value="{{ $communicationId ?? 'AUTO-GEN' }}" readonly>
                </div>
                <!-- Order No -->
                <div class="mb-3">
                    <label for="order_no" class="fw-bold">Order No #:</label>
                    <input type="text" class="form-control" name="orderNo" id="orderNo" />
                </div>
                <!-- CAS No -->
                <div class="mb-3">
                    <label for="cas_no" class="fw-bold">CAS No:</label>
                    <input type="text" class="form-control" name="casNo" id="casNo" readonly>
                </div>
                <!-- Impurity Name -->
                <div class="mb-3">
                    <label for="impurity_name" class="fw-bold">Impurity Name:</label>
                    <input type="text" class="form-control" name="impurityName" id="impurityName" readonly>
                </div>
                @endif
                <!-- Message Box -->
                <div class="mb-3">
                    @if(empty($getCom->reply) && !empty($getCom->message))
                    <label for="message" class="fw-bold">Seller Reply:</label>
                    <input type="hidden" class="form-control" name="orderNo" id="orderNo" value="{{ $getCom?->order_no ?? '' }}" />
                    <input type="hidden" name="replyId" value="{{ $_GET['id'] ?? '' }}" />
                    @else
                    <label for="message" class="fw-bold">Message:</label>
                    @endif
                    <textarea class="form-control" name="message" id="message" rows="7"
                        placeholder="Type your message here..." required></textarea>
                </div>
                <!-- Action Buttons -->
                <div class="text-end">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success">Send</button>
                </div>
                @endif
            </form>
            <!-- Right Column: Table -->
            <div class="col-md-7">
                <div class="col-md-12 px-0 px-md-3 mb-3">
                    <form method="POST" action="/seller/my-account/communication-buyers/export" class="row bg-light border py-3">
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col">
                                    <h4>Export Data</h4>
                                </div>
                                <div class="col" style="text-align:right;">
                                    <button type="submit" class="btn btn-success">Export</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-7">
                            <label>Date Range</label>
                            <div class="d-flex w-45">
                                <input type="date" name="from_date" class="form-control me-2" required>
                                <input type="date" name="to_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3 col-md-5">
                            <label>Status</label>
                            <select name="seller_status" class="form-control">
                                <option value="all">All</option>
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered table-striped table-hover rounded" id="example" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Communication ID</th>
                            <th>Order No</th>
                            <th>CAS No</th>
                            <th>Impurity Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sr = 1; @endphp
                        @forelse($communications as $k=>$com)
                        <tr>
                            <td>{!! $sr; $sr++; !!}</td>
                            <td>{{ $com->communication_id }}</td>
                            <td>{{ $com->order_no }}</td>
                            <td>{{ $com->cas_no }}</td>
                            <td>{{ $com->impurity_name }}</td>
                            <td>
                                <span class="badge {{ $com->status == 'open' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $com->status == 'open' ? 'Open' : 'Closed' }}
                                </span>
                            </td>
                            <td>{{ $com->created_at }}</td>
                            <td class="text-center">
                                <a href="{{ url('/seller/my-account/communication-buyers?id=' . $com->id) }}"
                                    class="btn btn-sm btn-info" title="View Details">
                                    <i class="bx bx-show"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No communications found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('footlink')
<script>
    new DataTable('#example');
</script>
@endsection