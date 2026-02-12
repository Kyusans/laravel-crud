<?php

use Livewire\Component;
use App\Models\Student;

new class extends Component {
  public string $title = '';
  public string $content = '';

  // student form
  public int $id = 0;
  public string $student_id = '';
  public string $name = '';
  public string $section = '';
  public string $email = '';
  public string $age = '';
  public string $sex = '';

  public bool $isEdit = false;

  public function setStudent($id, $student_id, $name, $section, $email, $age, $sex)
  {
    $this->id = $id;
    $this->student_id = $student_id;
    $this->name = $name;
    $this->section = $section;
    $this->email = $email;
    $this->age = $age;
    $this->sex = $sex;
  }

  public string $search = "";
  public $students = [];

  public function render()
  {
    $allStudents = Student::where("name", "LIKE", "%$this->search%")->get();
    // echo $allStudents;
    // die();
    $this->students = $allStudents;
    return $this->view();
  }

  public function save()
  {
    $this->validate([
      "student_id" => "required",
      "name" => "required",
      "section" => "required",
      "email" => "required|email|" . ($this->isEdit ? "unique:students,email," . $this->id : "unique:students,email"),
      "age" => "required|numeric",
      "sex" => "required"
    ]);

    Student::updateOrCreate(
      ["id" => $this->id],
      [
        'student_id' => $this->student_id,
        'name' => $this->name,
        'section' => $this->section,
        'email' => $this->email,
        'age' => $this->age,
        'sex' => $this->sex,
      ]
    );

    session()->flash('success', 'Post created successfully.');
    $this->reset();
    $this->isEdit = false;
    // dd($this->title, $this->content);
  }

  public function delete($id)
  {
    $post = Student::find($id);
    $post->delete();
  }

  public function handleEditStudent($data)
  {
    $this->isEdit = true;
    $this->setStudent(
      $data["id"],
      $data["student_id"],
      $data["name"],
      $data["section"],
      $data["email"],
      $data["age"],
      $data["sex"]
    );
  }
};
?>

<div class="container mt-3">
  <form wire:submit="save" class="card" style="width: 18rem;">
    <div class="card-body">
      <div class="form-floating mb-3">
        <input wire:model="student_id" type="text" class="form-control" placeholder="Student Id">
        @error("studentId") <span class="text-danger">{{ $message }}</span> @enderror
        <label>Student Id</label>
      </div>
      <div class="form-floating mb-3">
        <input wire:model="name" type="text" class="form-control" placeholder="Name">
        @error("name")<span class="text-danger">{{ $message }}</span>@enderror
        <label>Name</label>
      </div>
      <div class="form-floating mb-3">
        <input wire:model="section" type="text" class="form-control" placeholder="Section">
        @error("section")<span class="text-danger">{{ $message }}</span> @enderror
        <label>Section</label>
      </div>
      <div class="form-floating mb-3">
        <input wire:model="email" type="text" class="form-control" placeholder="Email">
        @error("email")<span class="text-danger">{{ $message }}</span> @enderror
        <label>Email</label>
      </div>
      <div class="form-floating mb-3">
        <input wire:model="age" type="text" class="form-control" placeholder="Age">
        @error("age")<span class="text-danger">{{ $message }}</span> @enderror
        <label>Age</label>
      </div>
      <div class="form-floating mb-3">
        <input wire:model="sex" type="text" class="form-control" placeholder="Sex">
        @error("sex")<span class="text-danger">{{ $message }}</span> @enderror
        <label>Sex</label>
      </div>
      <button type="submit" class="btn btn-outline-light">Submit</button>
    </div>

  </form>
  <hr />
  <div class="mt-3">
    <div class="w-25">
      <input type="search" class="form-control" wire:model.live="search" placeholder="Search..." />
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Student Id</th>
          <th>Name</th>
          <th>Section</th>
          <th>Email</th>
          <th>Age</th>
          <th>Sex</th>
        </tr>
      </thead>
      <tbody>
        @if ($students->isEmpty())
          <tr>
            <td colspan="6" class="text-center">No data found</td>
          </tr>
        @else
          @foreach ($students as $item) <tr>
              <td>{{ $item->student_id }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->section }}</td>
              <td>{{ $item->email }}</td>
              <td>{{ $item->age }}</td>
              <td>{{ $item->sex }}</td>
              <td class="space-x-2">
                <button wire:click="handleEditStudent({{ $item }})" class="btn btn-outline-primary">Edit</button>
                <button wire:click=" delete({{ $item->id }})"
                  wire:confirm="Are you sure you want to delete {{ $item->title }}?"
                  class="btn btn-outline-danger">Delete</button>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
</div>