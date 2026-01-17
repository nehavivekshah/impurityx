@extends('backend.layout')
@section('title','Manage Permissions - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- Link Styles -->
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection
@section('content')
<section class="task__section">
    <div class="text header-text">{{ session('sc') }}</div>
    <div class="scrum-board-container">
        <div class="flex justify-content-center">
            <div class="col-md-4 rounded bg-white">
                <h1 class="h3 box-title pb-2"><a href="/admin/permissions" class="text-small mr-3" title="Back">
                    <img src="{{ asset('/assets/backend/icons/back.svg'); }}" class="back-icon" /></a>
                    @if(count($settings)=='0') 
                        Add New Permissions 
                    @else
                        Edit Permissions Details
                    @endif
                </h1><hr>
                <!-- start	end	remark	status	 -->
                <form action="{{ route('managePermission') }}" method="POST" class="card-body pb-3 px-3">
                    @csrf
                    @if(!empty($_GET['id']))
                    <input type="hidden" name="id" value="{{ $_GET['id'] }}" />
                    @endif
                    <div class="form-group">
                        <label class="small">Role*</label><br>
                        @php $role = $settings[0]->role ?? ''; @endphp
                        <div class="input-group">
                            <img src="{{ asset('/assets/backend/icons/list-down.svg'); }}" class="input-icon" />
                            <select name="srole" class="form-control">
                                <option value="">Select Role</option>
                                <option value="1" @if($role=='1') selected @endif>Admin</option>
                                <option value="2" @if($role=='2') selected @endif>Manager</option>
                                <option value="3" @if($role=='3') selected @endif>Agent</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group pl-3">
                        <label class="small">Features Access*</label><br>
                        @php $access = explode(',',($settings[0]->access ?? '')); @endphp
                        <div class="checkbox-area">
                            <div class="clist">
                                <input type="checkbox" name="saccess[]" value="1" @if(in_array('1', $access ?? [])) checked @endif /> Blogs Management
                            </div>
                            <div class="clist">
                                <input type="checkbox" name="saccess[]" value="2" @if(in_array('2', $access ?? [])) checked @endif /> Users Management
                            </div>
                            <div class="clist">
                                <input type="checkbox" name="saccess[]" value="3" @if(in_array('3', $access ?? [])) checked @endif /> Products Management
                            </div>
                            <div class="clist">
                                <input type="checkbox" name="saccess[]" value="4" @if(in_array('4', $access ?? [])) checked @endif /> Orders Management
                            </div>
                            <div class="clist">
                                <input type="checkbox" name="saccess[]" value="5" @if(in_array('5', $access ?? [])) checked @endif /> Support Management
                            </div>
                            <div class="clist">
                                <input type="checkbox" name="saccess[]" value="6" @if(in_array('6', $access ?? [])) checked @endif /> Pages Management
                            </div>
                            <div class="clist">
                                <input type="checkbox" name="saccess[]" value="7" @if(in_array('7', $access ?? [])) checked @endif /> Settings Management
                            </div>

                        </div>
                    </div>
                    <div class="form-group pl-3">
                        <label class="small">Modification Access*</label><br>
                        @php $actions = explode(',',($settings[0]->actions ?? '')); @endphp
                        <div class="checkbox-area">
                            <div class="clist">
                                <input type="checkbox" name="sactions[]" value="0" 
                                    @if(in_array('0', $actions ?? [])) checked @endif /> View
                            </div>
                            <div class="clist">
                                <input type="checkbox" name="sactions[]" value="1" 
                                    @if(in_array('1', $actions ?? [])) checked @endif /> Add Options
                            </div>
                            <div class="clist">
                                <input type="checkbox" name="sactions[]" value="2" 
                                    @if(in_array('2', $actions ?? [])) checked @endif /> Edit Options
                            </div>
                            <div class="clist">
                                <input type="checkbox" name="sactions[]" value="3" 
                                    @if(in_array('3', $actions ?? [])) checked @endif /> Export/Import Options
                            </div>
                            <div class="clist">
                                <input type="checkbox" name="sactions[]" value="4" 
                                    @if(in_array('4', $actions ?? [])) checked @endif /> Delete Options
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mt-lg-1 mb-0">
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