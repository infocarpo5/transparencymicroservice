<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Student;
use App\Models\ExamScore;
use App\Models\Clas;
use App\Models\User;
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
            $students = User::where('class_id', 1)->get();
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
        $exam = Exam::whereUuid($uuid)->first();
        return view('exam.markExam', [
            'exam' => $exam->exam->name ?? "",
            'exam' => ucwords($exam->subject->name) ?? "",
            'exam_id' => $uuid,
        ]);
    }

    public function getDataToMark($uuid)
    {
        $exam = Exam::where('uuid', $uuid)->first();
        $query = ExamScore::where('exam_id', $exam->id);
        $data = $query->get()->map(fn ($item) => [
            'studentName' => $item->user->full_name,
            'studentId' => $item->user->uuid,
            'scoreUuId' => $item->uuid,
            'score' => $item->score,
            'unit' => $item->exam->subject->unit ?? "",
        ]);
        $unmarked = ExamScore::where('exam_id', $exam->id)->whereNull('score')->count();  
        $response = [
            'data' => $data,
            'show_publish_button' => $unmarked > 0 ? false : true
        ];
        return response()->json($response);
    }

    public function mark()
    {
       $score = ExamScore::whereIn('student_id', User::where('uuid', request('studentId'))->get(['id']))->whereIn('exam_id', Exam::where('uuid', request('examId'))->get(['id']))->first();
       $updated = $score->update([
        'score' => request('score')
       ]);
       $unmarked = ExamScore::whereIn('student_id', User::where('uuid', request('studentId'))->get(['id']))->whereIn('exam_id', Exam::where('uuid', request('examId'))->get(['id']))
       ->whereNull('score')->where('is_published', 0)->count();

       if ($updated) {
        return response()->json([
            'success' => 'score marked successfully!',
            'status' => 200,
            'show_publish_button' => $unmarked > 0 ? false : true
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
    $query = ExamScore::whereIn('student_id', User::where('uuid', $student)->get(['id']))->whereNotNull('score')->get();
    $data = $query->map(function ($item, $index = 0) {
        return [
            'studentName' => $item->user->full_name ?? "", // Ensure 'full_name' key is defined
            'score' => $item->score,
            'semester' => $item->exam->term,
            'sn' => $index + 1, // Increment the index properly
            'subject' => $item->exam->subject->name ?? "",
            'unit' => $item->exam->subject->unit ?? "",
            'point' => $item->score > 70 ? 5 : ($item->score > 60 ? 4 : ($item->score > 50 ? 3 : ($item->score > 40 ? 2 : 1))),
        ];
    })->groupBy('semester');
    
    $gpaBySemester = [];
    $totalPoints = 0;
    $totalUnits = 0;
    
    foreach ($data as $semester => $results) {
        $sumUnits = 0;
        $semesterTotalPoints = 0;
    
        foreach ($results as $score) {
            $sumUnits += $score['unit'];
            $semesterTotalPoints += $score['unit'] * $score['point'];
        }
    
        $gpa = $sumUnits > 0 ? $semesterTotalPoints / $sumUnits : 0;
        $gpaBySemester[$semester] = $gpa;

        // Push GPA for each semester into the $data object
        foreach ($results as &$result) {
            $result['semester_gpa'] = $gpa;
        }
        unset($result); // Unset the reference variable to avoid potential bugs
        
        // Accumulate total points and total units for all semesters
        $totalPoints += $semesterTotalPoints;
        $totalUnits += $sumUnits;
    }
    // Calculate overall GPA
    $overallGPA = $totalUnits > 0 ? $totalPoints / $totalUnits : 0;

    // Now $data contains the GPA for each semester.
    $view = request('read') == 'print' ? 'exam.print' : 'exam.results';
    return view($view, [
        'data' => $data,
        'student' => User::where('uuid', $student)->first(),
        'studentID' => $studentID,
        'gpaBySemester' => $gpaBySemester, // Pass the GPA by semester to the view
        'gpa' => $overallGPA,
        'remark' => $overallGPA >= 2 ? 'Passed' : 'Failed'
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
            $body = 'We would like to inform you that the results of your student ' .ucwords($student->user->full_name ?? ""). ' have published. Please use the credentials below to log into your platform so that you can view results via API!';
            Mail::to($student->user->parent_email)->send(new SendToParent($title, $body));
        }
        return back()->withSuccess("Results successfully published");
    }

}
