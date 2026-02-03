<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get("/", [StudentController::class, "index"])->name("student");
Route::post("/student/save", [StudentController::class, "createStudent"])->name("student.save");
Route::get("/student/get", [StudentController::class, "getStudent"])->name("student.get");
Route::get("/student/edit/{id}", [StudentController::class, "edit"])->name("student.edit");
Route::post("/student/update/{id}", [StudentController::class, "updateStudent"])->name("student.update");
Route::post("/student/delete/{id}", [StudentController::class, "deleteStudent"])->name("student.delete");
