<?php

namespace App\Http\Controllers\User;

use App\Models\Course;
use App\Models\Module;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function myCourses()
    {
        $courses = Course::withCount('modules')->where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'feature_video' => 'nullable|mimes:mp4,mov,avi',
            'modules' => 'required|array',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.contents' => 'nullable|array',
            'modules.*.contents.*.title' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $featureVideoPath = null;
            if ($request->hasFile('feature_video')) {
                $featureVideoPath = $request->file('feature_video')->store('videos', 'public');
            }

            $course = new Course();
            $course->user_id = auth()->user()->id;
            $course->title = $request->title;
            $course->description = $request->description;
            $course->category = $request->category;
            $course->feature_video = $featureVideoPath;
            $course->save();

            foreach ($request->modules as $moduleIndex => $moduleData) {
                $module = new Module();
                $module->course_id = $course->id;
                $module->title = $moduleData['title'];
                $module->save();

                if (isset($moduleData['contents'])) {
                    foreach ($moduleData['contents'] as $contentIndex => $contentData) {
                        $mediaPath = null;
                        $inputName = "modules.{$moduleIndex}.contents.{$contentIndex}.media";
                        if ($request->hasFile($inputName)) {
                            $mediaPath = $request->file($inputName)->store('content_media', 'public');
                        }

                        $content = new Content();
                        $content->module_id = $module->id;
                        $content->type = $contentData['type'];
                        $content->title = $contentData['title'];
                        $content->description = $contentData['description'] ?? null;
                        $content->media = $mediaPath;
                        $content->save();
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Course created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $course = Course::with(['modules.contents'])->findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'feature_video' => 'nullable|mimes:mp4,mov,avi',
            'modules' => 'required|array',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.contents' => 'nullable|array',
            'modules.*.contents.*.title' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $course = Course::findOrFail($id);
            $featureVideoPath = $course->feature_video;
            if ($request->hasFile('feature_video')) {
                if ($featureVideoPath && Storage::disk('public')->exists($featureVideoPath)) {
                    Storage::disk('public')->delete($featureVideoPath);
                }
                $featureVideoPath = $request->file('feature_video')->store('videos', 'public');
            }
            $course->user_id = auth()->user()->id;
            $course->title = $request->title;
            $course->description = $request->description;
            $course->category = $request->category;
            $course->feature_video = $featureVideoPath;
            $course->save();

            $course->modules()->each(function ($module) {
                $module->contents()->delete();
                $module->delete();
            });

            // Insert modules
            foreach ($request->modules as $moduleIndex => $moduleData) {
                $module = new Module();
                $module->course_id = $course->id;
                $module->title = $moduleData['title'];
                $module->save();

                if (isset($moduleData['contents'])) {
                    foreach ($moduleData['contents'] as $contentIndex => $contentData) {
                        $mediaPath = null;
                        $inputName = "modules.{$moduleIndex}.contents.{$contentIndex}.media";

                        if ($request->hasFile($inputName)) {
                            $mediaPath = $request->file($inputName)->store('content_media', 'public');
                        }

                        $content = new Content();
                        $content->module_id = $module->id;
                        $content->type = $contentData['type'] ?? 'text';
                        $content->title = $contentData['title'];
                        $content->description = $contentData['description'] ?? null;
                        $content->media = $mediaPath;
                        $content->save();
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Course updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


}
