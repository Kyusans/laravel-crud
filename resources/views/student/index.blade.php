@extends("main-layout")

@section("content")
  <form id="studentForm">
    @csrf
    <input type="text" id="name" placeholder="Name" /> <br />
    <input type="text" id="studentId" placeholder="Student Id" /> <br />
    <input type="text" id="section" placeholder="Section" /> <br />
    <input type="text" id="email" placeholder="Email" /> <br />
    <input type="text" id="age" placeholder="Age" /> <br />
    <input type="text" id="sex" placeholder="Sex" /> <br />
    <button type="submit">Submit</button>
  </form>

  <div>
    <h1>Student List</h1>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Student Id</th>
          <th>Name</th>
          <th>Section</th>
          <th>Email</th>
          <th>Age</th>
          <th>Sex</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($students as $student)
          <tr>
            <td>{{ $student->student_id }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->section }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->age }}</td>
            <td>{{ $student->sex }}</td>
            <td>
              <a href="{{ route("student.edit", $student->id) }}" class="btn btn-primary">Edit</a>
              <button onclick="handleDelete({{ $student->id }})" class="btn btn-danger">Delete</button>
            </td>
          </tr>
        @endforeach

      </tbody>
  </div>

  <script>

    const studentForm = document.getElementById("studentForm");

    studentForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const name = document.getElementById("name").value;
      const studentId = document.getElementById("studentId").value;
      const section = document.getElementById("section").value;
      const email = document.getElementById("email").value;
      const age = document.getElementById("age").value;
      const sex = document.getElementById("sex").value;

      const jsonData = {
        name: name,
        studentId: studentId,
        section: section,
        email: email,
        age: age,
        sex: sex
      }

      const response = await fetch("{{ route('student.save') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },

        body: JSON.stringify(jsonData)
      })
      const res = await response.json();
      console.log("response", res);
      alert(res === 1 ? "success" : "failed");
      if(res === 1) {
        window.location.reload();
      }
    })
    
    const handleDelete = async (id) => {
      console.log("id", id);
      if (confirm("Are you sure you want to delete this?")) {
        const response = await fetch(`/student/delete/${id}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          }
        });

        const res = await response.json();
        if (res === 1) {
          alert("success");
          window.location.reload();
        } else {
          alert("failed");
        }
      }
    }
  </script>
@endsection