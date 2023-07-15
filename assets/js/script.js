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
        window.location.href = '../pages/payment';
    }

    function printPaymentDetails() {
        // Cetak halaman
        window.print();
    
        // Kembali ke halaman user setelah 3 detik
        setTimeout(function() {
            window.location.href = '../pages/user';
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

    //dropdown

  // Toggle tampilan dropdown
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    }

    // Menutup dropdown saat mengklik di luar dropdown
    window.addEventListener('click', (event) => {
        const dropdownMenu = document.getElementById('dropdownMenu');
        if (!event.target.matches('.dropdown') && !event.target.matches('.dropdown *')) {
        dropdownMenu.classList.add('hidden');
        }
    });

    // Toggle form display
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const registerBtn = document.getElementById('register-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    registerBtn.addEventListener('click', function() {
        loginForm.classList.add('hidden');
        registerForm.classList.remove('hidden');
    });

    cancelBtn.addEventListener('click', function() {
        loginForm.classList.remove('hidden');
        registerForm.classList.add('hidden');
    });

    function swapCards(selectedIndex) {
        const stackedCards = document.getElementById('stackedCards');
        const cards = stackedCards.getElementsByClassName('card3');
        const descriptionContainer = document.getElementById('descriptionContainer');
      
        if (cards.length !== 2) return; // Ensure there are exactly two cards
      
        // Swap the position of the clicked card in the DOM
        stackedCards.insertBefore(cards[selectedIndex], cards[0]);
      
        // Update the description based on the clicked card's information
        const selectedCard = cards[0];
        const selectedTitle = selectedCard.querySelector('.card-title').innerText;
        const selectedDescription = selectedCard.querySelector('.card-description').innerText;
      
        document.getElementById('selectedTitle').innerText = selectedTitle;
        document.getElementById('selectedDescription').innerText = selectedDescription;
      }
      
      

/*----Barkah Herdyanto Sejati -----*/