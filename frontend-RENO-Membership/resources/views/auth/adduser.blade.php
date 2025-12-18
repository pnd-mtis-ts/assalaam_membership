@include('include.htmlstart')
@include('include.sideCS')

<div class=" w-full sm:ml-64">
    <div class="min-h-screen py-12 mt-10 px-4 sm:px-4 lg:px-6">
        <div class="max-w-6xl mx-auto">
            <!-- Form Header -->
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Registrasi Member</h2>
                <p class="text-gray-600 dark:text-gray-400">Silakan isi semua informasi yang diperlukan di bawah ini</p>
            </div>

            <!-- Main Form Card -->
            <div class="card dark:bg-gray-700 rounded-2xl shadow-xl overflow-hidden">
                <!-- Progress Bar -->
                <div class="w-full bg-green-50 h-2">
                    <div
                        class="w-full h-full bg-gradient-to-r from-green-500 dark:from-[#F97300]  to-green-500/20 dark:to-[#F97300]/40">
                    </div>
                </div>

                 <form id="memberForm" class="p-8" autocomplete="off" autocapitalize="off" spellcheck="false">
    @csrf

    <!-- SECTION 1: PERSONAL AKUN -->
    <div class="mb-10">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
            <span class="bg-green-500 dark:bg-[#F97300] text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">1</span>
            Personal Akun
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Email -->
            <div class="relative group">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" placeholder="Masukan Email" autocomplete="off" autocorrect="off" autocapitalize="none"
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                </div>
            </div>

            <!-- Password -->
           <div class="relative group">
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
  <div class="relative">
    <input type="password" name="password" id="password"
      placeholder="Masukan Password" autocomplete="new-password"
      class="w-full px-4 py-3 pr-10 rounded-lg border-2 border-gray-200 focus:border-green-500 
             focus:ring focus:ring-green-200 transition-all duration-200 outline-none 
             dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white 
             dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
    <!-- Icon mata -->
    <button type="button" id="togglePassword"
      class="absolute inset-y-0 right-3 flex items-center text-gray-500 dark:text-gray-300">
      <ion-icon name="eye-outline" class="text-xl"></ion-icon>
    </button>
  </div>
</div>

            <!-- Konfirmasi Password -->
            <div class="relative group">
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password</label>
  <div class="relative">
    <input type="password" name="password_confirmation" id="password_confirmation"
      placeholder="Konfirmasi Password"
      class="w-full px-4 py-3 pr-10 rounded-lg border-2 border-gray-200 focus:border-green-500 
             focus:ring focus:ring-green-200 transition-all duration-200 outline-none 
             dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white 
             dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
    <!-- Icon mata -->
    <button type="button" id="toggleConfirmPassword"
      class="absolute inset-y-0 right-3 flex items-center text-gray-500 dark:text-gray-300">
      <ion-icon name="eye-outline" class="text-xl"></ion-icon>
    </button>
  </div>
</div>
        </div>
    </div>

    <!-- SECTION 2: PERSONAL INFORMATION -->
    <div class="mb-10">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
            <span class="bg-green-500 dark:bg-[#F97300] text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">2</span>
            Personal Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Nama -->
            <input type="text" name="MEMBER_NAME" id="MEMBER_NAME" placeholder="Masukan Nama Lengkap" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">

            <!-- Tanggal Lahir -->
            <input type="date" name="MEMBER_DATE_OF_BIRTH" id="MEMBER_DATE_OF_BIRTH" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">

            <!-- Tempat Lahir -->
            <input type="text" name="MEMBER_PLACE_OF_BIRTH" id="MEMBER_PLACE_OF_BIRTH" placeholder="Masukan Tempat Lahir" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-4 gap-6">
            <!-- No Identitas -->
            <!-- No Identitas -->
        <div class="flex flex-col">
            <input type="text" name="MEMBER_KTP_NO" id="MEMBER_KTP_NO" placeholder="Masukan NIK"
        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500
        focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800
        dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300]
        dark:focus:border-[#F97300]">

            <p id="error_nik" class="text-red-500 text-sm mt-1 hidden">
        NIK harus 16 digit.
            </p>
        </div>


            <!-- Status -->
            <select name="MEMBER_IS_MARRIED" id="MEMBER_IS_MARRIED" class="w-full select rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                <option value="">Pilih Status</option>
                <option value="0">Lajang</option>
                <option value="1">Menikah</option>
            </select>

            <!-- Agama -->
            <select name="REF$AGAMA_ID" id="REF$AGAMA_ID" class="w-full select rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                <option selected disabled>Pilih Agama</option>
                <option value="1">Islam</option>
                <option value="2">Kristen</option>
                <option value="3">Katolik</option>
                <option value="4">Budha</option>
                <option value="5">Hindu</option>
                <option value="6">Konghucu</option>
                <option value="7">Lain-lain</option>
            </select>

            <!-- Kewarganegaraan -->
            <select name="MEMBER_IS_WNI" id="MEMBER_IS_WNI" class="w-full select rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                <option selected disabled>Pilih Kewarganegaraan</option>
                <option value="1">WNI (Warga Negara Indonesia)</option>
                <option value="0">WNA (Warga Negara Asing)</option>
            </select>
        </div>
    </div>

    <!-- SECTION 3: KONTAK INFORMASI -->
    <div class="mb-10">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
            <span class="bg-green-400 dark:bg-[#EF6C00] text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">3</span>
            Kontak Informasi
        </h3>

        <div class="space-y-6">
            <input type="text" id="MEMBER_ADDRESS" name="MEMBER_ADDRESS" placeholder="Masukan Alamat Lengkap" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">

            <!-- RT / RW -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <input type="text" id="MEMBER_RT" name="MEMBER_RT" placeholder="Masukan RT" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                <input type="text" id="MEMBER_RW" name="MEMBER_RW" placeholder="Masukan RW" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                <input type="text" id="MEMBER_KELURAHAN" name="MEMBER_KELURAHAN" placeholder="Masukan Kelurahan" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
            </div>

            <input type="text" id="MEMBER_KECAMATAN" name="MEMBER_KECAMATAN" placeholder="Masukan Kecamatan" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
            <input type="text" id="MEMBER_KOTA" name="MEMBER_KOTA" placeholder="Masukan Kota" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
            <input type="text" id="MEMBER_POST_CODE" name="MEMBER_POST_CODE" placeholder="Masukan Kode Pos" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
           
        </div>
    </div>

    <!-- SECTION 4: INFORMASI TAMBAHAN -->
    <div class="mb-10">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
            <span class="bg-green-400/90 dark:bg-[#FFA726] text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">4</span>
            Informasi Tambahan
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex flex-col">
        <input type="text" id="MEMBER_TELP" name="MEMBER_TELP" placeholder="Masukan No. HP" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
        <p id="error_hp" class="text-red-500 text-sm mt-1 hidden">Nomor HP minimal 9 digit.</p>
        </div>

            <!-- Jumlah Tanggungan -->
        <input type="number" id="MEMBER_JML_TANGGUNGAN" name="MEMBER_JML_TANGGUNGAN" placeholder="Masukan Jumlah Tanggungan" min="0" step="1" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">

            <input type="text" id="MEMBER_PENDAPATAN" name="MEMBER_PENDAPATAN" placeholder="Masukan Pendapatan Perbulan" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
        </div>
        <div class="space-y-6 mt-6">
            <!-- NPWP -->

        <input type="text" id="MEMBER_NPWP" name="MEMBER_NPWP" placeholder="Masukan No. NPWP" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
    </div>         
    </div>         

    <!-- SUBMIT -->
    <div class="flex flex-wrap justify-end gap-4 pt-6 border-t border-gray-100">
        <button type="submit" class="px-8 py-3 font-semibold rounded-lg bg-green-600 dark:bg-[#F97300] text-white hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-all duration-200">
            Registrasi
        </button>
    </div>
</form>
            </div>

            <!-- Bottom Info -->
            <div class="mt-8 text-center text-gray-500 text-sm">
                Butuh bantuan? Hubungi <a target="_blank" href="https://wa.me/6281226048447"
                    class="text-blue-500 font-semibold hover:underline">Customer Service</a> di
                Assalaam Hypermarket
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
function forceNumericOnly(input) {
    input.addEventListener("input", () => {
        input.value = input.value.replace(/\D/g, "");
    });
}

document.addEventListener("DOMContentLoaded", () => {

    // ================= INPUT NUMERIC ONLY =================
    [
        "MEMBER_KTP_NO",
        "MEMBER_TELP",
        "MEMBER_RT",
        "MEMBER_RW",
        "MEMBER_POST_CODE",
        "MEMBER_JML_TANGGUNGAN",
        "MEMBER_PENDAPATAN"
    ].forEach(id => forceNumericOnly(document.getElementById(id)));

    const form = document.getElementById("memberForm");
    const token = localStorage.getItem("jwt_token_cs");
    const API_URL = "{{ api_url('/api/auth/cs/add-user-member') }}";

    // ======================================================
    // 🔥 PASSWORD TOGGLE (PERBAIKAN IKON MATA)
    // ======================================================
    function setupToggle(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const target = document.getElementById(inputId);

        toggle.addEventListener("click", () => {
            const show = target.type === "password";
            target.type = show ? "text" : "password";

            toggle.innerHTML =
                `<ion-icon name="${show ? 'eye-off-outline' : 'eye-outline'}" class="text-xl"></ion-icon>`;
        });
    }

    setupToggle("togglePassword", "password");
    setupToggle("toggleConfirmPassword", "password_confirmation");

    // ======================================================
    // 🔥 INLINE ERROR HANDLER
    // ======================================================
    function clearInlineErrors() {
        document.querySelectorAll(".inline-error").forEach(el => el.remove());
        document.querySelectorAll(".error-border")
            .forEach(e => e.classList.remove("border-red-500"));
    }

    function showInlineError(input, message) {
        input.classList.add("border-red-500", "error-border");

        // Jika sudah ada error sebelumnya, hapus dulu agar tidak numpuk
        const next = input.nextElementSibling;
        if (next && next.classList.contains("inline-error")) next.remove();

        const error = document.createElement("p");
        error.className = "inline-error text-red-500 text-xs mt-1";
        error.textContent = message;

        input.insertAdjacentElement("afterend", error);
    }
    function hideInlineError(input) {
        input.classList.remove("border-red-500", "error-border");
        const next = input.nextElementSibling;
        if (next && next.classList.contains("inline-error")) next.remove();
    }

    // helper: escape html untuk ditampilkan dalam html SweetAlert
    function escapeHtml(unsafe) {
        if (unsafe === undefined || unsafe === null) return '';
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // ======================================================
    // 🔥 REALTIME EMAIL CHECK
    // ======================================================
    const emailInput = document.getElementById("email");
    let emailCheckTimeout = null;

    emailInput.addEventListener("input", () => {
        clearInlineErrors();

        const email = emailInput.value.trim();
        if (!email || email.length < 5) return;

        clearTimeout(emailCheckTimeout);

        emailCheckTimeout = setTimeout(async () => {
            try {
                const res = await axios.post("{{ api_url('/api/member/check-email-add') }}", {
                    email: email
                });

                if (res.data.exists) {
                    showInlineError(emailInput, "Email sudah digunakan.");
                }
            } catch (error) {
                console.error("Error cek email:", error);
                // tampilkan popup singkat supaya user tahu ada masalah cek email
                Swal.fire({
                    icon: "warning",
                    title: "Gagal cek email",
                    html: `<pre style="text-align:left;white-space:pre-wrap;">${escapeHtml(error.response?.data?.message || error.message || JSON.stringify(error))}</pre>`,
                    showConfirmButton: false,
                    timer: 2500
                });
            }
        }, 400);
    });

    // ======================================================
    // 🔥 VALIDASI FRONTEND NIK & HP
    // ======================================================
    const nikInput = document.getElementById("MEMBER_KTP_NO");
    let nikCheckTimeout = null;

    nikInput.addEventListener("input", () => {
        const nik = nikInput.value.trim();

        // Reset error dulu
        hideInlineError(nikInput);
        clearTimeout(nikCheckTimeout);

        // Hanya angka
        if (!/^\d*$/.test(nik)) {
            showInlineError(nikInput, "NIK hanya boleh angka.");
            return;
        }

        // Jika kosong → tidak tampilkan error
        if (nik.length === 0) return;

        // VALIDASI UTAMA → HARUS 16 DIGIT
        if (nik.length < 16) {
            showInlineError(nikInput, "NIK harus 16 digit (kurang).");
            return;
        }

        if (nik.length > 16) {
            showInlineError(nikInput, "NIK harus 16 digit (kelebihan).");
            return;
        }

        // Jika tepat 16 → baru cek server
        nikCheckTimeout = setTimeout(async () => {
            try {
                const res = await axios.post("{{ api_url('/api/member/check-nik') }}", {
                    nik: nik
                });

                if (res.data.exists) {
                    showInlineError(nikInput, "NIK sudah terdaftar.");
                }

            } catch (err) {
                console.error("Error cek NIK:", err);
                Swal.fire({
                    icon: "warning",
                    title: "Gagal cek NIK",
                    html: `<pre style="text-align:left;white-space:pre-wrap;">${escapeHtml(err.response?.data?.message || err.message || JSON.stringify(err))}</pre>`,
                    showConfirmButton: false,
                    timer: 2500
                });
            }
        }, 400);
    });


    const hpInput = document.getElementById("MEMBER_TELP");
    hpInput.addEventListener("input", () => {
        hpInput.classList.remove("border-red-500");
        const err = hpInput.nextElementSibling;
        if (err?.classList.contains("inline-error")) err.remove();

        if (hpInput.value.length > 0 && hpInput.value.length < 9) {
            showInlineError(hpInput, "Nomor HP minimal 9 digit.");
        }
    });

    // ======================================================
    // 🔥 VALIDASI PASSWORD & KONFIRMASI
    // ======================================================
function validatePassword() {
    const pw = document.getElementById("password");
    const cpw = document.getElementById("password_confirmation");

    // Hapus error sebelumnya
    hideInlineError(pw);
    hideInlineError(cpw);

    // Password minimal 6 karakter
    if (pw.value.length < 6) {
        showInlineError(pw, "Password minimal 6 karakter.");

        // Scroll ke atas bagian form
        pw.scrollIntoView({ behavior: "smooth", block: "center" });

        return false;
    }

    // Cek kecocokan password
    if (pw.value !== cpw.value) {
        showInlineError(cpw, "Konfirmasi password tidak cocok.");

        // Scroll ke atas untuk fokus ke input
        cpw.scrollIntoView({ behavior: "smooth", block: "center" });

        return false;
    }

    return true;
}


    // ======================================================
    // 🔥 SUBMIT FORM
    // ======================================================
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        clearInlineErrors();

        // ⛔ VALIDASI PASSWORD TERLEBIH DAHULU
        if (!validatePassword()) return;

        const formData = new FormData(form);

        try {
            const res = await axios.post(API_URL, formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                    "Authorization": token ? `Bearer ${token}` : ""
                }
            });

            // ================= SUCCESS =================
            if (res.data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Registrasi berhasil. Silahkan Validasi Di Daftar Calon Member.",
                    timer: 2500,
                    showConfirmButton: false
                });

                form.reset();
                return;
            }

            // jika server merespon sukses = false dengan message spesifik
            Swal.fire({
                icon: "info",
                title: "Perhatian",
                text: res.data.message || "Operasi selesai dengan catatan."
            });

        } catch (err) {
            console.error("Error submit form:", err);

            // Error Laravel (validasi)
            if (err.response?.data?.errors) {
                const errors = err.response.data.errors;

                Object.keys(errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        showInlineError(input, errors[field][0]);
                    }
                });

                // juga tampilkan ringkasan error di popup
                const validationSummary = Object.keys(errors).map(k => `${k}: ${errors[k].join(', ')}`).join('\n');

                Swal.fire({
                    icon: "error",
                    title: "Validasi Gagal",
                    html: `<strong>Terjadi kesalahan validasi:</strong><pre style="text-align:left;white-space:pre-wrap;">${escapeHtml(validationSummary)}</pre>`,
                });

                return;
            }

            // Error email unik atau pesan spesifik dari server
            const serverMessage = err.response?.data?.message;
            if (serverMessage && /email/i.test(serverMessage)) {
                showInlineError(emailInput, serverMessage);

                Swal.fire({
                    icon: "error",
                    title: "Email Tidak Valid",
                    text: serverMessage
                });

                return;
            }

            // Fallback: tampilkan pesan error asli server (jika ada), plus log detail
            let detail = "";
            if (err.response) {
                // server merespon (status code bukan 2xx)
                detail = err.response.data?.message
                    || JSON.stringify(err.response.data)
                    || `${err.response.status} ${err.response.statusText}`;
            } else if (err.request) {
                // request dikirim tapi tidak ada respons
                detail = "Tidak menerima respon dari server. Periksa koneksi atau server.";
            } else {
                // error saat membuat request
                detail = err.message;
            }

            // Jika ada objek errors yang lain, tambahkan
            if (err.response?.data?.errors && typeof err.response.data.errors === 'object') {
                detail += "\n\nDetail errors: " + JSON.stringify(err.response.data.errors, null, 2);
            }

            // tampilkan popup dengan detail (aman karena di-escape)
            Swal.fire({
                icon: "error",
                title: "Gagal",
                html: `<strong>${escapeHtml(err.response?.data?.message || "Terjadi kesalahan, lihat detail di bawah")}</strong>
                       <pre style="text-align:left;white-space:pre-wrap;margin-top:10px;">${escapeHtml(detail)}</pre>`,
                confirmButtonText: "Tutup",
            });
        }

    });

});
</script>

@include('include.htmlend')
