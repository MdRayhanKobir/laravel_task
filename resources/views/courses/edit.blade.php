@extends('layouts.frontend')

@section('content')
    <div class="container mt-5 mb-5">
        <h4 class="mb-4">Edit Course</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('course.update', $course->id) }}" method="POST" enctype="multipart/form-data" id="courseForm">
            @csrf
            <div class="card mb-4 shadow-sm">
                <div class="card-header">Course Details</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Course Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="title"
                            value="{{ old('title', $course->title) }}" placeholder="Enter course title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Course Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter course description"
                            required>{{ old('description', $course->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="category" id="category"
                            value="{{ old('category', $course->category) }}" placeholder="Enter course category" required>
                    </div>
                    <div class="mb-3">
                        <label for="feature_video" class="form-label">Feature Video</label>
                        <input type="file" class="form-control" name="feature_video" id="feature_video">
                        @if ($course->feature_video)
                            <p class="mt-2">
                                <video width="100" height="100" controls>
                                    <source src="{{ asset('storage/' . $course->feature_video) }}" type="video/mp4">
                                    Your browser does not support video playback.
                                </video>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modules -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Modules</span>
                    <button type="button" class="btn btn--base btn-light" id="addModuleBtn"><i
                            class="fa-solid fa-plus"></i> Add Module</button>
                </div>
                <div class="card-body" id="modulesContainer">
                    @foreach ($course->modules as $mIndex => $module)
                        <div class="card mb-3 border-info p-3 module" data-index="{{ $mIndex }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Module</h5>
                                <button type="button" class="btn btn-sm btn-danger removeModuleBtn"><i
                                        class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="mb-3">
                                <label>Module Title <span class="text-danger">*</span></label>
                                <input type="text" name="modules[{{ $mIndex }}][title]"
                                    value="{{ $module->title }}" class="form-control" placeholder="Enter module title"
                                    required>
                            </div>
                            <div class="contentsContainer">
                                @foreach ($module->contents as $cIndex => $content)
                                    <div class="card mb-2 border-secondary p-3 content">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Content</h6>
                                            <button type="button" class="btn btn-sm btn-danger removeContentBtn"><i
                                                    class="fa-solid fa-xmark"></i></button>
                                        </div>
                                        <div class="mb-2">
                                            <label>Content Title <span class="text-danger">*</span></label>
                                            <input type="text"
                                                name="modules[{{ $mIndex }}][contents][{{ $cIndex }}][title]"
                                                value="{{ $content->title }}" class="form-control"
                                                placeholder="Enter content title" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Type</label>
                                            <select
                                                name="modules[{{ $mIndex }}][contents][{{ $cIndex }}][type]"
                                                class="form-control">
                                                <option value="text" {{ $content->type == 'text' ? 'selected' : '' }}>
                                                    Text</option>
                                                <option value="image" {{ $content->type == 'image' ? 'selected' : '' }}>
                                                    Image</option>
                                                <option value="video" {{ $content->type == 'video' ? 'selected' : '' }}>
                                                    Video</option>
                                                <option value="link" {{ $content->type == 'link' ? 'selected' : '' }}>
                                                    Link</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label>Description</label>
                                            <textarea name="modules[{{ $mIndex }}][contents][{{ $cIndex }}][description]" class="form-control"
                                                rows="2" placeholder="Enter content description">{{ $content->description }}</textarea>
                                        </div>
                                        <div class="mb-2">
                                            <label>Media (optional)</label>
                                            <input type="file"
                                                name="modules[{{ $mIndex }}][contents][{{ $cIndex }}][media]"
                                                class="form-control">
                                            @if ($content->media)
                                                <small class="text-muted">Current: {{ basename($content->media) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn--base btn--sm addContentBtn"><i
                                    class="fa-solid fa-plus"></i> Add Content</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn--base btn-lg w-100">Update Course</button>
        </form>
    </div>
@endsection

@push('script')
    <script>
        let moduleIndex = {{ $course->modules->count() ?? 0 }};

        $('#addModuleBtn').click(function() {
            let moduleHtml = `
        <div class="card mb-3 border-info p-3 module" data-index="${moduleIndex}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Module</h5>
                <button type="button" class="btn btn--sm btn-danger removeModuleBtn"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="mb-3">
                <label>Module Title <span class="text-danger">*</span></label>
                <input type="text" name="modules[${moduleIndex}][title]" class="form-control" placeholder="Enter module title" required>
            </div>
            <div class="contentsContainer"></div>
            <button type="button" class="btn btn--base btn--sm addContentBtn"><i class="fa-solid fa-plus"></i> Add Content</button>
        </div>
    `;
            $('#modulesContainer').append(moduleHtml);
            moduleIndex++;
        });

        $(document).on('click', '.removeModuleBtn', function() {
            $(this).closest('.module').remove();
        });

        $(document).on('click', '.addContentBtn', function() {
            let moduleDiv = $(this).closest('.module');
            let moduleIdx = moduleDiv.data('index');
            let contentIndex = moduleDiv.find('.content').length;

            let contentHtml = `
        <div class="card mb-2 border-secondary p-3 content">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Content</h6>
                <button type="button" class="btn btn-sm btn-danger removeContentBtn"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="mb-2">
                <label>Content Title <span class="text-danger">*</span></label>
                <input type="text" name="modules[${moduleIdx}][contents][${contentIndex}][title]" class="form-control" placeholder="Enter content title" required>
            </div>
            <div class="mb-2">
                <label>Type</label>
                <select name="modules[${moduleIdx}][contents][${contentIndex}][type]" class="form-control">
                    <option value="text">Text</option>
                    <option value="image">Image</option>
                    <option value="video">Video</option>
                    <option value="link">Link</option>
                </select>
            </div>
            <div class="mb-2">
                <label>Description</label>
                <textarea name="modules[${moduleIdx}][contents][${contentIndex}][description]" class="form-control" rows="2" placeholder="Enter content description"></textarea>
            </div>
            <div class="mb-2">
                <label>Media (optional)</label>
                <input type="file" name="modules[${moduleIdx}][contents][${contentIndex}][media]" class="form-control">
            </div>
        </div>
    `;
            moduleDiv.find('.contentsContainer').append(contentHtml);
        });

        $(document).on('click', '.removeContentBtn', function() {
            $(this).closest('.content').remove();
        });
    </script>
@endpush
