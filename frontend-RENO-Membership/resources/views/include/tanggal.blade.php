<script>
    function tanggalSekarang() {
        return {
            tanggal: '',
            init() {
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const now = new Date();
                this.tanggal = now.toLocaleDateString('id-ID', options);
            }
        }
    }
</script>
