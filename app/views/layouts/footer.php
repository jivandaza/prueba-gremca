<!-- Footer -->
<footer class="bg-light p-3 text-center">
    <div class="container">
        <p class="mb-0">Creado por Jivandaza &copy; <?= date('Y') ?></p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="public/assets/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="public/assets/js/sweetalert2.min.js"></script>
<!-- Flatpickr JS -->
<script src="public/assets/js/flatpickr.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializar Flatpickr
        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d",
            locale: "es",
            defaultDate: new Date(),
        });

        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('registrosTableBody');

        const originalRows = Array.from(tableBody.querySelectorAll('tr'));

        function filterRows() {
            const searchTerm = searchInput.value.toLowerCase().trim();

            originalRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const matchesSearch = Array.from(cells).some(cell => {
                    return cell.textContent.toLowerCase().includes(searchTerm);
                });

                row.style.display = matchesSearch ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterRows);

        const form = document.getElementById('laborForm');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            try {
                const url = '/prueba_gremca' + form.getAttribute('action');
                const methodFrm = form.getAttribute('method');

                console.log(url);

                const response = await fetch(url, {
                    method: methodFrm,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                });

                if (response.ok) {
                    const result = await response.json();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: result.message,
                    }).then(() => {
                        window.location.href = '/prueba_gremca';
                    });
                } else {
                    const error = await response.json();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message,
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error inesperado',
                    text: 'Ocurrió un problema al procesar la solicitud',
                });
            }
        });

        const btnDeleteList = document.querySelectorAll('.btn-delete');

        btnDeleteList.forEach((btn) => {
            btn.addEventListener('click', async function (e) {
                e.preventDefault();

                const url = '/prueba_gremca' +  btn.getAttribute('href');

                try {
                    const response = await fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    });

                    if (response.ok) {
                        const result = await response.json();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: result.message,
                        }).then(() => {
                            window.location.href = '/prueba_gremca';
                        });;
                    } else {
                        const error = await response.json();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message,
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error inesperado',
                        text: 'Ocurrió un problema al procesar la solicitud',
                    });
                }
            });
        });
    });
</script>
</body>
</html>
