function showEditForm() {
    $('#edit-form').show();
}

function cancelEditForm() {
    $('#edit-form').hide();
}

function logout() {
    window.location.href = 'logout.php';
}

var ctx = document.getElementById('chart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Electricity Usage',
            data: data,
            backgroundColor: '#4F46E5',
            borderColor: '#4F46E5',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});



/*----Barkah Herdyanto Sejato -----*/