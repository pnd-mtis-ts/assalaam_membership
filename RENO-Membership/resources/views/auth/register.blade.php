@include('include.htmlstart') <!-- 🔵 Memanggil template header global -->

{{-- Register New --}}
<!-- 🔵 Background overlay + gambar -->
<div class="font-[sans-serif] min-h-screen w-full flex items-center justify-center bg-gradient-to-tr from-gray-200 to-emerald-100"
    style="background-image: linear-gradient(rgba(99,99,99,0.5), rgba(99,99,99,0.5)), url('{{ asset('https://pas.assalaamhypermarket.co.id/images/bg.jpg') }}'); background-size: cover; background-position: center;">

    <!-- 🔵 Container 2 kolom -->
    <div data-aos="zoom-in"
        class="grid lg:grid-cols-2 gap-4 max-w-5xl w-full p-6 rounded-lg shadow-lg mx-auto sm:mx-4"
        style="background-image: linear-gradient(rgba(255,255,255,0.45), rgba(248,226,226,0.40))">

        <!-- 🔵 Kolom kiri: logo + deskripsi + sosmed -->
        <div class="lg:ps-2">

            <!-- Logo -->
            <a href="beranda">
                <img src="{{ asset('https://pas.assalaamhypermarket.co.id/images/logoTeks.png') }}" alt="logo" class="w-56" />
            </a>

            <!-- Judul & deskripsi -->
            <div class="max-w-lg mt-20 ml-10 max-lg:hidden">
                <h3 class="text-3xl font-bold text-gray-800">Buat akun</h3>
                <p class="text-sm text-gray-800">Buat akun Assalaam Hypermarket untuk akses layanan.</p>
            </div>

            <!-- Sosial media -->
            <div data-aos="zoom-in" class="hidden sm:block">
                <div class="grid grid-cols-2 mt-2 md:grid-cols-3 gap-3 items-center">
                    <img src="{{ asset('https://pas.assalaamhypermarket.co.id/images/grab.png') }}" class="w-28 mx-auto" />
                    <img src="{{ asset('https://pas.assalaamhypermarket.co.id/images/tokopedia.png') }}" class="w-28 mx-auto" />
                    <img src="{{ asset('https://pas.assalaamhypermarket.co.id/images/wa.png') }}" class="w-30 mx-auto mt-4" />
                    <img src="{{ asset('https://pas.assalaamhypermarket.co.id/images/shopee.png') }}" class="w-28 mx-auto mb-2" />
                    <img src="{{ asset('https://pas.assalaamhypermarket.co.id/images/instagram.png') }}" class="w-28 mx-auto mt-2" />
                    <img src="https://readymadeui.com/facebook-logo.svg" class="w-28 mx-auto" />
                </div>
            </div>
        </div>

        <!-- 🔵 Kolom kanan: Form Registrasi -->
        <div data-aos="fade-up"
            class="bg-white rounded-xl px-4 py-4 max-w-md w-full h-max shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] max-lg:mx-auto">

            <!-- 🔵 Form Register -->
            <form id="registerForm" enctype="multipart/form-data">

                <!-- Nama -->
                <div>
                    <label class="text-gray-800 text-xs mb-2 block">Nama</label>
                    <input name="name" type="text"
                        class="w-full text-xs text-gray-800 border border-gray-300 p-2 mb-2 rounded-md outline-blue-600"
                        placeholder="Masukan Nama" />
                </div>

                <!-- Email -->
                <div>
                    <label class="text-gray-800 text-xs mb-2 block">Email</label>
                    <input name="email" type="email"
                        class="w-full text-xs text-gray-800 border border-gray-300 p-2 mb-2 rounded-md outline-blue-600"
                        placeholder="Masukan email" />
                </div>

                <!-- Role hidden (default user) -->
                <input type="hidden" value="user" name="role">

                <!-- Foto Profil -->
                <label for="file" class="block mb-2 text-xs text-gray-800">Foto Profil</label>
                <input type="file" name="profile_photo"
                    class="file-input file-input-sm text-xs text-gray-400 border-gray-300 rounded-md mb-2 w-full" />

                <!-- 🔵 Dropdown Member (Alpine.js) -->
                <div x-data="{ open: false }">
                    <a @click.prevent="open = !open" class="flex items-start text-gray-800 cursor-pointer">
                        <span class="text-sm">Sudah punya Member PAS?</span>
                        <span aria-hidden="true" class="ml-auto">
                            <svg class="w-4 h-4 transition-transform"
                                :class="{ 'rotate-180': open }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </span>
                    </a>

                    <!-- Kolom tambahan member -->
                    <div x-show="open" x-cloak class="mt-2 space-y-2">
                        <input name="no_member" type="text"
                            class="w-full text-xs text-gray-800 border border-gray-300 p-2 rounded-md outline-blue-600"
                            placeholder="Masukan No. Member" />

                        <input type="date" name="tanggal_lahir"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg w-full p-2">
                    </div>

                    <p class="text-blue-500 text-xs mt-1">(Klik untuk mengisi nomor member jika sudah punya)</p>
                </div>

                <!-- Password -->
                <div class="mt-2 relative">
                    <label class="text-gray-800 text-xs mb-2 block">Password</label>
                    <input id="password" name="password" type="password"
                        class="w-full text-xs text-gray-800 border border-gray-300 p-2 rounded-md pr-10"
                        placeholder="Masukan password" />
                    <button type="button" id="togglePassword"
                        class="absolute right-2 top-8 text-gray-500 hover:text-gray-700">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>

                <!-- Confirm Password -->
                <div class="mt-2 relative">
                    <label class="text-gray-800 text-xs mb-2 block">Konfirmasi Password</label>
                    <input id="confirmPassword" name="password_confirmation" type="password"
                        class="w-full text-xs text-gray-800 border border-gray-300 p-2 rounded-md pr-10"
                        placeholder="Masukan ulang password" />
                    <button type="button" id="toggleConfirmPassword"
                        class="absolute right-2 top-8 text-gray-500 hover:text-gray-700">
                        <svg id="eyeConfirmIcon" xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>

                <!-- 🔵 Checkbox Syarat & Ketentuan -->
                <div class="flex items-center mt-2">
                    <input name="terms" id="terms" value="accepted" type="checkbox"
                        class="h-4 w-4 border-gray-300 rounded" />
                    <label for="terms" class="ml-3 text-sm text-gray-800">
                        Saya menyetujui
                        <a @click.prevent="open = true"
                            class="text-blue-500 font-semibold hover:underline ml-1">
                            Syarat dan Ketentuan
                        </a>
                    </label>
                </div>

                <!-- 🔵 Area Notifikasi -->
                <div id="notif-area" class="mt-3 hidden">
                    <p id="notif-text"
                        class="text-xs text-center font-semibold py-2 rounded-md"></p>
                </div>

                <!-- 🔵 Tombol Submit -->
                <div class="mt-2 bg-amber-500 rounded-md hover:bg-amber-600">
                    <button type="submit"
                        class="w-full text-center py-3 px-6 text-sm font-semibold text-white">
                        Buat Akun
                    </button>
                </div>

                <!-- Link ke login -->
                <p class="text-sm mt-4 text-center text-gray-800">
                    Sudah punya akun?
                    <a href="login" class="text-blue-600 font-semibold hover:underline ml-1">
                        Login disini
                    </a>
                </p>
            </form>

            <!-- 🔵 Modal Syarat & Ketentuan -->
            <div x-show="open" x-transition.opacity
                class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50"
                x-cloak>
                <div @click.away="open = false"
                    class="bg-white rounded-lg shadow-lg w-11/12 md:w-2/3 lg:w-1/2 p-6 max-h-[80vh] overflow-y-auto">

                    <h2 class="text-xl font-semibold mb-2 text-gray-800">Syarat & Ketentuan</h2>

                    <div class="text-sm text-gray-700 space-y-2">
                        <p>1. Data harus sesuai identitas asli.</p>
                        <p>2. Digunakan sesuai kebijakan privasi.</p>
                        <p>3. Pengguna menjaga keamanan akun.</p>
                        <p>4. Pelanggaran dapat menonaktifkan akun.</p>
                        <p>5. Ketentuan dapat diperbarui sewaktu-waktu.</p>
                    </div>

                    <div class="mt-4 text-right">
                        <button type="button" @click="open = false"
                            class="bg-amber-500 text-white px-4 py-2 rounded-md hover:bg-amber-600">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('include.htmlend') <!-- 🔵 Memanggil footer HTML -->

<!-- =========================== -->
<!-- 🔵 SCRIPT REGISTER + LOGIC -->
<!-- =========================== -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("registerForm");
    const notifArea = document.getElementById("notif-area");
    const notifText = document.getElementById("notif-text");
    const submitBtn = form.querySelector("button[type='submit']");
    const API_URL = "{{ api_url('/api/auth/register') }}";

    function showNotif(text, color) {
        notifText.textContent = text;
        notifArea.classList.remove("hidden");
        notifText.className = `text-xs text-center font-semibold py-2 rounded-md ${color}`;
        setTimeout(() => notifArea.classList.add("hidden"), 5000);
    }

    // 🔹 Fungsi compress foto (<200KB)
    async function compressImage(file, maxSizeKB = 200) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
            };
            img.onload = () => {
                const canvas = document.createElement('canvas');
                let width = img.width;
                let height = img.height;

                // Resize jika terlalu besar
                const maxDim = 1024; // maksimal sisi panjang 1024px
                if (width > height && width > maxDim) {
                    height *= maxDim / width;
                    width = maxDim;
                } else if (height > width && height > maxDim) {
                    width *= maxDim / height;
                    height = maxDim;
                }

                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                // Compress iteratif
                let quality = 0.9;
                function tryCompress() {
                    canvas.toBlob(blob => {
                        if (blob.size / 1024 <= maxSizeKB || quality <= 0.1) {
                            resolve(blob);
                        } else {
                            quality -= 0.05;
                            tryCompress();
                        }
                    }, 'image/jpeg', quality);
                }
                tryCompress();
            };
            reader.onerror = err => reject(err);
            reader.readAsDataURL(file);
        });
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `<div class="flex items-center gap-2">
            <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            Sedang diproses...
        </div>`;

        const formData = new FormData(form);

        // Ubah field member
        if (formData.has("no_member")) {
            formData.append("member_card_no", formData.get("no_member"));
            formData.delete("no_member");
        }
        if (formData.has("tanggal_lahir")) {
            formData.append("date_of_birth", formData.get("tanggal_lahir"));
            formData.delete("tanggal_lahir");
        }

        // 🔹 Compress foto jika ada
        const fileInput = form.querySelector('input[name="profile_photo"]');
        if (fileInput.files.length > 0) {
            try {
                const compressedBlob = await compressImage(fileInput.files[0], 200);
                formData.set("profile_photo", compressedBlob, "profile.jpg");
            } catch (err) {
                showNotif("Gagal memproses foto profil.", "bg-red-100 text-red-600");
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                return;
            }
        }

        try {
            const res = await fetch(API_URL, { method: "POST", body: formData });
            const data = await res.json();

            if (res.status === 422) {
                let msg = "Periksa kembali input Anda.";
                if (data.errors) msg = Object.values(data.errors).flat().join(" ");
                showNotif(msg, "bg-red-100 text-red-600");
            } else if (res.status === 409) {
                showNotif(data.message || "Member sudah memiliki akun.", "bg-red-100 text-red-600");
            } else if (res.status >= 500) {
                showNotif("Server error. Coba lagi.", "bg-red-100 text-red-600");
            } else if (res.ok && data.success) {
                showNotif("Registrasi berhasil! Mengalihkan...", "bg-green-100 text-green-600");
                setTimeout(() => window.location.href = "/login", 2000);
            } else {
                showNotif(data.message || "Registrasi gagal.", "bg-red-100 text-red-600");
            }

        } catch (err) {
            showNotif("Gagal konek ke server.", "bg-red-100 text-red-600");
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });

    // Toggle password
    const togglePassword = (btnId, inputId) => {
        document.getElementById(btnId).addEventListener('click', () => {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    }
    togglePassword('togglePassword', 'password');
    togglePassword('toggleConfirmPassword', 'confirmPassword');

});
</script>
@include('include.htmlend') 