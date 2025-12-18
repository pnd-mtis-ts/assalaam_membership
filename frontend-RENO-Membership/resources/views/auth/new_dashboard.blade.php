@include('include.htmlstart')
@include('include.sidemember')
@include('include.sayhi')


<!-- ======= BELUM MEMBER ======= -->
<div id="noMemberNotice"
     class="hidden w-full sm:ml-64 min-h-screen flex items-center justify-center
            bg-gray-50 dark:bg-gray-800 px-4 transition-colors">
  <div class="max-w-md w-full bg-green-50 border border-green-300 text-green-800 
              dark:bg-green-900 dark:text-green-100 dark:border-green-700 
              p-6 rounded-2xl shadow-lg text-center">
    <div class="flex justify-center mb-4">
      <ion-icon name="alert-circle-outline" class="text-4xl text-green-500"></ion-icon>
    </div>
    <h2 class="text-xl font-bold mb-2">Kamu Belum Menjadi Member ☕</h2>
    <p class="text-sm mb-5">
      Silakan isi formulir pendaftaran member untuk mendapatkan berbagai keuntungan spesial!
    </p>
    <a href="/form-member"
       class="inline-block bg-green-500 hover:bg-green-600 text-gray-50 text-sm font-medium 
              px-5 py-2 rounded-lg transition-all shadow">
      Isi Formulir Member
    </a>
  </div>
</div>


<!-- ======= PENDING MEMBER ======= -->
<div id="pendingMemberNotice" 
     class="hidden w-full sm:ml-64 min-h-screen flex items-center justify-center
            bg-gray-50 dark:bg-gray-800 px-4 transition-colors">
  <div class="max-w-md w-full bg-green-50 border border-green-300 text-green-800 
              dark:bg-green-900 dark:text-green-100 dark:border-green-700 
              p-6 rounded-2xl shadow-lg text-center">
    <div class="flex justify-center mb-4">
  <ion-icon name="time-outline" class="text-4xl text-green-500 spin-clock"></ion-icon>
</div>

    <h2 class="text-xl font-bold mb-2">Member Kamu Masih Menunggu Validasi Nih!</h2>
    <p class="text-sm mb-5">Mohon menunggu atau bisa hubungi pihak CS ya ☕</p>

    <div class="bg-gray-50 dark:bg-900 text-left p-4 rounded-lg border border-gray-200 
                dark:border-gray-700 shadow-inner">
      <h3 class="font-semibold mb-2 text-gray-700 dark:text-gray-100">Informasi Member</h3>
      <p class="text-sm"><strong>Status:</strong> <span id="pendingStatus" class="text-yellow-600 font-bold "></span></p>
      <p class="text-sm"><strong>Nama:</strong> <span id="pendingName"></span></p>
      <p class="text-sm"><strong>Email:</strong> <span id="pendingEmail"></span></p>
    </div>
  </div>
</div>
<style>
/* Animasi jam berputar */
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.spin-clock {
  animation: spin 2s linear infinite;
  transform-origin: center;
}
/* Animasi fade-in */
.fade-in {
    animation: fadeIn 0.6s ease forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>

<!-- ======= EMAIL BELUM TERVALIDASI – OTP ======= -->
  <div id="unverifiedEmailNotice"
      class="hidden w-full sm:ml-64 min-h-screen flex items-center justify-center 
              bg-gray-50 dark:bg-gray-800 px-4 transition-colors">

    <div class="max-w-md w-full bg-white dark:bg-gray-900 shadow-md rounded-xl p-6">

      <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-3">
        Verifikasi Email
      </h2>

      <p class="text-gray-600 dark:text-gray-300 mb-4">
        Masukkan kode OTP yang dikirim ke email Anda.
      </p>

      <!-- OTP Input -->
      <input id="otpInput" 
            type="text" 
            maxlength="6"
            class="w-full p-3 border rounded-lg dark:bg-gray-800 dark:border-gray-700 text-center text-lg font-mono"
            placeholder="Masukkan kode OTP">

      <!-- Error Message -->
      <p id="otpMessage" class="text-red-500 text-sm mt-2 hidden"></p>


      <!-- Verify Button -->
      <button id="otpSubmitBtn"
              class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white p-3 rounded-lg font-medium">
        Verifikasi OTP
      </button>

      <!-- Timer -->
      <p id="otpTimer"
        class="text-center text-gray-500 dark:text-gray-400 text-sm mt-3 hidden"></p>

      <!-- Resend Button -->
      <button id="resendOtpBtn"
              class="w-full mt-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 
                    p-3 rounded-lg font-medium disabled:opacity-50 disabled:cursor-not-allowed"
              disabled>
        Kirim Ulang OTP
      </button>

    </div>
  </div>


<!-- ======= MEMBER DASHBOARD ======= -->
<div id="dashboardContent"  class="hidden w-full sm:ml-64 overflow-auto bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors">
<div class="mt-24 px-4 sm:px-6 md:px-8 ">
  <!-- ======= Reminder Reward ======= -->
<!-- Di bagian Reward Reminder (sekitar line 30-50) -->
<div id="rewardReminder" 
     class="hidden relative shadow-md flex flex-col justify-center 
            bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-900
            text-gray-700 dark:text-gray-100 
            overflow-hidden rounded-xl 
            border border-green-200 dark:border-gray-700 
            p-4 sm:p-6 transition-colors">

    <!-- Icon & Title -->
    <div class="flex items-center gap-3 mb-3">
        <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full">
            <ion-icon name="gift-outline" class="text-2xl text-green-600 dark:text-green-300"></ion-icon>
        </div>
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">
            Waktunya Tukar Poin! 🎁
        </h3>
    </div>

    <!-- Message dengan info minimal poin -->
    <div class="space-y-2">
        <p id="rewardMessage" class="text-base sm:text-lg font-medium"></p>
        
  

        <!-- Countdown -->
        <div class="flex items-center gap-2 mt-3">
            <ion-icon name="time-outline" class="text-lg text-green-600"></ion-icon>
            <p id="rewardCountdown" class="font-semibold text-green-700 dark:text-green-300"></p>
        </div>
    </div>
</div>

</div>
  <div class="mt-6 px-4 sm:px-6 md:px-8">
  <div class="grid sm:grid-cols-1 gap-4">
    <!-- ===== Greeting Card ===== -->
    <div
      class="relative shadow-md flex flex-col justify-center 
             bg-gray-50 dark:bg-gray-800 
             text-gray-700 dark:text-gray-100 
             overflow-hidden rounded-xl 
             border border-gray-300 dark:border-gray-700 
             p-4 sm:p-6 transition-colors"
    >
      <!-- Tanggal -->
      <p class="text-gray-600 text-base sm:text-lg md:text-xl dark:text-gray-400 mb-2" id="tanggalSekarang"></p>

      <!-- Greeting Text -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:flex-wrap gap-1 sm:gap-3">
  <div class="flex flex-wrap items-center gap-x-1 sm:gap-x-2">
    <!-- Greeting -->
    <span class="text-base sm:text-xl font-bold" id="greeting"></span>

    <!-- Nama User -->
    <p class="text-base sm:text-xl font-bold" id="userName"></p>

    <!-- Nomor Member -->
    <p
      id="noMember"
      class="text-sm sm:text-lg font-medium text-gray-600 dark:text-gray-400 
             mt-1 sm:mt-0 sm:ml-3"
    ></p>
  </div>


        <p class="text-base sm:text-lg font-medium ml-1 leading-snug">
          Silakan menikmati belanja di
          <span class="font-medium">
            Assalaam Hypermarket!
          </span>
        </p>
      </div>
    </div>
  </div>



    {{-- ================= 3 CARD INFO ================= --}}
    <div class="grid gap-4 mt-4 sm:grid-cols-3">
      <!-- Total Belanja -->
      <div
        class="relative shadow-md flex flex-row items-center justify-between 
               bg-gray-50 dark:bg-gray-800
               text-gray-900 dark:text-gray-100 
               border border-gray-300 dark:!border-gray-700 
               p-6 rounded-xl transition-colors">
        <div>
          <h5 class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400">Total Belanja</h5>
          <p class="text-2xl font-bold" id="totalBelanja">Rp 0</p>
        </div>
        <ion-icon name="bag-handle-sharp" class="text-4xl opacity-80"></ion-icon>
      </div>

      <!-- Total Poin -->
      <div
        class="relative shadow-md flex flex-row items-center justify-between 
               bg-gray-50 dark:bg-gray-800
               text-gray-900 dark:text-gray-100 
               border border-gray-300 dark:!border-gray-700 
               p-6 rounded-xl transition-colors">
        <div>
          <h5 class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400">Total Poin</h5>
          <p class="text-2xl font-bold" id="totalPoin">0</p>
        </div>
        <ion-icon name="star-outline" class="text-4xl opacity-80"></ion-icon>
      </div>

      <!-- Total Kupon -->
      <div
        class="relative shadow-md flex flex-row items-center justify-between 
               bg-gray-50 dark:bg-gray-800
               text-gray-900 dark:text-gray-100 
               border border-gray-300 dark:!border-gray-700 
               p-6 rounded-xl transition-colors">
        <div>
          <h5 class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400">Total Kupon</h5>
          <p class="text-2xl font-bold" id="totalKupon">0</p>
        </div>
        <ion-icon name="pricetag-outline" class="text-4xl opacity-80"></ion-icon>
      </div>
    </div>
  </div>

<!-- ===== GRID: Barcode + Grafik ===== -->
<div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4 mt-6 px-4 sm:px-6 md:px-8">

  
  
<div class="">

    
  <!-- Container tampilan -->
  <div id="displayArea"
       class="flex justify-center items-center w-full sm:w-[390px] min-h-[300px]
              bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-4 transition">
    <p class="text-gray-400">Pilih tampilan di bawah...</p>
  </div>

  <!-- Tombol pilihan -->
  <div class="flex justify-center mt-6 space-x-3 flex-wrap">
    <button id="btnBarcode"
            class="btn-choice bg-orange-500 hover:bg-orange-600 text-gray-50">
      <i class="fa-solid fa-barcode mr-2"></i> Barcode
    </button>
    <button id="btnQR"
            class="btn-choice bg-green-500 hover:bg-green-600 text-gray-50">
      <i class="fa-solid fa-qrcode mr-2"></i> QR Code
    </button>
    <button id="btnKartu"
            class="btn-choice bg-blue-500 hover:bg-blue-600 text-gray-50">
      <i class="fa-solid fa-id-card mr-2"></i> Kartu PAS
    </button>
  </div>
</div>

<!-- Modal Pop-up -->
<div id="popupModal"
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div id="popupContent"
       class="relative bg-gray-50 dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden transition transform scale-100">
  </div>
</div>

<!-- Styles for buttons -->
<style>
.btn-choice {
  @apply px-5 py-2 rounded-lg font-semibold transition-all shadow-md 
         hover:shadow-lg hover:scale-105 focus:ring-2 focus:ring-offset-2;
}
</style>

 <!-- ===== Grafik Belanja ===== -->
<div
  class="bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md
         border border-gray-300 dark:border-gray-700
         p-4 sm:p-6 transition-colors
         w-full h-[320px] sm:h-[350px]"
>
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
    <div>
      <h3 id="chartTitle" class="text-lg font-semibold text-gray-800 dark:text-gray-100">
        Grafik Transaksi Tahun <span id="tahunSekarang"></span>
      </h3>
      <p class="text-sm text-gray-500 dark:text-gray-400" id="chartDescription">
        Total belanja & poin kamu selama tahun berjalan
      </p>
    </div>
  </div>

  <canvas
    id="chart"
    class="w-full h-[250px] sm:h-[300px] overflow-x-auto overflow-y-hidden"
  >
    <div id="chart-inner" class="min-w-[320px] sm:min-w-full"></div>
</canvas>
</div>
</div>

<!-- ===== TABEL TRANSAKSI (DESKTOP / TABLET) ===== -->
<div
  class="p-4 sm:px-6 md:px-8 my-6 relative flex flex-col 
         rounded-xl bg-gray-50 dark:bg-gray-800 
         shadow-md border border-gray-300 dark:border-gray-700 
         transition-colors
         w-full max-w-[950px] mx-auto
         hidden md:block"> 

  <h2 class="text-center text-lg font-semibold text-gray-800 dark:text-gray-100 
             border-b border-gray-300 dark:border-gray-700 pb-3">
    Riwayat Transaksi
  </h2>

  <div class="overflow-x-auto mt-3 w-full">
    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-100">
      <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-50 border-b border-gray-300 dark:border-gray-700">
        <tr>
          <th class="px-6 py-3">No.</th>
          <th class="px-6 py-3">No. Transaksi</th>
          <th class="px-6 py-3">Tanggal</th>
          <th class="px-6 py-3">Total</th>
          <th class="px-6 py-3">Poin</th>
          <th class="px-6 py-3">Kupon</th>
        </tr>
      </thead>
      <tbody id="transactionBody" class="divide-y divide-gray-200 dark:divide-gray-700">
        <tr>
          <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">Loading...</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="flex justify-center mt-3">
    <button id="lihatSemuaBtn" class="text-blue-600 dark:text-blue-400 underline">
      Lihat Semua
    </button>
  </div>
</div>


  

  {{-- ================= TRANSAKSI MOBILE ================= --}}
<div
  class="p-4 sm:px-6 md:px-8 my-4 block md:hidden 
         bg-gray-50 dark:bg-gray-800
         rounded-xl shadow-md border border-gray-300 dark:border-gray-700 transition-colors w-full">
    <h2 class="text-center text-lg font-semibold text-gray-800 dark:text-gray-100 border-b border-gray-300 dark:!border-gray-700 pb-3">
      Riwayat Transaksi
    </h2>
    <div id="transactionListMobile" class="mt-3 space-y-3">
      <p class="text-center text-gray-500 dark:text-gray-400">Loading...</p>
    </div>
    <div class="flex justify-center mt-3">
      <button id="lihatSemuaBtnMobile" class="text-blue-600 dark:text-blue-400 underline">Lihat Semua</button>
    </div>
  </div>

 
</div>

{{-- ================= MODAL LIHAT SEMUA TRANSAKSI ================= --}}
<div id="modalAllTransactions" 
     class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50 p-2">
  <div class="bg-gray-50 dark:bg-gray-900 rounded-xl w-full sm:w-[90%] max-w-2xl flex flex-col max-h-screen">
    
    <!-- HEADER -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
      <h2 class="text-lg font-semibold">Semua Transaksi</h2>
      <button id="closeModalBtn" class="text-gray-600 dark:text-gray-300 hover:text-red-500 text-xl font-bold">✖</button>
    </div>

    <!-- CONTENT SCROLLABLE -->
    <div id="allTransactionsList" class="p-4 overflow-y-auto flex-1 space-y-2 max-h-[70vh] sm:max-h-[60vh]">
      <!-- transaksi akan dirender di sini -->
    </div>

    <!-- FOOTER PAGINATION -->
    <div id="paginationArea" class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-center gap-2 flex-wrap">
      <!-- tombol pagination akan dirender di sini -->
    </div>
  </div>
</div>


</div>
<style>
  #cssLoader {
    animation: hideLoader 1s ease forwards;
    animation-delay: 0.7s; /* lama loading di layar */
  }

  @keyframes hideLoader {
    to {
      opacity: 0;
      visibility: hidden;
    }
  }
</style>

<!-- CSS ONLY LOADING OVERLAY -->
<div 
  id="cssLoader"
  class="fixed inset-0 bg-black bg-opacity-50 
         flex items-center justify-center 
         z-[9999] opacity-100">

  <div class="w-14 h-14 border-4 border-gray-300 border-t-green-500 
              rounded-full animate-spin"></div>
</div>
<!-- POPUP OTP BERHASIL -->
<div id="otpSuccessPopup"
     class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-[9999]">
  <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl px-8 py-6 text-center animate-popup">
    <ion-icon name="checkmark-circle-outline" class="text-5xl text-green-500 mb-3"></ion-icon>
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Verifikasi Berhasil!</h3>
    <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">Email kamu sudah terverifikasi 🎉</p>
  </div>
</div>

<style>
@keyframes popupAnim {
  0% { transform: scale(0.7); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}
.animate-popup {
  animation: popupAnim 0.3s ease-out;
}
</style>



<!-- ===== DEPENDENCIES ===== -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<!-- ===== MAIN SCRIPT ===== -->
<script>
document.addEventListener("DOMContentLoaded", async () => {
    // ===== INIT / CONFIG =====
    const token = localStorage.getItem("jwt_token_user");
    if (!token) {
        // kalau tidak ada token, langsung ke login
        window.location.href = "/login";
        return;
    }
        if (!token) {
        history.replaceState(null, "", "/login");
        window.location.href = "/login";
    }

    // Store user email globally for OTP operations
    let userEmail = '';

    const api = {
        dashboard: "{{ api_url('/api/auth/dashboard') }}",
        barcode:  "{{ api_url('/api/auth/barcode') }}",
        qr:       "{{ api_url('/api/auth/qr') }}",
        semua:    "{{ api_url('/api/auth/semua') }}",
        verifyOtp:"{{ api_url('/api/email/verify-otp') }}",
        resendOtp:"{{ api_url('/api/email/resend-otp') }}",
        minimalPoin: "{{ api_url('/api/minimal-poin') }}"
    };

    const authHeaders = {
        headers: { Authorization: `Bearer ${token}` }
    };

    // Elements (safely grab them once)
    const el = {
        displayArea: document.getElementById("displayArea"),
        popupModal: document.getElementById("popupModal"),
        popupContent: document.getElementById("popupContent"),
        btnBarcode: document.getElementById("btnBarcode"),
        btnQR: document.getElementById("btnQR"),
        btnKartu: document.getElementById("btnKartu"),
        greeting: document.getElementById("greeting"),
        dashboardContent: document.getElementById("dashboardContent"),
        noMemberNotice: document.getElementById("noMemberNotice"),
        pendingNotice: document.getElementById("pendingMemberNotice"),
        unverifiedNotice: document.getElementById("unverifiedEmailNotice"),
        rewardReminder: document.getElementById("rewardReminder"),
        rewardMessage: document.getElementById("rewardMessage"),
        rewardCountdown: document.getElementById("rewardCountdown")
    };

    // Cache popup markup supaya tidak fetch ulang
    const popupCache = { qr: null, barcode: null, kartu: null };

    // Global trx array (supaya bisa diakses di modal/btn lain)
    let trx = [];

    // interval id untuk reward countdown supaya tidak duplikat
    let rewardIntervalId = null;

    // ===== EVENT BINDING (safely) =====
    if (el.btnBarcode) el.btnBarcode.addEventListener("click", loadBarcode);
    if (el.btnQR) el.btnQR.addEventListener("click", loadQR);
    if (el.btnKartu) el.btnKartu.addEventListener("click", loadKartuPas);
    if (el.popupModal) {
        el.popupModal.addEventListener("click", (e) => {
            if (e.target === el.popupModal) el.popupModal.classList.add("hidden");
        });
    }

    // ===== HELPERS =====
    const formatRupiah = (val) =>
        new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR", notation: "compact", maximumFractionDigits: 1 }).format(Number(val) || 0);

    const formatNumber = (val) =>
        new Intl.NumberFormat("id-ID", { maximumFractionDigits: 0 }).format(Number(val) || 0);

    const safeSetText = (id, text) => {
        const el = document.getElementById(id);
        if (el) el.textContent = text;
    };

    // parsing tanggal: support dd-mm-yyyy and ISO strings
    function parseAnyDate(str) {
        if (!str) return null;
        // if already Date object
        if (str instanceof Date) return str;
        // dd-mm-yyyy pattern
        const dmY = /^\s*(\d{1,2})-(\d{1,2})-(\d{4})\s*$/;
        const m = String(str).match(dmY);
        if (m) {
            const d = +m[1], mo = +m[2] - 1, y = +m[3];
            return new Date(y, mo, d);
        }
        // attempt Date constructor for ISO or other formats
        const d = new Date(str);
        return isNaN(d) ? null : d;
    }

    // ===== GREETING & TANGGAL =====
    if (el.greeting) {
        const hour = new Date().getHours();
        el.greeting.textContent = hour < 5 ? "Selamat Dini Hari 🌙" :
                                  hour < 12 ? "Selamat Pagi ☀️" :
                                  hour < 15 ? "Selamat Siang 🌤️" :
                                  hour < 18 ? "Selamat Sore 🌇" :
                                  "Selamat Malam 🌌";
    }

    const updateTanggal = () => {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const elTgl = document.getElementById("tanggalSekarang");
        if (elTgl) elTgl.textContent = now.toLocaleDateString('id-ID', options);
    };
    updateTanggal();

    // ======================================================================
    // REMINDER PENUKARAN POIN (LENGKAP) — perbaikan interval dan visibility
    // ======================================================================
    // ======================================================================
// REMINDER PENUKARAN POIN – dengan minimal poin dari API
// ======================================================================
let minimalPoinGlobal = 50; // default sebelum fetch dari API

async function updateRewardReminder(poinUser = 0) {
    const reminder = el.rewardReminder;
    const message = el.rewardMessage;
    const countdown = el.rewardCountdown;

    if (!reminder || !message || !countdown) return;

    // Fetch minimal poin dari API (hanya sekali)
    if (minimalPoinGlobal === 50) { // masih default
        try {
            const { data } = await axios.get(api.minimalPoin, authHeaders);
            minimalPoinGlobal = data.minimal_poin || 50;
        } catch (err) {
            console.warn("Gagal mengambil minimal poin, menggunakan default:", err);
        }
    }

    // Masa penukaran: 1 Desember – 31 Desember (tahun berjalan)
    const now = new Date();
    const startDate = new Date(now.getFullYear(), 11, 1); // 1 Desember
    const endDate = new Date(now.getFullYear(), 11, 31, 23, 59, 59); // 31 Desember

    // Sembunyikan kalau poin kurang dari minimal
    if ((Number(poinUser) || 0) < minimalPoinGlobal) {
        reminder.classList.add("hidden");
        if (rewardIntervalId) {
            clearInterval(rewardIntervalId);
            rewardIntervalId = null;
        }
        return;
    }

    // Jika belum mencapai 1 Desember atau sudah lewat 31 Desember -> hide
    if (now < startDate || now > endDate) {
        reminder.classList.add("hidden");
        if (rewardIntervalId) {
            clearInterval(rewardIntervalId);
            rewardIntervalId = null;
        }
        return;
    }

    // tampilkan reminder
    reminder.classList.remove("hidden");
    reminder.classList.add("fade-in");
    
    // Update message dengan minimal poin dari API
    message.textContent = `Segera tukarkan sebelum periode berakhir!`;

    // setup countdown
    if (rewardIntervalId) clearInterval(rewardIntervalId);
    
    function updateCountdown() {
        const diff = endDate - new Date();
        if (diff <= 0) {
            countdown.textContent = "Periode telah berakhir";
            clearInterval(rewardIntervalId);
            rewardIntervalId = null;
            return;
        }
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        countdown.textContent = `Sisa waktu: ${days} hari`;
    }
    
    updateCountdown();
    rewardIntervalId = setInterval(updateCountdown, 1000);
}

    function showOtpSuccessPopup() {
        const popup = document.getElementById("otpSuccessPopup");
        if (!popup) return;
        popup.classList.remove("hidden");
        setTimeout(() => popup.classList.add("hidden"), 2000);
    }

    // ======================================================================
    // POPUP UTIL
    // ======================================================================
    function showPopup(html) {
        if (!el.popupContent || !el.popupModal) return;
        el.popupContent.innerHTML = html;
        el.popupModal.classList.remove("hidden");
    }
    function resetPopup() {
        if (el.popupModal) el.popupModal.classList.add("hidden");
        // cache tetap disimpan supaya reusable
    }

    // ======================================================================
    // BARCODE
    // ======================================================================
    async function loadBarcode() {
        if (popupCache.barcode) return showPopup(popupCache.barcode);
        if (el.displayArea) el.displayArea.innerHTML = `<p class="text-gray-400">Memuat barcode...</p>`;
        try {
            const { data } = await axios.get(api.barcode, authHeaders);
            if (!data?.barcode) throw new Error("No barcode");
            const barcode = data.barcode;
            if (el.displayArea) el.displayArea.innerHTML = `<img src="${barcode}" class="max-w-[200px] mx-auto" alt="Barcode"/>`;
            const popupHtml = `<div class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg">
                <img src="${barcode}" class="w-[350px] h-auto object-contain" alt="Barcode"/>
            </div>`;
            popupCache.barcode = popupHtml;
            showPopup(popupHtml);
        } catch (err) {
            if (el.displayArea) el.displayArea.textContent = "Gagal memuat barcode";
            console.error("loadBarcode:", err);
        }
    }

    // ======================================================================
    // QR CODE
    // ======================================================================
    async function loadQR() {
        if (popupCache.qr) return showPopup(popupCache.qr);
        if (el.displayArea) el.displayArea.innerHTML = `<p class="text-gray-400">Memuat QR...</p>`;
        try {
            // expect HTML/SVG string
            const res = await axios.get(api.qr, { ...authHeaders, responseType: "text" });
            const data = res.data;
            if (!data) throw new Error("No QR");
            if (el.displayArea) el.displayArea.innerHTML = data;
            const popupHtml = `<div class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg flex justify-center">${data}</div>`;
            popupCache.qr = popupHtml;
            showPopup(popupHtml);
        } catch (err) {
            if (el.displayArea) el.displayArea.textContent = "Gagal memuat QR";
            console.error("loadQR:", err);
        }
    }

    // ======================================================================
    // KARTU PAS
    // ======================================================================
async function loadKartuPas() {
    if (popupCache.kartu) return showPopup(popupCache.kartu);
    if (el.displayArea) el.displayArea.innerHTML = `<p class="text-gray-400">Memuat Kartu PAS...</p>`;
    try {
        const [memberRes, barcodeRes] = await Promise.all([
            axios.get(api.dashboard, authHeaders),
            axios.get(api.barcode, authHeaders)
        ]);
        const member = memberRes.data?.member;
        const barcode = barcodeRes.data?.barcode;
        if (!member || !barcode) throw new Error("Missing data");

        const fullName = member.name || "";
        const memberNumber = member.no_member || ""; // pastikan API mengembalikan nomor member

   const cardSmall = `
    <div class="relative w-full max-w-[340px] aspect-[5/3] bg-cover bg-center rounded-xl shadow-md overflow-hidden mx-auto"
         style="background-image: url('/images/kartu_pas_template.png');">
        <!-- Nama (fullName) dengan teks lebih kecil -->
        <div class="absolute bottom-[43px] left-[74%] sm:bottom-[50px] sm:left-[73%] transform -translate-x-1/2 font-bold text-green-900 drop-shadow-md text-center"
            style="max-width: 90%; font-size: clamp(8px, 3vw, 14px); white-space: nowrap; overflow:hidden; text-overflow:ellipsis;">
            ${fullName}
        </div>
        
        <!-- Barcode -->
        <div class="absolute bottom-[17px] right-[10%] sm:bottom-[19px] sm:right-[11%] w-[30%] h-[16%] ">
            <img src="${barcode}" class="w-full h-auto object-contain" alt="Barcode"/>
        </div>
        
        <!-- Nomor Member (memberNumber) dengan teks lebih kecil -->
        <div class="absolute bottom-[20px] left-[75%] sm:left-[73%] sm:bottom-[23px] transform -translate-x-1/2 font-bold text-green-900 drop-shadow-md text-center"
            style="font-size: clamp(4px, 3vw, 10px);">
            ${memberNumber}
        </div>
    </div>
`;

const cardLarge = `
    <div class="relative w-[90vw] max-w-[650px] aspect-[5/3] bg-cover bg-center rounded-xl overflow-hidden mx-auto"
         style="background-image: url('/images/kartu_pas_template.png');">
         
        <div class="absolute bottom-[54px] sm:bottom-[104px] left-[74%] sm:left-[75%] transform -translate-x-1/2 text-xs sm:text-xl font-bold text-green-900 drop-shadow-md text-center" 
             style="max-width: 90%; white-space: nowrap; overflow:hidden; text-overflow:ellipsis;">
            ${fullName}<br/>
        </div>

        <div class="absolute bottom-[30px] right-[7%] sm:bottom-[57px] sm:right-[6%] w-[37%] h-[16%] flex items-center justify-center rounded-md p-2">
            <img src="${barcode}" class="w-full h-auto object-contain" alt="Barcode"/>
        </div>

        <div class="absolute bottom-[25px] left-[74%] sm:left-[75%] sm:bottom-[44px] transform -translate-x-1/2 text-[10px] sm:text-lg font-bold text-green-900 drop-shadow-md text-center">
            ${memberNumber}<br/>
        </div>

    </div>
`;

        if (el.displayArea) el.displayArea.innerHTML = cardSmall;
        popupCache.kartu = cardLarge;
        showPopup(cardLarge);

    } catch (err) {
        if (el.displayArea) el.displayArea.textContent = "Gagal memuat Kartu PAS";
        console.error("loadKartuPas:", err);
    }
}

    // ======================================================================
    // OTP FUNCTIONS
    // ======================================================================
    let otpCountdownInterval = null;

    function startOtpCountdown(duration = 60) {
        const resendBtn = document.getElementById("resendOtpBtn");
        const otpTimer = document.getElementById("otpTimer");
        if (!resendBtn || !otpTimer) return;

        resendBtn.disabled = true;
        otpTimer.classList.remove("hidden");

        let timeLeft = duration;
        otpTimer.textContent = `Kirim ulang dalam ${timeLeft}s`;

        if (otpCountdownInterval) clearInterval(otpCountdownInterval);
        otpCountdownInterval = setInterval(() => {
            timeLeft--;
            otpTimer.textContent = `Kirim ulang dalam ${timeLeft}s`;
            if (timeLeft <= 0) {
                clearInterval(otpCountdownInterval);
                otpCountdownInterval = null;
                otpTimer.classList.add("hidden");
                resendBtn.disabled = false;
            }
        }, 1000);
    }

    async function resendOtp() {
        const resendBtn = document.getElementById("resendOtpBtn");
        const otpMessage = document.getElementById("otpMessage");
        if (!resendBtn || !otpMessage) return;

        if (!userEmail) {
            otpMessage.textContent = "Email tidak ditemukan!";
            otpMessage.classList.remove("hidden");
            return;
        }

        otpMessage.textContent = "Mengirim OTP...";
        otpMessage.classList.remove("hidden");

        try {
            const { data } = await axios.post(api.resendOtp, { email: userEmail }, authHeaders);
            otpMessage.textContent = data.message || "OTP berhasil dikirim!";
            startOtpCountdown(60);
        } catch (err) {
            otpMessage.textContent = err.response?.data?.message || "Gagal mengirim OTP!";
            startOtpCountdown(60); // tetap start supaya tidak spam
            console.error("resendOtp:", err);
        }
    }

    // Pasang event listener kalau elemen ada (hindari double bind)
    const resendBtnEl = document.getElementById("resendOtpBtn");
    if (resendBtnEl) {
        resendBtnEl.removeEventListener?.("click", resendOtp); // safe-remove if supported
        resendBtnEl.addEventListener("click", resendOtp);
    }

    async function verifyOtp() {
        const verifyBtn = document.getElementById("otpSubmitBtn");
        const otpInput = document.getElementById("otpInput");
        const otpMessage = document.getElementById("otpMessage");
        if (!verifyBtn || !otpInput || !otpMessage) return;

        const otp = otpInput.value.trim();
        if (!otp) {
            otpMessage.textContent = "Masukkan kode OTP!";
            otpMessage.classList.remove("hidden", "fade-in");
            otpMessage.classList.add("fade-in");
            return;
        }
        if (!userEmail) {
            otpMessage.textContent = "Email tidak ditemukan!";
            otpMessage.classList.remove("hidden", "fade-in");
            otpMessage.classList.add("fade-in");
            return;
        }

        verifyBtn.disabled = true;
        const originalText = verifyBtn.textContent;
        verifyBtn.innerHTML = `<span class="animate-spin">⏳</span> Memverifikasi...`;
        otpMessage.classList.add("hidden");

        try {
            const { data } = await axios.post(api.verifyOtp, { email: userEmail, otp }, authHeaders);
            showOtpSuccessPopup();
            otpMessage.textContent = data.message || "Email berhasil diverifikasi!";
            otpMessage.classList.remove("hidden");
            otpMessage.classList.add("fade-in");
            // reload untuk sync state
            setTimeout(() => window.location.reload(), 1200);
        } catch (err) {
            otpMessage.textContent = err.response?.data?.message || "OTP salah atau gagal diverifikasi!";
            otpMessage.classList.remove("hidden");
            otpMessage.classList.add("fade-in");
            console.error("verifyOtp:", err);
        } finally {
            verifyBtn.disabled = false;
            verifyBtn.textContent = originalText;
        }
    }

    const verifyBtnEl = document.getElementById("otpSubmitBtn");
    if (verifyBtnEl) {
        verifyBtnEl.removeEventListener?.("click", verifyOtp);
        verifyBtnEl.addEventListener("click", verifyOtp);
    }

    // ======================================================================
    // FETCH DASHBOARD + RENDERING
    // ======================================================================
    try {
        const res = await axios.get(api.semua, authHeaders);
        const d = res.data || {};
        const user = d.user || {};
        const member = d.member || null;
        trx = Array.isArray(d.transactions) ? d.transactions : [];

        // Store user email
        userEmail = user.email || '';

        // hide semua dulu
        [el.dashboardContent, el.noMemberNotice, el.pendingNotice, el.unverifiedNotice]
            .forEach(x => x?.classList.add("hidden"));

        // cek verifikasi email
        if (!user.email_verified_at) {
            el.unverifiedNotice?.classList.remove("hidden");
            const emailDisplay = document.getElementById("userEmailDisplay");
            if (emailDisplay && userEmail) emailDisplay.textContent = userEmail;
            // mulai countdown untuk resend
            startOtpCountdown(60);
            return; // berhenti sampai user verifikasi
        }

        // cek status member
        if (!member || !member.status || member.status === "Belum menjadi member") {
            el.noMemberNotice?.classList.remove("hidden");
            return;
        }
        if (member.status === "Pending") {
            el.pendingNotice?.classList.remove("hidden");
            safeSetText("pendingStatus", member.status || "-");
            safeSetText("pendingName", member.name || "-");
            safeSetText("pendingEmail", member.email || "-");
            return;
        }
        if (member.status === "Aktif") {
            el.dashboardContent?.classList.remove("hidden");
        }

        // transaksi tahun berjalan (gunakan parseAnyDate)
        const currentYear = new Date().getFullYear();
        const trxTahunBerjalan = trx.filter(t => {
            const tanggalStr = t.created_at || t.date || t.date_created;
            const dObj = parseAnyDate(tanggalStr);
            return dObj ? dObj.getFullYear() === currentYear : false;
        });

        const totalPoin = trxTahunBerjalan.reduce((s, t) => s + (parseFloat(t.point) || 0), 0);
        const totalKupon = trxTahunBerjalan.reduce((s, t) => s + (parseFloat(t.coupon) || 0), 0);
        const totalBelanja = trxTahunBerjalan.reduce((s, t) => s + (parseFloat(t.amount) || 0), 0);

        // update reminder poin
        updateRewardReminder(totalPoin);

        // update UI text
        safeSetText("userName", member.name ? " " + member.name + "!" : "");
        safeSetText("noMember", member.no_member ? `Dengan Nomor Member: ${member.no_member}` : "Belum menjadi member");
        safeSetText("totalBelanja", formatRupiah(totalBelanja));
        safeSetText("totalPoin", formatNumber(totalPoin));
        safeSetText("totalKupon", formatNumber(totalKupon));

        // render
        renderTransactionsDesktop(trx);
        renderTransactionsMobile(trx);
        renderChart(trx);
        await renderAllTransactions(1, 10, trx);

    } catch (err) {
        console.error("Error dashboard:", err);
        if (err.response?.status === 401) {
            localStorage.removeItem("jwt_token_user");
            window.location.href = "/login";
        }
    }

    // ======================================================================
    // RENDER TRANSAKSI (desktop/mobile/all)
    // ======================================================================
    function renderTransactionsDesktop(trxData = []) {
        const tbody = document.getElementById("transactionBody");
        if (!tbody) return;
        const list = Array.isArray(trxData) ? trxData : [];
        tbody.innerHTML = list.length
            ? list.slice(0, 3).map((t, i) => {
                const date = t.date || t.created_at || '-';
                return `
                    <tr class="text-gray-950 dark:text-gray-50">
                        <td class="px-6 py-3">${i + 1}</td>
                        <td class="px-6 py-3">${t.id || '-'}</td>
                        <td class="px-6 py-3">${date}</td>
                        <td class="px-6 py-3">${formatRupiah(t.amount)}</td>
                        <td class="px-6 py-3">${formatNumber(t.point)}</td>
                        <td class="px-6 py-3">${formatNumber(t.coupon)}</td>
                    </tr>`;
            }).join("")
            : `<tr><td colspan="6" class="text-center py-4 text-gray-500">Belum ada transaksi</td></tr>`;
    }
    /* ============================================
   LOGOUT
===============================================*/
function logout() {
    localStorage.removeItem("jwt_token_admin");
    localStorage.removeItem("user_admin");

    localStorage.removeItem("jwt_token_cs");
    localStorage.removeItem("user_cs");

    localStorage.removeItem("jwt_token_user");
    localStorage.removeItem("user_user");

    window.location.href = "/login";
}


    function renderTransactionsMobile(trxData = []) {
        const container = document.getElementById("transactionListMobile");
        if (!container) return;
        const list = Array.isArray(trxData) ? trxData : [];
        container.innerHTML = list.length
            ? list.slice(0, 3).map((t, i) => {
                const date = t.date || t.created_at || '-';
                return `
                    <div class="p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 shadow-sm">
                        <p><b>No:</b> ${i + 1}</p>
                        <p><b>No. Transaksi:</b> ${t.id || '-'}</p>
                        <p><b>Tanggal:</b> ${date}</p>
                        <p><b>Total:</b> ${formatRupiah(t.amount)}</p>
                        <p><b>Poin:</b> ${formatNumber(t.point)}</p>
                        <p><b>Kupon:</b> ${formatNumber(t.coupon)}</p>
                    </div>`;
            }).join("")
            : `<p class="text-center text-gray-500">Belum ada transaksi</p>`;
    }

    async function renderAllTransactions(page = 1, perPage = 10, trxData = []) {
        const container = document.getElementById("allTransactionsList");
        if (!container) return;
        const list = Array.isArray(trxData) ? trxData : [];
        const totalItems = list.length;
        const totalPages = Math.max(Math.ceil(totalItems / perPage), 1);
        const startIndex = (page - 1) * perPage;
        const endIndex = startIndex + perPage;
        const pageItems = list.slice(startIndex, endIndex);

        container.innerHTML = pageItems.length
            ? pageItems.map((t, i) => {
                const date = t.date || t.created_at || '-';
                return `
                    <div class="p-3 border text-gray-950 dark:text-gray-50 rounded-lg bg-gray-50 dark:bg-gray-700 shadow-sm">
                        <p><b>No:</b> ${startIndex + i + 1}</p>
                        <p><b>No. Transaksi:</b> ${t.id || '-'}</p>
                        <p><b>Tanggal:</b> ${date}</p>
                        <p><b>Total:</b> ${formatRupiah(t.amount)}</p>
                        <p><b>Poin:</b> ${formatNumber(t.point)}</p>
                        <p><b>Kupon:</b> ${formatNumber(t.coupon)}</p>
                    </div>`;
            }).join("")
            : `<p class="text-center text-gray-500 dark:text-gray-400">Tidak ada transaksi</p>`;

        renderPagination(totalPages, page, list, perPage);
    }

    function renderPagination(totalPages, currentPage, trxData, perPage) {
        const paginationContainer = document.getElementById("paginationArea");
        if (!paginationContainer) return;
        paginationContainer.innerHTML = "";

        const prevBtn = document.createElement("button");
        prevBtn.textContent = "← Prev";
        prevBtn.disabled = currentPage === 1;
        prevBtn.className = `px-3 py-1 border rounded ${currentPage === 1 ? "opacity-50 cursor-not-allowed" : "cursor-pointer"}`;
        prevBtn.onclick = () => renderAllTransactions(currentPage - 1, perPage, trxData);
        paginationContainer.appendChild(prevBtn);

        for (let p = 1; p <= totalPages; p++) {
            const btn = document.createElement("button");
            btn.textContent = p;
            btn.className = `px-3 py-1 border rounded ${p === currentPage ? "bg-green-500 text-white" : "bg-gray-100 dark:bg-gray-600 cursor-pointer"}`;
            btn.onclick = () => renderAllTransactions(p, perPage, trxData);
            paginationContainer.appendChild(btn);
        }

        const nextBtn = document.createElement("button");
        nextBtn.textContent = "Next →";
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.className = `px-3 py-1 border rounded ${currentPage === totalPages ? "opacity-50 cursor-not-allowed" : "cursor-pointer"}`;
        nextBtn.onclick = () => renderAllTransactions(currentPage + 1, perPage, trxData);
        paginationContainer.appendChild(nextBtn);
    }

    // ======================================================================
    // CHART (Chart.js)
    // ======================================================================
    function renderChart(trxData = []) {
        if (!Array.isArray(trxData) || !trxData.length) return;
        const year = new Date().getFullYear();
        const elTahun = document.getElementById("tahunSekarang");
        if (elTahun) elTahun.textContent = year;

        // kumpulkan data per bulan
        const monthNames = ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];
        const monthMap = {};
        trxData.forEach(t => {
            const d = parseAnyDate(t.date || t.created_at);
            if (!d || d.getFullYear() !== year) return;
            const mName = monthNames[d.getMonth()];
            if (!monthMap[mName]) monthMap[mName] = { amount: 0, point: 0 };
            monthMap[mName].amount += parseFloat(t.amount) || 0;
            monthMap[mName].point += parseFloat(t.point) || 0;
        });

        const labels = monthNames.filter(m => monthMap[m]);
        if (!labels.length) return;
        const values = labels.map(m => monthMap[m].amount);
        const points = labels.map(m => monthMap[m].point);

        const ctxEl = document.getElementById("chart");
        if (!ctxEl) return;
        const ctx = ctxEl.getContext("2d");
        if (window.chartInstance) window.chartInstance.destroy();

        const isDark = document.documentElement.classList.contains("dark");

        window.chartInstance = new Chart(ctx, {
            type: "bar",
            data: {
                labels,
                datasets: [
                    {
                        label: "Belanja (Rp)",
                        data: values,
                        backgroundColor: "rgba(79,70,229,0.7)",
                        borderColor: "rgb(79,70,229)",
                        borderWidth: 1,
                        borderRadius: 6
                    },
                    {
                        label: "Poin",
                        data: points,
                        type: "line",
                        borderColor: "rgb(16,185,129)",
                        backgroundColor: "rgba(16,185,129,0.4)",
                        tension: 0.4,
                        yAxisID: "y1"
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: "index", intersect: false },
                scales: {
                    x: { ticks: { color: isDark ? "#e5e7eb" : "#374151" }, grid: { display: false } },
                    y: { ticks: { color: isDark ? "#e5e7eb" : "#374151", callback: (v) => formatRupiah(v) } },
                    y1: { position: "right", grid: { drawOnChartArea: false }, ticks: { color: isDark ? "#10b981" : "#065f46" } }
                }
            }
        });
    }

    // ======================================================================
    // MODAL ALL TRANSACTIONS BTN
    // ======================================================================
    const lihatSemuaBtn = document.getElementById("lihatSemuaBtn");
    if (lihatSemuaBtn) {
        lihatSemuaBtn.addEventListener("click", async () => {
            const modal = document.getElementById("modalAllTransactions");
            if (modal) modal.classList.remove("hidden");
            await renderAllTransactions(1, 10, trx);
        });
    }

    const lihatSemuaBtnMobile = document.getElementById("lihatSemuaBtnMobile");
    if (lihatSemuaBtnMobile) {
        lihatSemuaBtnMobile.addEventListener("click", async () => {
            const modal = document.getElementById("modalAllTransactions");
            if (modal) modal.classList.remove("hidden");
            await renderAllTransactions(1, 10, trx);
        });
    }

    const closeModalBtn = document.getElementById("closeModalBtn");
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", () => {
            const modal = document.getElementById("modalAllTransactions");
            if (modal) modal.classList.add("hidden");
        });
    }

}); // DOMContentLoaded
</script>
