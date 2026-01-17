<form action="{{ url('/my-account/my-profile') }}" id="profileForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="dashboard-area box--shadow mt-4 mb-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-12 border rounded p-4">

                    <!-- Profile Header -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <img id="profilePreview" 
                                 src="{{ $user->photo ? asset('/public/assets/frontend/img/users/'.$user->photo) : asset('/public/assets/frontend/images/icons/admin.svg') }}" 
                                 alt="Profile Picture" 
                                 class="rounded-circle border" width="100" height="100">
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ $user->first_name }} {{ $user->last_name }}</h4>
                            <small class="text-muted">{{ $user->email }}</small>
                            <div class="mt-2">
                                <label for="profile_photo" class="btn btn-sm btn-outline-primary">
                                    Change Photo
                                </label>
                                <input type="file" class="d-none" name="profile_photo" id="profile_photo" 
                                       accept="image/*" onchange="previewProfile(event)">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="fw-bold">First Name *</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" 
                                   value="{{ old('first_name', $user->first_name) }}" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="fw-bold">Last Name *</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" 
                                   value="{{ old('last_name', $user->last_name) }}" required>
                        </div>

                        <!-- Contact Number -->
                        <div class="col-md-6 mb-3">
                            <label for="contact" class="fw-bold">Contact Number</label>
                            <input type="text" class="form-control" name="contact" minlength="11" maxlength="13" id="contact" 
                                   value="{{ old('mob', $user->mob) }}">
                        </div>

                        <!-- Whatsapp Number -->
                        <div class="col-md-6 mb-3">
                            <label for="whatsapp" class="fw-bold">Whatsapp Number</label>
                            <input type="text" class="form-control" name="whatsapp" minlength="11" maxlength="13" id="whatsapp" 
                                   value="{{ old('whatsapp', $user->whatsapp) }}">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="fw-bold">Email</label>
                            <input type="email" class="form-control" name="email" id="email" 
                                   value="{{ old('email', $user->email) }}">
                        </div>

                        <!-- Company Name -->
                        <!--<div class="col-md-6 mb-3">-->
                        <!--    <label for="company_name" class="fw-bold">Company Name *</label>-->
                        <!--    <input type="text" class="form-control" name="company" id="company" -->
                        <!--           value="{{ old('company', $user->company) }}" required>-->
                        <!--</div>-->

                        <!-- Trade Name -->
                        <!--<div class="col-md-6 mb-3">-->
                        <!--    <label for="trade" class="fw-bold">Trade Name *</label>-->
                        <!--    <input type="text" class="form-control" name="trade" id="trade" -->
                        <!--           value="{{ old('trade', $user->trade) }}" required>-->
                        <!--</div>-->

                        <!-- PAN No / Income Tax Regn No -->
                        <!--<div class="col-md-6 mb-3">-->
                        <!--    <label for="panno" class="fw-bold">PAN No / Income Tax Regn No *</label>-->
                        <!--    <input type="text" class="form-control" name="panno" id="panno" -->
                        <!--           value="{{ old('panno', $user->panno) }}" required>-->
                        <!--</div>-->

                        <!-- GSTIN / VAT Regn No. -->
                        <!--<div class="col-md-6 mb-3">-->
                        <!--    <label for="vat" class="fw-bold">GSTIN / VAT Regn No. *</label>-->
                        <!--    <input type="text" class="form-control" name="vat" id="vat" -->
                        <!--           value="{{ old('vat', $user->vat) }}" required>-->
                        <!--</div>-->
                        
                        <!-- Registered Address -->
                        <!--<div class="col-md-12 mb-3">-->
                        <!--    <label for="regAddress" class="fw-bold">Registered Address</label>-->
                        <!--    <input type="text" class="form-control" name="regAddress" id="regAddress" -->
                        <!--           value="{{ old('regAddress', $user->regAddress) }}">-->
                        <!--</div>-->

                        <!-- Communication Address -->
                        <div class="col-md-12 mb-3">
                            <label for="comAddress" class="fw-bold">Address</label>
                            <input type="text" class="form-control" name="comAddress" id="comAddress" 
                                   value="{{ old('comAddress', $user->comAddress) }}" readonly>
                        </div>

                        <!-- City -->
                        <div class="col-md-6 mb-3">
                            <label for="city" class="fw-bold">City</label>
                            <input type="text" class="form-control" name="city" id="city" 
                                   value="{{ old('city', $user->city) }}" readonly>
                        </div>

                        <!-- State -->
                        <div class="col-md-6 mb-3">
                            <label for="state" class="fw-bold">State</label>
                            <input type="text" class="form-control" name="state" id="state" 
                                   value="{{ old('state', $user->state) }}" readonly>
                        </div>

                        <!-- Pin Code -->
                        <div class="col-md-6 mb-3">
                            <label for="pincode" class="fw-bold">Pin Code</label>
                            <input type="text" class="form-control" name="pincode" id="pincode" 
                                   value="{{ old('pincode', $user->pincode) }}" readonly>
                        </div>

                        <!-- Country -->
                        <div class="col-md-6 mb-3">
                            <label for="country" class="fw-bold">Country</label>
                            <input type="text" class="form-control" name="country" id="country" 
                                   value="{{ old('country', $user->country ?? 'India') }}" readonly>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="fw-bold">Password *</label>
                            <input type="password" class="form-control" name="password" id="password" 
                                   placeholder="Create A Password">
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="fw-bold">Confirm Password *</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" 
                                   placeholder="Confirm Password">
                            <small id="passwordError" class="text-danger d-none">Passwords do not match.</small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-success">Update Profile</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

<!-- Preview Script -->
<script>
function previewProfile(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('profilePreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<script>
document.querySelector("#profileForm").addEventListener("keyup", function(e) {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("password_confirmation").value;
    let errorMsg = document.getElementById("passwordError");

    if (password !== "" && password !== confirmPassword) {
        e.preventDefault();
        errorMsg.classList.remove("d-none"); // show error
    } else {
        errorMsg.classList.add("d-none"); // hide error if matched
    }
});
</script>