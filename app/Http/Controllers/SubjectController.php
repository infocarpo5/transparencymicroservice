<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Clas;

class SubjectController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $request){
        if (\Auth::User()->role_id === 0) {
            $subject = Subject::where('class_id', \Auth::User()->class_id)->paginate(5);
        } else {
            $subject = Subject::paginate(5);
        }
        return view('subject.index', ['subject' => $subject]);
    }

    public function add()
    {
        $classes = Clas::get(['id', 'name', 'uuid']);
        return view('subject.add', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'unit' => ['required', 'string'],
            'class_id' => ['required'],
        ]);
        Subject::create([
            'name' => $request->name,
            'class_id' => (int)$request->class_id,
            'unit' => (int)$request->unit,
            'uuid' => \Str::uuid(),
        ]);
        return redirect('/courses/index')->with('success', 'Subjects added successfully');
    }

    public function edit($id)
    {
        return view('subject.edit', [
            'subject' => Subject::where('uuid', $id)->first(),
            'classes' => Clas::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'unit' => ['required', 'string'],
            'class_id' => ['required'],
        ]);
        Subject::where('uuid', $id)->first()->update([
            'name' => $request->name,
            'class_id' => (int)$request->class_id,
            'unit' => (int)$request->unit,
        ]);
        return redirect('/courses/index')->with('success', 'Subjects updated successfully');
    }

    public function delete($id)
    {
        $subject = Subject::where('uuid', $id)->first();
        if (!$subject) {
            return response()->json(['message' => 'Subjects not found'], 404);
        }
        try {
            $subject->delete();
            return response()->json(['message' => 'Subjects deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the subject'], 500);
        }
    }
}
