@extends('frontend.master')
@section('content')
{{--  form for editing category --}}
<div class="form-wrapper_container">
    <div class="form-wrapper">
        <h1 class="title">Edit Category</h1>
        <p class="subtitle">Update Your Category Details.</p>
        <form class="contact-form" method="post" action="{{ route('category.update', $category->id) }}">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-column">
                    <label for="title" class="form-label">Title</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $category->title) }}"
                        placeholder="Your title"
                        class="form-input"
                        required>
                </div>
                <div class="form-column">
                    <label for="description" class="form-label">Description</label>
                    <input
                        type="text"
                        id="description"
                        name="description"
                        value="{{ old('description', $category->description) }}"
                        placeholder="Your description"
                        class="form-input"
                        required>
                </div>
            </div>
            <button type="submit" class="submit-button">Update</button>
        </form>
    </div>
</div>
@endsection
