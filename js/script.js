function loadStudents() {
    $.ajax({
        url: 'api.php',
        type: 'GET',
        success: function(students) {
            var studentTableBody = $('#student-table-body');
            studentTableBody.empty();

            students.forEach(function(student) {
                var row = $('<tr>');
                row.append($('<td>').text(student.id));
                row.append($('<td>').text(student.name));
                row.append($('<td>').text(student.last_name));
                row.append($('<td>').text(student.age));
                row.append($('<td>').text(student.course));
                row.append($('<td>').text(student.email));
                studentTableBody.append(row);
            });
        }
    });
}

$(function() {
    loadStudents();

    $('#student-form').submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: 'api.php',
            type: 'POST',
            data: JSON.stringify({
                name: $('#name').val(),
                last_name: $('#last_name').val(),
                age: $('#age').val(),
                course: $('#course').val(),
                email: $('#email').val()
            }),
            contentType: 'application/json',
            success: function(response) {
                alert(response.message);
                $('#student-form')[0].reset();
                loadStudents();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while creating the student');
            }
        });
    });
});