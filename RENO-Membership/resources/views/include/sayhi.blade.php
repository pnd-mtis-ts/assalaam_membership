<script>
    function welcomeCard() {
        return {
            showMessage: false,
            greeting: '',
            init() {
                this.updateGreeting();
                setInterval(() => this.updateGreeting(), 60000); // Update setiap menit
            },
            updateGreeting() {
                const hour = new Date().getHours();
                if (hour >= 5 && hour < 12) {
                    this.greeting = 'Selamat pagi, ';
                } else if (hour >= 12 && hour < 15) {
                    this.greeting = 'Selamat siang, ';
                } else if (hour >= 15 && hour < 18) {
                    this.greeting = 'Selamat sore, ';
                } else {
                    this.greeting = 'Selamat malam, ';
                }
            }
        }
    }
</script>
