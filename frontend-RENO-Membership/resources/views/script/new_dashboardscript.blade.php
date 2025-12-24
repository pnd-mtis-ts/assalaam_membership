
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
