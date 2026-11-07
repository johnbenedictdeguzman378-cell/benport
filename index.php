x`
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information System</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f1f5f9;
        }

        header {
            background: #2563eb;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #0002;
        }

        h2 {
            text-align: center;
            color: #1e293b;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        button {
            background: #2563eb;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: #1d4ed8;
        }

        .student {
            background: #eff6ff;
            padding: 15px;
            margin-top: 12px;
            border-radius: 8px;
        }

        .student p {
            margin: 6px 0;
        }

        .delete {
            background: #ef4444;
            margin-top: 10px;
        }

        .delete:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>

<header>
    <h1>Student Information System</h1>
    <p>Simple Student Management Website</p>
</header>

<div class="container">
    <h2>Register Student</h2>

    <form id="studentForm">
        <input type="text" id="name"
               placeholder="Enter Student Name" required>

        <input type="text" id="studentId"
               placeholder="Enter Student ID" required>

        <select id="course" required>
            <option value="">Select Course</option>
            <option value="BSIT">BSIT</option>
            <option value="BSCS">BSCS</option>
            <option value="BSIS">BSIS</option>
        </select>

        <select id="year" required>
            <option value="">Select Year Level</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
        </select>

        <button type="submit">Add Student</button>
    </form>

    <h2>Registered Students</h2>
    <div id="studentList"></div>
</div>

<script>
    let students = JSON.parse(
        localStorage.getItem("students") || "[]"
    );

    const form = document.getElementById("studentForm");
    const list = document.getElementById("studentList");

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const name = document.getElementById("name").value.trim();
        const id = document.getElementById("studentId").value.trim();
        const course = document.getElementById("course").value;
        const year = document.getElementById("year").value;

        if (students.some(student => student.id === id)) {
            alert("Student ID already exists!");
            return;
        }

        students.push({ name, id, course, year });
        saveStudents();
        displayStudents();
        form.reset();

        alert("Student added successfully!");
    });

    function saveStudents() {
        localStorage.setItem("students", JSON.stringify(students));
    }

    function deleteStudent(index) {
        if (confirm("Delete this student?")) {
            students.splice(index, 1);
            saveStudents();
            displayStudents();
        }
    }

    function displayStudents() {
        list.innerHTML = "";

        if (students.length === 0) {
            list.textContent = "No students registered yet.";
            return;
        }

        students.forEach((student, index) => {
            const card = document.createElement("div");
            card.className = "student";

            const details = [
                ["Name", student.name],
                ["Student ID", student.id],
                ["Course", student.course],
                ["Year Level", student.year]
            ];

            details.forEach(([label, value]) => {
                const p = document.createElement("p");
                const strong = document.createElement("strong");
                strong.textContent = label + ": ";
                p.append(strong, document.createTextNode(value));
                card.appendChild(p);
            });

            const button = document.createElement("button");
            button.className = "delete";
            button.textContent = "Delete";
            button.addEventListener("click", () => {
                deleteStudent(index);
            });

            card.appendChild(button);
            list.appendChild(card);
        });
    }

    displayStudents();
</script>

</body>
</html>
