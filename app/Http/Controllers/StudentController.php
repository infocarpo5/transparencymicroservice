<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clas;
use App\Models\Student;


class StudentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $request){
        $student = Student::paginate(5);
        return view('student.index', ['student' => $student]);
    }

    public function add()
    {
        $classes = Clas::get(['id', 'name']);
        return view('student.add', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'yearAdmitted' => ['required', 'string'],
            'parent_name' => ['required', 'string'],
            'parent_email' => ['required', 'email'],
            'parent_phone' => ['required', 'string'],
            'reg' => ['required', 'string'],
            'class_id' => ['required'],
        ]);
        $data['uuid']  = \Str::uuid();
        Student::create($data);
        return redirect('/student/index')->with('success', 'student added successfully');
    }
}
