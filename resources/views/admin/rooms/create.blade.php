@extends('admin.layout')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">Create New Room</h1>
                    <p class="text-muted mb-0">Add a new room to your hotel inventory</p>
                </div>
                <a href="{{ route('room.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Rooms
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Form -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-door-open text-primary me-2"></i>
                        Room Information
                    </h5>
                </div>
                
                <form action="{{ route('room.store') }}" method="POST" enctype="multipart/form-data" id="roomForm">
                    @csrf
                    <div class="card-body p-4">
                        <!-- Basic Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-info-circle me-2"></i>Basic Information
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="room_number" class="form-label fw-semibold">
                                    Room Number <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-hash"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control @error('room_number') is-invalid @enderror" 
                                           id="room_number" 
                                           name="room_number" 
                                           value="{{ old('room_number') }}"
                                           placeholder="e.g., 101, A-205"
                                           required>
                                </div>
                                @error('room_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="type" class="form-label fw-semibold">
                                    Room Type <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-house"></i>
                                    </span>
                                    <select class="form-select @error('type') is-invalid @enderror" 
                                            id="type" 
                                            name="type" 
                                            required>
                                        <option value="">Choose room type...</option>
                                        <option value="single" {{ old('type') == 'single' ? 'selected' : '' }}>Single Room</option>
                                        <option value="double" {{ old('type') == 'double' ? 'selected' : '' }}>Double Room</option>
                                        <option value="suite" {{ old('type') == 'suite' ? 'selected' : '' }}>Suite</option>
                                        <option value="deluxe" {{ old('type') == 'deluxe' ? 'selected' : '' }}>Deluxe Room</option>
                                        <option value="luxury" {{ old('type') == 'luxury' ? 'selected' : '' }}>Luxury Room</option>
                                    </select>
                                </div>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pricing & Status Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-currency-dollar me-2"></i>Pricing & Availability
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-semibold">
                                    Price per Night <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           min="0"
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price') }}"
                                           placeholder="0.00"
                                           required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">
                                    Availability Status <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-check-circle"></i>
                                    </span>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Select status...</option>
                                        <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                                        <option value="Unavailable" {{ old('status') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                                    </select>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-file-text me-2"></i>Room Description
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">
                                    Description
                                    <small class="text-muted">(Optional)</small>
                                </label>
                                <div id="editor-container" style="height: 200px;" class="border rounded">
                                    {!! old('description') !!}
                                </div>
                                <input type="hidden" name="description" id="description">
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Describe the room features, amenities, and highlights.</small>
                            </div>
                        </div>

                        <!-- Image Upload Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-image me-2"></i>Room Image
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="image" class="form-label fw-semibold">
                                    Upload Room Image
                                    <small class="text-muted"></small>
                                </label>
                                <div class="upload-area border-2 border-dashed rounded p-4 text-center" 
                                     style="border-color: #dee2e6; transition: all 0.3s;">
                                    <div class="upload-icon mb-3">
                                        <i class="bi bi-cloud-upload text-muted" style="font-size: 2rem;"></i>
                                    </div>
                                    <input type="file" 
                                           class="form-control d-none @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image"
                                           accept="image/*">
                                    <div class="upload-text">
                                        <p class="mb-1">Click to upload or drag and drop</p>
                                        <small class="text-muted">PNG, JPG, JPEG up to 2MB</small>
                                    </div>
                                    <div class="preview-container mt-3" style="display: none;">
                                        <img id="image-preview" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                </div>
                                @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="card-footer bg-light py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <span class="text-danger">*</span> Required fields
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('room.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-plus-circle me-2"></i>Create Room
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .upload-area {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .upload-area:hover {
        border-color: #0d6efd !important;
        background-color: #f8f9ff;
    }
    
    .ql-toolbar {
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
    }
    
    .ql-container {
        border-bottom-left-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
        font-family: inherit;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endpush

@push('scripts')
<!-- Quill Editor JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill Editor
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Describe the room features, amenities, size, view, and any special highlights...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    });

    // Handle form submission
    document.getElementById('roomForm').addEventListener('submit', function() {
        const description = quill.root.innerHTML;
        document.getElementById('description').value = description === '<p><br></p>' ? '' : description;
    });

    // Image upload preview
    const uploadArea = document.querySelector('.upload-area');
    const imageInput = document.getElementById('image');
    const previewContainer = document.querySelector('.preview-container');
    const imagePreview = document.getElementById('image-preview');

    uploadArea.addEventListener('click', function() {
        imageInput.click();
    });

    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#0d6efd';
        uploadArea.style.backgroundColor = '#f8f9ff';
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#dee2e6';
        uploadArea.style.backgroundColor = '';
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#dee2e6';
        uploadArea.style.backgroundColor = '';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            handleImagePreview(files[0]);
        }
    });

    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            handleImagePreview(this.files[0]);
        }
    });

    function handleImagePreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    // Form validation enhancement
    const form = document.getElementById('roomForm');
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
});
</script>
@endpush
@endsection