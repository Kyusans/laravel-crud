<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
	public function index()
	{
		$students = Student::orderBy('name',"desc")->get();
		return view('student.index', compact('students'));
	}

	public function createStudent(Request $request)
	{
		$request->validate([
			'studentId' => "required",
			'name' => "required",
			'section' => "required",
			'email' => "required|email|unique:students,email",
			'age' => "required|numeric",
			'sex' => "required",
		]);

		$stmt = Student::create([
			'student_id' => $request["studentId"],
			'name' => $request["name"],
			'section' => $request["section"],
			'email' => $request["email"],
			'age' => $request["age"],
			'sex' => $request["sex"],
		]);

		return $stmt ? 1 : 0;
	}

	public function edit(int $id)
	{
		$studentData = Student::find($id);
		return view('student.edit', compact('studentData'));
	}

	public function updateStudent(Request $request, int $id)
	{
		$request->validate([
			'studentId' => "required",
			'name' => "required",
			'section' => "required",
			'email' => "required|email|unique:students,email, $id",
			'age' => "required|numeric",
			'sex' => "required",
		]);

		$stmt = Student::where('id', $id)->update([
			'student_id' => $request["studentId"],
			'name' => $request["name"],
			'section' => $request["section"],
			'email' => $request["email"],
			'age' => $request["age"],
			'sex' => $request["sex"],
		]);

		return $stmt ? 1 : 0;
	}

	public function deleteStudent(int $id)
	{
		$stmt = Student::where('id', $id)->delete();
		return $stmt ? 1 : 0;
	}
}
