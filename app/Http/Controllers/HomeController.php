<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Clas;
use App\Models\Student;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $programmes = Clas::count();
        $courses = Subject::count();
        $students = Student::count();
        $exams = Exam::count();

        return view('home', [
            'programmes' => $programmes,
            'students' => $students,
            'courses' => $courses,
            'exams' => $exams
        ]);
    }
}
