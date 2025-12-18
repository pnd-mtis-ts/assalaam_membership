@include('include.htmlstart')
@include('include.sidemember')
@include('include.sayhi')
<!-- ======= BELUM VERIFIKASI EMAIL ======= -->

  
<!-- ======= BELUM MEMBER ======= -->
<div id="noMemberNotice" 
     class="hidden w-full sm:ml-64 min-h-screen flex items-center justify-center 
            bg-gray-50 dark:bg-gray-950 px-4 transition-colors">
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
            bg-gray-50 dark:bg-gray-950 px-4 transition-colors">
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
</style>



<!-- ======= MEMBER DASHBOARD ======= -->
<div id="dashboardContent"  class="hidden w-full sm:ml-64 overflow-auto bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors">
<div class="mt-24 px-4 sm:px-6 md:px-8 ">
  <!-- ======= Reminder Reward ======= -->
<div id="rewardReminder" 
     class="relative shadow-md flex flex-col justify-center 
             bg-green-100 dark:bg-gray-800 
             text-gray-700 dark:text-gray-100 
             overflow-hidden rounded-xl 
             border border-gray-300 dark:border-gray-700 
             p-4 sm:p-6 transition-colors">



  <!-- Title -->
  <h3 class="text-xl font-bold mb-1">Penukaran Poin & Kupon</h3>

  <!-- Message -->
  <p id="rewardMessage" class="text-base sm:text-lg font-medium mb-1"></p>

  <!-- Countdown -->
  <p id="rewardCountdown" class="font-semibold text-green-700 dark:text-green-300 mb-3"></p>
</div>

<!-- ======= Unverified Email Notice ======= -->
<div id="unverifiedEmailNotice" 
     class="hidden relative shadow-md flex flex-col justify-center 
             bg-gray-50 dark:bg-gray-950 
             text-gray-700 dark:text-gray-100 
             overflow-hidden rounded-xl 
             border border-gray-300 dark:border-gray-700 
             p-4 sm:p-6 transition-colors ">
  <div class="flex justify-center ">
    <ion-icon name="mail-unread-outline" class="text-4xl text-yellow-500"></ion-icon>
  </div>
  <h2 class="text-xl font-bold mb-2">Email Belum Terverifikasi</h2>
  <p class="text-sm mb-3">
    Silakan periksa kotak masuk email kamu untuk melakukan verifikasi akun sebelum mengakses dashboard member.
  </p>
  <button id="resendVerifyBtn"
     class="inline-block bg-yellow-500 hover:bg-yellow-600 text-gray-50 text-sm font-medium 
            px-5 py-2 rounded-lg transition-all shadow">
    Kirim Ulang Email Verifikasi
  </button>
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
               bg-gray-50 dark:bg-gray-950 
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
               bg-gray-50 dark:bg-gray-950 
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
               bg-gray-50 dark:bg-gray-950 
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
              bg-gray-50 dark:bg-gray-900 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-4 transition">
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
  class="bg-gray-50 dark:bg-gray-950 rounded-xl shadow-md
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
         rounded-xl bg-gray-50 dark:bg-gray-950 
         shadow-md border border-gray-300 dark:border-gray-700 
         transition-colors
         w-full max-w-[1200px] mx-auto
         hidden md:block"> <!-- ⬅️ ubah sm:block jadi md:block -->

  <h2 class="text-center text-lg font-semibold text-gray-800 dark:text-gray-100 
             border-b border-gray-300 dark:border-gray-700 pb-3">
    Riwayat Transaksi
  </h2>

  <div class="overflow-x-auto mt-3 w-full">
    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-100">
      <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
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
         bg-gray-50 dark:bg-gray-950 
         rounded-xl shadow-md border border-gray-300 dark:!border-gray-700 transition-colors w-full">
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
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-all"
     onclick="if(event.target.id==='modalAllTransactions'){this.classList.add('hidden');}">
  <div class="relative bg-gray-50 dark:bg-gray-950 border border-gray-300 dark:border-gray-700 rounded-xl shadow-xl w-11/12 md:w-3/4 lg:w-1/2 max-h-[80vh] overflow-y-auto">
    <div class="flex justify-between items-center border-b border-gray-300 dark:border-gray-700 p-4">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Semua Transaksi</h3>
      <button id="closeModalBtn" class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 text-xl font-bold">&times;</button>
    </div>
    <div id="allTransactionsList" class="p-4 space-y-3 text-gray-700 dark:text-gray-100">
      <p class="text-center text-gray-500 dark:text-gray-400">Memuat data...</p>
    </div>
  </div>
</div>