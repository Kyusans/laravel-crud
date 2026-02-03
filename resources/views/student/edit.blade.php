@extends("main-layout")

@section("content")
  {{-- Student Id: {{ $studentId }} --}}

  <form id="studentForm">
    @csrf
    <input type="text" id="name" placeholder="Name" value="{{ $studentData->name }}" /> <br />
    <input type="text" id="studentId" placeholder="Student Id" value="{{ $studentData->student_id }}" /> <br />
    <input type="text" id="section" placeholder="Section" value="{{ $studentData->section }}" /> <br />
    <input type="text" id="email" placeholder="Email" value="{{ $studentData->email }}" /> <br />
    <input type="text" id="age" placeholder="Age" value="{{ $studentData->age }}" /> <br />
    <input type="text" id="sex" placeholder="Sex" value="{{ $studentData->sex }}" /> <br />
    <button type="submit">Submit</button>
  </form>

  <script>
    document.getElementById("studentForm").addEventListener("submit", async (e) => {
      try {
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

        const response = await fetch("{{ route('student.update', ['id' => $studentData->id]) }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify(jsonData)
        })

        const res = await response.json();
        console.log(res);
        alert(res === 1 ? "Success" : "Failed");
        if (res === 1) {
          window.location.href = "{{ route('student') }}";
        }
      } catch (error) {
        console.log(error);
      }
    })
  </script>
@endsection