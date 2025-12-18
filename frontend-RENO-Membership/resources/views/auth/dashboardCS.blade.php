@include('include.htmlstart')
@include('include.sideCS')

<div class="w-full sm:ml-64 mt-16 p-6">
    <main x-data="dashboardData()" x-init="fetchDashboard()" class="space-y-6">

        {{-- Greeting --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md transition-colors duration-300">
                <p class="font-bold text-gray-700 dark:text-gray-200"
                   x-text="greeting() + ', ' + (member?.name ?? 'CS') + '!'"></p>
                <p class="mt-2 text-gray-500 dark:text-gray-400" x-text="tanggalSekarang()"></p>
            </div>

            {{-- Statistic Cards --}}
            <div class="col-span-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <template x-for="stat in statsList" :key="stat.label">
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md transition-colors duration-300">
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400" x-text="stat.label"></p>
                        <h4 class="text-3xl font-semibold text-gray-800 dark:text-gray-100" x-text="stat.value.toLocaleString()"></h4>
                    </div>
                </template>
            </div>
        </div>

        {{-- Chart --}}
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md transition-colors duration-300">
            <div class="text-gray-700 dark:text-gray-200 font-semibold mb-2">Members Registered Per Month</div>
            <canvas id="memberChart" height="100"></canvas>
        </div>

        {{-- Loading/Error --}}
        <div x-show="loading" class="mt-4 text-gray-600 dark:text-gray-300">Memuat data...</div>
        <div x-show="error" class="mt-4 text-red-500" x-text="error"></div>
    </main>
</div>


<!-- CSS ONLY LOADING OVERLAY -->
<div 
  id="cssLoader"
  class="fixed inset-0 bg-black bg-opacity-50 
         flex items-center justify-center 
         z-[9999] opacity-100">

  <div class="w-14 h-14 border-4 border-gray-300 border-t-green-500 
              rounded-full animate-spin"></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const API_URL = "{{ api_url('/api/admin/dashboard') }}";

function dashboardData() {
    return {
        member: null,
        stats: { total_members: 0, total_transactions: 0 },
        monthlyChart: { months: [], members_registered: [] },
        chartInstance: null,
        loading: false,
        error: null,

        get statsList() {
            return [
                { label: 'TOTAL MEMBERS', value: this.stats.total_members },
                { label: 'TOTAL TRANSAKSI', value: this.stats.total_transactions }
            ];
        },

        fetchDashboard() {
            this.loading = true;
            this.error = null;
            showLoader(); // tampilkan overlay loading

            const token = localStorage.getItem("jwt_token_cs");
            if (!token) {
                hideLoader();
                return window.location.href = "/login";
            }

            fetch(API_URL, {
                headers: { 
                    "Authorization": "Bearer " + token, 
                    "Accept": "application/json" 
                }
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) throw new Error(data.message || "Gagal mengambil data");

                this.stats.total_members = data.data.total_members ?? 0;
                this.stats.total_transactions = data.data.total_transactions ?? 0;
                this.monthlyChart = data.data.chart ?? { months: [], members_registered: [] };

                this.renderChart();
            })
            .catch(err => {
                console.error(err);
                this.error = "Terjadi kesalahan: " + err.message;
                showToast(this.error, "error");
            })
            .finally(() => {
                this.loading = false;
                hideLoader(); // sembunyikan overlay
            });
        },

        renderChart() {
            const ctx = document.getElementById("memberChart").getContext("2d");
            if (this.chartInstance) this.chartInstance.destroy();

            const isDark = document.documentElement.classList.contains('dark');

            this.chartInstance = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: this.monthlyChart.months,
                    datasets: [{
                        label: "Members Registered",
                        data: this.monthlyChart.members_registered,
                        backgroundColor: "rgba(34,197,94,0.6)",
                        borderColor: "rgb(34,197,94)",
                        borderWidth: 2
                    }]
                },
                options: { 
                    responsive: true, 
                    plugins: {
                        legend: {
                            labels: { color: isDark ? "#e5e7eb" : "#374151" }
                        }
                    },
                    scales: { 
                        x: { ticks: { color: isDark ? "#e5e7eb" : "#374151" } },
                        y: { 
                            beginAtZero: true, 
                            ticks: { color: isDark ? "#e5e7eb" : "#374151" } 
                        } 
                    } 
                }
            });
        },

        greeting() {
            const hour = new Date().getHours();
            if (hour < 12) return "Selamat Pagi";
            if (hour < 18) return "Selamat Siang";
            return "Selamat Malam";
        },

        tanggalSekarang() {
            return new Date().toLocaleDateString("id-ID", { 
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' 
            });
        }
    }
}

// Loader helper
function showLoader() {
    const loader = document.getElementById("cssLoader");
    loader.style.display = "flex";
    loader.style.opacity = "1";
}

function hideLoader() {
    const loader = document.getElementById("cssLoader");
    loader.style.opacity = "0";
    setTimeout(() => loader.style.display = "none", 300);
}

// Toast helper
function showToast(msg, type="success") {
    const toast = document.getElementById("toast");
    toast.innerText = msg;
    toast.className = `
        fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-md z-50 text-gray-50 text-sm
        ${type === "success" ? "bg-green-600" : "bg-red-600"}
    `;
    toast.classList.remove("hidden");
    setTimeout(() => toast.classList.add("hidden"), 3000);
}
</script>

