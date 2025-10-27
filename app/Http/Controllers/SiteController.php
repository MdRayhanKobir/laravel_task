<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        $courses = Course::withCount('modules')->orderBy('created_at', 'desc')->get();
        return view('courses.index', compact('courses'));
    }

    public function courses()
    {
        $courses = Course::withCount('modules')->orderBy('created_at', 'desc')->get();
        return view('courses.index', compact('courses'));
    }

    public function courseDetails($slug, $id)
    {
        $course = Course::with(['modules.contents', 'user'])->findOrFail($id);
        if (Str::slug($course->title) !== $slug) {
            return redirect()->route('course.details', [
                'slug' => Str::slug($course->title),
                'id' => $course->id,
            ]);
        }
        return view('courses.details', compact('course'));
    }
}
