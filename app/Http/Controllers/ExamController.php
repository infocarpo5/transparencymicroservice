<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Student;
use App\Models\ExamScore;
use App\Models\Clas;
use App\Models\Subject;
use App\Mail\SendToParent;
use Mail;


class ExamController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $exam = Exam::paginate(5);
        return view('exam.index', ['exam' => $exam]);
    }

    public function add()
    {
        return view('exam.add', [
            'subjects' => Subject::get(['id', 'name'])        
        ]);
    }

    public function store(Request $request)
    {
        // dd(request('class_id'));
        try {
            $data = $request->validate([
                'name' => ['required', 'string'],
                'term' => ['required', 'string'],
                'abbreviation' => ['required', 'string'],
                'date' => ['required', 'date'],
                'subject_id' => ['required']
            ]);
            $data['uuid']  = \Str::uuid();
            $exam = Exam::create($data);
            $class = Clas::whereIn('id', Subject::where('id', $request->subject_id)->get(['id']))->first();
            $students = Student::where('class_id', $class->id)->get();
            // dd($students);
            foreach($students as $student) {
                ExamScore::create([
                    'exam_id' => $exam->id,
                    'student_id' => $student->id,
                    'score' => null,
                    // 'class_id' => $student->class->id,
                    'uuid' => \Str::uuid(),
                ]);
            }
            return redirect('/exam/index')->with('success', 'exam added successfully');
        } catch (\Exception $th) {
            // dd($th->getMessage());
            \Log::error($th);

            // Return a user-friendly error message
            return redirect()->back()->with('error', 'An error occurred while adding the exam.');
        }
    }

    public function exam($uuid)
    {
        // $exam = Exam::whereUuid($uuid)->first();
        // $score = ExamScore::where('exam_id', $exam->id)->first();
        return view('exam.markExam', [
            'exam' => $score->exam->name ?? "",
            'exam' => "bios" ?? "",
            'exam_id' => $uuid,
        ]);
    }

    public function getDataToMark($uuid)
    {
        $exam = Exam::where('uuid', $uuid)->first();
        $query = ExamScore::where('exam_id', $exam->id);
        $data = $query->get()->map(fn ($item) => [
            'studentName' => $item->student->name,
            'studentId' => $item->student->uuid,
            'scoreUuId' => $item->uuid,
            'score' => $item->score,
            'unit' => $item->exam->subject->unit ?? "",
        ]);
        $unmarked = $query->where('score', null)->where('is_published', 0)->get()->count();
        $response = [
            'data' => $data,
            'show_publish_button' => $unmarked > 0 ? false : true
        ];
        return response()->json($response);
    }

    public function mark()
    {
        // dd(request()->all());
       $score = ExamScore::whereIn('student_id', Student::where('uuid', request('studentId'))->get(['id']))->whereIn('exam_id', Exam::where('uuid', request('examId'))->get(['id']))->first();
       $updated = $score->update([
        'score' => request('score')
       ]);
       if ($updated) {
        return response()->json([
            'success' => 'score marked successfully!',
            'status' => 200
        ]);
       } else {
        return response()->json([
            'error' => 'problem occured!',
            'status' => 201
        ]);
       }
    }

    public function delete($id){
        $class = Exam::where('uuid', $id)->first();
        ExamScore::where('exam_id', $class->id)->first()->delete();
        if (!$class) {
            return response()->json(['message' => 'User not found'], 404);
        }
        try {
            $class->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the class'], 500);
        }
    }

    public function results($student)
    {
        $studentID = $student;
        $query = ExamScore::whereIn('student_id', Student::where('uuid', $student)->get(['id']))->get();
        $data = $query->map(fn ($item, $index = 0) => [
            'studentName' => $item->student->name,
            'score' => $item->score,
            'semester' => $item->exam->term,
            'sn' => $index += 1,
            'subject' => $item->exam->subject->name ?? "",
        ])->groupBy('semester');
        
        return view('exam.results', [
            'data' => $data,
            'student' => Student::where('uuid', $student)->first(),
            'studentID' => $studentID
        ]);
    }

    public function printResults($student)
    {
        $query = ExamScore::whereIn('student_id', Student::where('uuid', $student)->get(['id']))->get();
        $data = $query->map(fn ($item, $index = 0) => [
            'studentName' => $item->student->name,
            'score' => $item->score,
            'semester' => $item->exam->term,
            'sn' => $index += 1,
            'subject' => $item->exam->subject->name ?? "",
            'unit' => $item->exam->subject->unit ?? "",
        ])->groupBy('semester');
        // dd($data);
        return view('exam.print', [
            'data' => $data,
            'student' => Student::where('uuid', $student)->first()
        ]);
    }

    public function sendEmail()
    {
        $title = 'School Info';
        $body = 'We would like to inform you that the results have published. Please use the credentials below to log into your platform so that you can view results via API!';

        Mail::to('kelvinchambulila5@gmail.com')->send(new SendToParent($title, $body));

        return "Email sent successfully!";
    }

    public function publishResult($id)
    {
        $exam_scores = ExamScore::whereIn('exam_id', Exam::whereUuid($id)->get(['id']))->get();
            foreach($exam_scores as $score) {
                $score->update([
                    'is_published' => 1
                ]);        
            }
        
        foreach($exam_scores as $student) {
            $title = 'School Info';
            $body = 'We would like to inform you that the results of your student ' .ucwords($student->student->name). ' have published. Please use the credentials below to log into your platform so that you can view results via API!';
            Mail::to($student->student->parent_email)->send(new SendToParent($title, $body));
        }
        return back()->withSuccess("Results successfully published");
    }

}
