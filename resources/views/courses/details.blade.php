@extends('layouts.frontend')

@section('content')
<div class="container my-5 mb-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="mb-3">{{ $course->title }}</h4>
                    <p class="text-muted mb-2">
                        <strong>Category:</strong> {{ $course->category }} |
                        <strong>Created:</strong> {{ $course->created_at->format('d M Y') }}
                    </p>

                    @if ($course->feature_video)
                        <div class="mb-4">
                            <video class="w-100 rounded" controls>
                                <source src="{{ asset('storage/' . $course->feature_video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @endif

                    <p>{{ $course->description }}</p>
                </div>
            </div>

            @foreach ($course->modules as $module)
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">{{ $module->title }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($module->contents->isEmpty())
                            <p class="text-muted">No contents available for this module.</p>
                        @else
                            @foreach ($module->contents as $content)
                                <div class="mb-4 border-bottom pb-3">
                                    <h6 class="fw-bold">{{ $content->title }}</h6>
                                    <p class="text-muted small mb-1">Type: {{ ucfirst($content->type) }}</p>
                                    @if ($content->description)
                                        <p>{{ $content->description }}</p>
                                    @endif

                                    @if ($content->media)
                                        <div class="mt-2">
                                            @if (Str::endsWith($content->media, ['.mp4', '.mov', '.avi']))
                                                <video width="100%" height="240" controls>
                                                    <source src="{{ asset('storage/' . $content->media) }}" type="video/mp4">
                                                </video>
                                            @else
                                                <a href="{{ asset('storage/' . $content->media) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                    View File
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Instructor Info</h5>
                    <p class="mb-1"><strong>Name:</strong> {{ $course->user->name ?? 'Unknown' }}</p>
                    <p class="mb-3"><strong>Email:</strong> {{ $course->user->email ?? 'N/A' }}</p>

                    @auth
                        @if (auth()->id() === $course->user_id)
                            <a href="{{ route('course.edit', $course->id) }}" class="btn btn--base-two btn--sm text--black">Edit Course</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
