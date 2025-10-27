@extends('layouts.frontend')

@section('content')
    <div class="container mt-5 mb-5">
        <h2 class="mb-4">All Courses</h2>

        @if ($courses->isEmpty())
            <div class="alert alert-info">No courses found.</div>
        @endif

        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-img-top">
                            @if ($course->feature_video)
                                <video class="c-video" controls width="100%" height="220px">
                                    <source src="{{ asset('storage/' . $course->feature_video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif

                        </div>

                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge text-bg-info w-2">
                                    {{ $course->created_at->format('d M Y') }}
                                </span>
                            </div>
                            <h5 class="card-title">{{ $course->title }}</h5>
                            <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                            <div class="mt-3 d-flex flex-wrap gap-3 justify-content-between">
                                <p class="text-muted mb-1"><strong>Category:</strong> {{ $course->category }}</p>
                                <p class="text-muted mb-2"><strong>Modules:</strong> {{ $course->modules_count }}</p>
                            </div>
 
                        </div>

                        <div class="card-footer text-muted text-end">
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <a href="{{ route('course.details', ['slug' => Str::slug($course->title), 'id' => $course->id]) }}" class="btn btn--base btn--sm">View</a>

                                @auth
                                @if (auth()->id() === $course->user_id)
                                <a href="{{ route('course.edit', $course->id) }}" class="btn btn--base-two btn--sm text--black">Edit</a>
                                @endif
                            @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
