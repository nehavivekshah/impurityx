@extends('backend.layout')
@section('title','Manage Notice - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection

@section('content')
<section class="task__section">
    <div class="text header-text">Management Panel</div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>{{ isset($notice) ? 'Edit Notice' : 'Add New Notice' }}</h1>
            <a href="/admin/notices" class="btn btn-secondary">Back</a>
        </div>

        <div class="flex">
            <div class="col-md-8 offset-md-2 rounded p-4 bg-white">
                <form action="/admin/manage-notice" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Notice ID</label>
                        <input type="text" name="notice_id" class="form-control" placeholder="Enter unique notice ID" value="{{ $noticeId ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Enter notice message" required>{{ old('message',$notice->message ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-control" required>
                            <option value="">-- Select Type --</option>
                            <option value="buyers" {{ old('type',$notice->type ?? '')=='buyers' ? 'selected' : '' }}>Buyers</option>
                            <option value="sellers" {{ old('type',$notice->type ?? '')=='sellers' ? 'selected' : '' }}>Sellers</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary border">
                            Send
                        </button>
                        <a href="/admin/notices" class="btn btn-light border">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
