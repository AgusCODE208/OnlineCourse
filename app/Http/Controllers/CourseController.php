<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    protected $courseService;
    public function __construct(
        CourseService $courseService,
    ) {
        $this->courseService = $courseService;
    }

    public function index()
    {
        $courseByCategory = $this->courseService->getCoursesGroupedByCategory();
        return view('course.index', compact('courseByCategory'));
    }
    // public function index()
    // {
    //     $courseByCategory = Course::with('category')
    //         ->latest()
    //         ->get()
    //         ->groupBy(function ($course) {
    //             return $course->category->name ?? 'Uncategorized';
    //         });

    //     return view('courses.index', compact('coursesByCategory'));
    // }

    public function details(Course $course)
    {
        $course->load(['category', 'benefits', 'courseSections.sectionContents']);
        return view('courses.details', compact('course'));
    }

    public function join(Course $course)
    {
        $studentName = $this->courseService->enrollUser($course);
        $firtsSectionAndContent = $this->courseService->getFirstSectionAndContent($course);

        return view('course.success_joined', array_merge(
            compact('course', 'studentName'),
            $firtsSectionAndContent
        ));
    }

    public function learning(Course $course, $contentSectionId, $sectionContentId)
    {
        $learningData = $this->courseService->getLearningData($course, $contentSectionId, $sectionContentId);

        return view('course.learning', $learningData);
    }

    public function learning_finished(Course $course)
    {
        return view('course.learning_finished', compact('course'));
    }

    // public function search_course(Request $request)
    // {
    //     $request->validate([
    //         'search' => 'require|string',
    //     ]);

    //     $keyword = $request->search;
    //     $course = Course::where('name', 'like', "{%{$keyword}%}")
    //         ->orWhere('about', 'like', "%{$keyword}%")
    //         ->get();

    //     return view('course.search', compact('courses', 'keyword'));
    // }

    public function search_course(Request $request)
    {
        $request->validate([
            'search' => 'require|string',
        ]);

        $keyword = $request->search;

        $course = $this->courseService->searchCourses($keyword);

        return view('course.search', compact('courses', 'keyword'));
    }
}
