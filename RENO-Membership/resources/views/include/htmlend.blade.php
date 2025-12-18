
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
    integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
    integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to close alert
        function closeAlert(element) {
            element.classList.add('opacity-0');
            setTimeout(() => {
                element.style.display = 'none';
            }, 300);
        }

        // Auto dismiss after 5 seconds
        const alert = document.getElementById('alert');
        if (alert) {
            // Add transition class
            alert.classList.add('transition-opacity', 'duration-300');

            // Auto dismiss
            setTimeout(() => {
                closeAlert(alert);
            }, 10000);

            // Manual close button
            const closeButton = alert.querySelector('[data-dismiss-target="#alert"]');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    closeAlert(alert);
                });
            }
        }
    });

    function openEditModal(button) {
        // Get the ID from the data attribute
        const memberId = button.getAttribute('data-member-id');

        // Set the ID in a hidden input or data attribute of the modal
        document.getElementById('editMemberId').value = memberId;

        // Show the modal
        edit_member.showModal();
    }
</script>

</html>