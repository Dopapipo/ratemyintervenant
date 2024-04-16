function showGradeMessage(value) {
    var message = document.getElementById('grade-message');
    var gradeValue = document.getElementById('grade-value');
    gradeValue.textContent = value;
    message.style.display = 'block';
}
