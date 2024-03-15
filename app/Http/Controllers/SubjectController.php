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
        $subject = Subject::paginate(5);
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
        ]);
        Subject::create([
            'name' => $request->name,
            'class_id' => $request->class_id,
            'uuid' => \Str::uuid(),
        ]);
        return redirect('/subject/index')->with('success', 'Subjects added successfully');
    }

    public function edit($id)
    {
        return view('subject.edit', [
            'subject' => Subject::where('uuid', $id)->first()
        ]);
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
