/* Fungsi untuk merubah warna navbar ketika di scroll */

window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 0) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });


  AOS.init();


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

/* modal form */
    function showEditModal() {
        var modal = document.getElementById('edit-modal');
        modal.classList.remove('hidden');
    }

    function hideEditModal() {
        var modal = document.getElementById('edit-modal');
        modal.classList.add('hidden');
    }

    /* pembayaran */
    function redirectToPaymentPage() {
        window.location.href = '../pages/payment.php';
    }

    function printPaymentDetails() {
        // Cetak halaman
        window.print();
    
        // Kembali ke halaman user setelah 3 detik
        setTimeout(function() {
            window.location.href = 'user.php';
        }, 3000);
    }

    function showNotificationPopup() {
        var popup = document.getElementById('notification-popup');
        popup.style.display = 'block';
    }

    function hideNotificationPopup() {
        var popup = document.getElementById('notification-popup');
        popup.style.display = 'none';
    }


/*----Barkah Herdyanto Sejati -----*/