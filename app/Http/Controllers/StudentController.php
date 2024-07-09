<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * This method is used to save a new student
     * 
     * @param name
     * @param subject
     * @param mark
     * 
     * @return json
     */
    public function save()
    {
        $validate = validator()->make(request()->all(), [
            'name' => 'bail|required',
            'subject' => 'bail|required',
            'mark' => 'bail|required|numeric'
        ])->errors();

        if ($validate->any()) {
            return response()->json([
                'status' => 'validation_failed',
                'message' => $validate->first()
            ], 422);
        }

        try {
            //If already a student exists with same name and subject name then update his/her marks previous mark with the new mark
            $check_duplicate = Student::select('id', 'marks')->where('name', request('name'))->where('subject', request('subject'))->first();

            if($check_duplicate) {
                $stu_id = $check_duplicate['id'];
                $stu_mark = $check_duplicate['marks'];
                $total_mark = request('mark') + $stu_mark;

                $update_student_mark = Student::findOrFail($stu_id);
                $update_student_mark->marks = $total_mark;
                $update_student_mark->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Student mark updated successfully'
                ], 200); //If mark is updated then throw response message as mark updated
            }
            else {
                $new_student = new Student();
                $new_student->name = request('name');
                $new_student->subject = request('subject');
                $new_student->marks = request('mark');
                $new_student->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Student created successfully'
                ], 200); // If new student in inserted throw a new record has inserted
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * This method is used to get list of students based on ascending order of the name
     * 
     * @return json
     */
    public function get()
    {
        $student_list = Student::select('id', 'name', 'subject', 'marks')->orderBy('name')->get();

        if($student_list) {
            return response()->json($student_list, 200);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No students found'
            ], 404);
        }
    }


    /**
     * This method is used to delete a student
     * 
     * @param student_id (id of which the student is going to be deleted)
     * 
     * @return json
     */
    public function destroy()
    {
        $student = Student::findOrFail(request('student_id'));
        $student->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Student deleted successfully'
        ]);
    }


    /**
     * This method is used to get student details of a specific student
     * 
     * @param id (id of the student)
     * 
     * @return json
     */
    public function edit($id)
    {
        $student_detail = Student::select('id', 'name', 'subject', 'marks')->where('id', $id)->first();
        return response()->json($student_detail);
    }


    /**
     * This method is used to update a student detail
     * 
     * @param name
     * @param subject
     * @param marks
     * 
     * @return json
     */
    public function update($id)
    {
        $validate = validator()->make(request()->all(), [
            'name' => 'bail|required',
            'subject' => 'bail|required',
            'marks' => 'bail|required|numeric'
        ])->errors();

        if ($validate->any()) {
            return response()->json([
                'status' => 'validation_failed',
                'message' => $validate->first()
            ], 422);
        }

        try {
            $update_student = Student::findOrFail($id);
            $update_student->name = request('name');
            $update_student->subject = request('subject');
            $update_student->marks = request('marks');
            $update_student->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'There was an error occurred, Please try again'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Student details updated successfully'
        ], 200);
    }
}
