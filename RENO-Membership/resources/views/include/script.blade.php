<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chart = window.LarapexCharts['{{ $chart->id }}'];

        function updateTextColor() {
            // Periksa apakah mode gelap aktif
            const isDarkMode = document.documentElement.classList.contains("dark");
            const color = isDarkMode ? '#FFFFFF' : '#000000'; // Putih untuk dark mode, hitam untuk light mode

            // Update warna teks pada chart
            chart.updateOptions({
                xaxis: {
                    labels: {
                        style: {
                            colors: #fffff
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: #fffff
                        }
                    }
                },
                title: {
                    style: {
                        color: #fffff
                    }
                },
                subtitle: {
                    style: {
                        color: #fffff
                    }
                }
            });
        }

        // Pantau perubahan mode gelap
        const observer = new MutationObserver(updateTextColor);
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        // Atur warna teks awal saat halaman dimuat
        updateTextColor();
    });
</script>
