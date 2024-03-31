<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clas;
use App\Models\Student;
use App\Models\User;


class StudentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $request){
        $student = User::where('role_id', 0)->paginate(5);
        return view('student.index', ['student' => $student]);
    }

    public function add()
    {
        $classes = Clas::get(['id', 'name']);
        return view('student.add', compact('classes'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string'],
            'gender' => ['required'],
            'yearAdmitted' => ['required', 'string'],
            'parent_name' => ['required', 'string'],
            'parent_email' => ['required', 'email'],
            'parent_phone' => ['required', 'string'],
            'reg' => ['required', 'string'],
            'class_id' => ['required'],
        ]);
        // $data['uuid']  = \Str::uuid();
        // $data['password']  = \Hash::make($request->parent_phone);
        // $data['role_id']  = 0;
        // $data['reg']  = $request->email;
        // dd($data);
        User::create([
            'full_name' => $request->name,
            'parent_phone' => $request->parent_phone,
            'parent_name' => $request->parent_name,
            'parent_email' => $request->parent_email,
            'class_id' => $request->class_id,
            'email' => $request->reg,
            'role_id' => 0,
            'uuid' => \Str::uuid(),
            'password' => \Hash::make($request->parent_phone),
        ]);
        return redirect('/student/index')->with('success', 'student added successfully');
    }

    public function delete($id)
    {
        $deleted = User::where('uuid', $id)->first()->delete();
        if($deleted) {
            return redirect('/student/index')->with('success', 'student deleted successfully');
        }
    }

    public function edit($id)
    {
        $student = User::where('uuid', $id)->first();
        return view('student.edit', [
            'class' => $student
        ]);
    }
}
