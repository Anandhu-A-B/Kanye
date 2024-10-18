document.getElementById('exerciseForm').addEventListener('submit', function (e) {
    const squatWeight = document.getElementById('squat_weight').value;
    const benchWeight = document.getElementById('bench_weight').value;
    const rowWeight = document.getElementById('row_weight').value;

    if (squatWeight <= 0 || benchWeight <= 0 || rowWeight <= 0) {
        alert('Weight must be greater than 0 for all exercises.');
        e.preventDefault();
