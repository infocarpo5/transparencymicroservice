<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clas;

class ClasController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $request){
        $class = Clas::paginate(5);
        return view('class.index', ['class' => $class]);
    }

    public function add()
    {

        return view('class.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);
        Clas::create([
            'name' => $request->name,
            'uuid' => \Str::uuid(),
        ]);
        return redirect('/class/index')->with('success', 'Class added successfully');
    }

    public function edit($id)
    {
        return view('class.edit', [
            'class' => Clas::where('uuid', $id)->first()
        ]);
    }

    public function delete($id)
    {
        $class = Clas::where('uuid', $id)->first();
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }
        try {
            $class->delete();
            return response()->json(['message' => 'Class deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the class'], 500);
        }
    }
}
