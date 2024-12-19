@extends('frontend.master')
@section('content')
{{--  table  --}}
<div class="form-wrapper_container">
<div class="form-wrapper">
    <h1 class="title">Create Category</h1>
    <p class="subtitle">Create Your Own Category Now To Manage Your business.</p>
    <form class="contact-form" method="post" action="{{ route('category.store') }}">
        @csrf
        <div class="form-row">
            <div class="form-column">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" placeholder="Your title" class="form-input" required>
            </div>
            <div class="form-column">
                <label for="description" class="form-label">Description</label>
                <input type="text" id="description" name="description" placeholder="Your description" class="form-input" required>
            </div>
        </div>
        {{--  <div class="form-row">
            <div class="form-column">
                <label for="contact" class="form-label">Contact</label>
                <input type="tel" id="contact" placeholder="Your phone number" class="form-input" required>
            </div>
            <div class="form-column">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" id="subject" placeholder="Subject" class="form-input" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-column">
                <label for="issue" class="form-label">Describe your issue</label>
                <textarea id="issue" placeholder="Describe your issue" rows="4" class="form-textarea" required></textarea>
            </div>
        </div>  --}}
        <button type="submit" class="submit-button">Submit</button>
    </form>
</div>
</div>
@endsection
