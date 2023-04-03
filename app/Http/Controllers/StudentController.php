<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == "Student") {
            $students = Student::where('email', Auth::user()->email);
        } elseif(Auth::user()->role == "Sponsor") {
            $students = Student::where('sponsor', '=' , Auth::user()->id)->orWhereNull('sponsor')->get();
        }else{
            $students = Student::all();
        }

        if ($request->ajax()) {
            $student = datatables()::of($students)
            ->editColumn('sponsor', function ($student) {
                $sponsor = User::where('id','=',$student->sponsor)->get();
                if(!empty($sponsor[0]))
                {
                return $sponsor[0]['first_name']." ".$sponsor[0]['last_name'];
                }
                else
                {
                   return ('Not Sponsored Yet');
                }
            })
                ->rawColumns(['action'])
                ->make(true);
            return $student;
        }
        // return response()->json([
        //     'articles' => $articles,
        // ]);
        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'ds' => 'required',
            'gs' => 'required',
            'district' => 'required',
            'email' => 'required',
            // 'postal' => 'required',
            'province' => 'required',
            'student_level' => 'required',
            'reason' => 'required',
            'doc.*' => 'file|mimes:csv,txt,xlx,xls,pdf,png,jpg,jpeg'

        ]);

        if ($validator->fails()) {
            return redirect('/student')
                ->withErrors($validator);
        } else {
            $student = new Student();
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->email = $request->email;
            $student->dob = $request->dob;
            $student->phone = $request->phone;
            $student->address = $request->address;
            $student->ds = $request->ds;
            $student->gs = $request->gs;
            $student->district = $request->district;
            $student->province = $request->province;
            $student->student_level = $request->student_level;
            $student->reason = $request->reason;
            $student->postal = $request->postal;
            $student->needs = $request->needs;
            $student->status = "Requested";
            $student->save();

            $student_id = $student->id;
            if ($request->hasfile('doc')) {
                foreach ($request->file('doc') as $key => $file) {
                    $path = $file->store('public/documents');
                    $name = $file->getClientOriginalName();

                    $insert[$key]['name'] = $name;
                    $insert[$key]['path'] = $path;
                    $insert[$key]['student_id'] = $student_id;
                }


            Document::insert($insert);
            }
            return redirect('/student')
            ->with('success', 'Request Submitted successfully');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student,$id)
    {
        $student = Student::where('id',$id)
        ->with('document')->get();
        // $document = Document::where('student_id','=',$id)->first();
        return $student[0];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    public function getStudentDocument(Request $request)
    {
        $path = storage_path('app/' . $request->path);
        return response()->file($path);
    }

    public function accept(Request $request)
    {
        // return $request->id;
        $student = Student::find($request->id);
        $student->status = "Accepted";
        $student->sponsor = Auth::user()->id;
        $student->update();
    }

}
