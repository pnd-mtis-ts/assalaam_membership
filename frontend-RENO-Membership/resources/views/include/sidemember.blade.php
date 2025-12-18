{{-- NAVBAR --}}
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3 flex justify-between items-center">

        {{-- Burger Button --}}
        <button id="burger-btn" 
            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg 
                   lg:hidden hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" 
                      d="M3 5h14a1 1 0 010 2H3a1 1 0 010-2zm0 6h14a1 1 0 010 2H3a1 1 0 010-2zm0 6h14a1 1 0 010 2H3a1 1 0 010-2z" 
                      clip-rule="evenodd"></path>
            </svg>
        </button>

        {{-- Logo --}}
        <a href="/" class="flex items-center flex-1">
            <img src="{{ asset('images/logoTeks.png') }}" 
                 class="h-10 sm:h-12 w-auto max-w-[140px] object-contain me-3" 
                 alt="Logo">
        </a>

        <!-- User Menu -->
        <div id="user-profile" class="relative flex items-center space-x-2 sm:space-x-3">
            <!-- Foto avatar -->
            <img id="user-avatar"
                src=""
                class="hidden w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-gray-300 
                       dark:border-gray-600 shadow-sm cursor-pointer hover:scale-105 transition"
                alt="Avatar">

            <!-- Fallback avatar inisial -->
            <div id="user-avatar-fallback"
                class="hidden w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center 
                       rounded-full border-2 border-gray-300 dark:border-gray-600 shadow-sm 
                       bg-green-600 text-white font-bold text-sm sm:text-base cursor-pointer hover:scale-105 transition">
            </div>

            <!-- Nama user -->
            <div class="hidden sm:block text-sm font-semibold text-gray-700 dark:text-gray-200">
                <span id="user-name">Loading...</span>
            </div>

            <button id="dropdown-toggle" 
                class="text-gray-600 dark:text-gray-300 text-sm hover:rotate-180 transition">▼</button>

{{-- Dark Mode --}}
<label class="swap swap-rotate">
                        <!-- this hidden checkbox controls the state -->
                        <input type="checkbox" onclick="toggleDarkMode()" class="hidden " />

                        <!-- sun icon -->
                        <svg class="swap-on h-5 w-5 text-green-500 dark:text-lime-500 fill-current"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                        </svg>
                        <svg class="swap-off h-5 w-5 text-green-500 dark:text-[#F97300] fill-current"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                        </svg>
                    </label>

            <!-- Dropdown -->
            <div id="dropdown-menu" 
                class="hidden absolute right-0 top-12 w-44 
                bg-gray-50 dark:bg-gray-800 
                text-gray-700 dark:text-gray-200
                rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 
                overflow-hidden">
                <a id="edit-profile-btn" 
                    class="block px-4 py-3 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition cursor-pointer">
                    Profil
                </a>
                <a id="logout-btn" 
                    class="block px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Keluar
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- SIDEBAR + OVERLAY --}}
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 sm:hidden transition-opacity duration-300"></div>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform transform -translate-x-full bg-white border-r dark:border-gray-700 border-gray-200 dark:bg-gray-800 sm:translate-x-0"
    aria-label="Sidebar">

    {{-- Menu --}}
    <div class="h-full px-3 pb-4 overflow-y-auto dark:bg-gray-800" 
         x-data="{ currentPath: window.location.pathname, isActive(path) { return this.currentPath === path } }">

        <ul class="space-y-2 font-medium">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('new-dashboard') }}"
                    class="flex items-center p-2 rounded-lg 
                    text-green-600 dark:text-green-400
                    hover:bg-green-600 hover:text-white
                    transition-all"
                    :class="isActive('/new-dashboard') ? 'bg-green-500 text-white shadow-md' : 'text-green-500 dark:text-[#F97300] hover:bg-green-600 hover:text-white'">
                    <ion-icon name="albums" class="w-5 h-5 ml-1"></ion-icon>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>

            {{-- Keluar --}}
            <li>
                <a id="logout-btn-sidebar"
                    class="flex items-center p-2 rounded-lg 
                    text-red-600 dark:text-red-400 
                    hover:bg-red-600 hover:text-white 
                    transition-all">
                    <ion-icon name="log-out" class="w-6 h-6 ml-1"></ion-icon>
                    <span class="ml-3">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

{{-- POPUP EDIT PROFIL (dengan efek blur) --}}
<div id="editProfileModal"
    class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-[60] transition-all duration-300">
    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md p-6 relative animate-fade-in">

        <!-- Tombol Close -->
        <button id="closeProfileModal"
            class="absolute top-3 right-3 text-gray-600 dark:text-gray-300 hover:text-red-500 text-lg">✕</button>

        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">Edit Profil</h2>

        <!-- Notifikasi -->
        <div id="messageBox" class="hidden text-center mb-3 text-sm font-medium"></div>

        <!-- Form -->
        <form id="editProfileForm" class="space-y-4" enctype="multipart/form-data">
            <!-- Ganti Foto -->
            <div class="flex flex-col items-center gap-2">
                <img id="profilePreview" src="{{ asset('images/default-avatar.png') }}" 
                    class="w-24 h-24 rounded-full border border-gray-300 dark:border-gray-600 object-cover shadow-sm">
                <label class="cursor-pointer text-sm text-green-600 dark:text-green-400 hover:underline">
                    Ganti Foto
                    <input type="file" id="profilePhoto" accept="image/*" class="hidden">
                </label>
                <button type="button" id="removePhotoBtn" 
                    class="text-sm text-red-500 hover:underline">Hapus Foto</button>
            </div>

            <hr class="my-2 border-gray-300 dark:border-gray-600">

            <!-- Ganti Password -->
            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Password Lama</label>
                <input type="password" id="oldPassword" placeholder="••••••••"
                    class="w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white focus:ring focus:ring-green-400 outline-none">
            </div>
            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                <input type="password" id="newPassword" placeholder="••••••••"
                    class="w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white focus:ring focus:ring-green-400 outline-none">
            </div>
            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password Baru</label>
                <input type="password" id="newPasswordConfirmation" placeholder="••••••••"
                    class="w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white focus:ring focus:ring-green-400 outline-none">
            </div>

            <!-- Tombol Simpan -->
            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition">
                Simpan
            </button>
        </form>
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.animate-fade-in { animation: fade-in 0.25s ease-out; }
</style>

<!-- Axios & Image Compression -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>

<script>
document.addEventListener("DOMContentLoaded", async () => {
    const apiDashboard = "{{ api_url('/api/auth/dashboard') }}";
    const apiChange   = "{{ api_url('/api/auth/change-password') }}";
    const apiProfile        = "{{ api_url('/api/member/profile-photo') }}";
    const apiDelete        = "{{ api_url('/api/member/profile-photo/delete') }}";
    const token = localStorage.getItem("jwt_token_user"); 
    if (!token) { window.location.href = "/login"; return; }

    const headers = { "Authorization": `Bearer ${token}`, "Accept": "application/json" };

    // ✅ Load profil
    try {
        const res = await axios.get(apiDashboard, { headers });
        const member = res.data.member;
        document.getElementById("user-name").innerText = member?.name ?? "User";

        const avatarImg = document.getElementById("user-avatar");
        const avatarFallback = document.getElementById("user-avatar-fallback");

        if (member?.photo_url) {
            avatarImg.src = member.photo_url;
            avatarImg.classList.remove("hidden");
            avatarFallback.classList.add("hidden");
            document.getElementById("profilePreview").src = member.photo_url;
        } else {
            const initial = member?.name ? member.name.charAt(0).toUpperCase() : "U";
            avatarFallback.textContent = initial;
            avatarFallback.classList.remove("hidden");
            avatarImg.classList.add("hidden");
        }
    } catch (error) {
        console.error("Gagal ambil profil:", error);
    }

    // Dropdown
    const toggleBtn = document.getElementById("dropdown-toggle");
    const menu = document.getElementById("dropdown-menu");
    toggleBtn.onclick = e => { e.stopPropagation(); menu.classList.toggle("hidden"); };
    document.addEventListener("click", e => { if (!menu.contains(e.target) && !toggleBtn.contains(e.target)) menu.classList.add("hidden"); });

    // Dark mode
    const darkToggle = document.querySelector("input[onclick='toggleDarkMode()']");
    if (localStorage.getItem("theme") === "dark") {
        document.documentElement.classList.add("dark");
        darkToggle.checked = true;
    }
    window.toggleDarkMode = function() {
        if (darkToggle.checked) {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
        } else {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
        }
    }

    // Sidebar toggle
    const burgerBtn = document.getElementById("burger-btn");
    const sidebar = document.getElementById("logo-sidebar");
    const overlay = document.getElementById("sidebar-overlay");
    burgerBtn.onclick = () => { sidebar.classList.toggle("-translate-x-full"); overlay.classList.toggle("hidden"); };
    overlay.onclick = () => { sidebar.classList.add("-translate-x-full"); overlay.classList.add("hidden"); };

    // Popup edit profil
    const modal = document.getElementById("editProfileModal");
    const editBtn = document.getElementById("edit-profile-btn");
    const closeBtn = document.getElementById("closeProfileModal");
    editBtn.onclick = () => modal.classList.remove("hidden");
    closeBtn.onclick = () => modal.classList.add("hidden");
    modal.addEventListener("click", e => { if (e.target === modal) modal.classList.add("hidden"); });

    // Preview foto & peringatan ukuran
    const photoInput = document.getElementById("profilePhoto");
    const preview = document.getElementById("profilePreview");
    const warningEl = document.createElement("p");
    warningEl.id = "photoWarning";
    warningEl.className = "text-xs text-yellow-600 mt-1 text-center hidden";
    photoInput.parentElement.appendChild(warningEl);

    photoInput.addEventListener("change", e => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = ev => preview.src = ev.target.result;
            reader.readAsDataURL(file);
            if (file.size > 200 * 1024) {
                warningEl.textContent = "⚠️ Ukuran foto >200KB, akan dikompres otomatis saat disimpan.";
                warningEl.classList.remove("hidden");
            } else warningEl.classList.add("hidden");
        }
    });

    // Submit form
    const form = document.getElementById("editProfileForm");
    const messageBox = document.getElementById("messageBox");
    form.addEventListener("submit", async e => {
        e.preventDefault();
        messageBox.classList.remove("hidden");
        messageBox.textContent = "Memproses...";
        messageBox.className = "text-center mb-3 text-sm font-medium text-gray-500";

        const oldPassword = document.getElementById("oldPassword").value.trim();
        const newPassword = document.getElementById("newPassword").value.trim();
        const confirmPassword = document.getElementById("newPasswordConfirmation").value.trim();
        let file = document.getElementById("profilePhoto").files[0];

        try {
            if (file && file.size > 200 * 1024) {
                file = await imageCompression(file, { maxSizeMB: 0.2, maxWidthOrHeight: 800, useWebWorker: true });
            }

            if (oldPassword && newPassword && confirmPassword) {
    if (newPassword !== confirmPassword) {
        messageBox.textContent = "❌ Konfirmasi password tidak cocok.";
        messageBox.className = "text-center mb-3 text-sm font-medium text-red-600";
        return;
    }

    // ✅ Ganti password
    await axios.post(apiChange, {
        old_password: oldPassword,
        new_password: newPassword,
        new_password_confirmation: confirmPassword
    }, { headers });

    messageBox.textContent = "✅ Password berhasil diperbarui!";
    messageBox.className = "text-center mb-3 text-sm font-medium text-green-600";

    // ⏳ Tunggu 1 detik lalu logout otomatis
    setTimeout(() => {
        localStorage.removeItem("jwt_token_user"); // hapus token
        window.location.href = "/login"; // arahkan ke halaman login
    }, 1200);

    return; // hentikan proses berikutnya (biar gak lanjut ke upload foto)
}

            if (file) {
                const formData = new FormData();
                formData.append("photo", file);
                await axios.post(apiProfile, formData, { headers });
                messageBox.textContent = "✅ Foto profil berhasil diperbarui!";
                messageBox.className = "text-center mb-3 text-sm font-medium text-green-600";
            }

            setTimeout(() => location.reload(), 1000);
        } catch (err) {
            console.error(err);
            messageBox.textContent = err.response?.data?.message || "❌ Gagal memperbarui profil.";
            messageBox.className = "text-center mb-3 text-sm font-medium text-red-600";
        }
    });
    document.getElementById("logout-btn").addEventListener("click", () => {
    localStorage.removeItem("jwt_token_user"); 
    window.location.href = "/logout";
});

document.getElementById("logout-btn-sidebar").addEventListener("click", () => {
    localStorage.removeItem("jwt_token_user");
    window.location.href = "/logout";
});

    // Hapus foto profil
    document.getElementById("removePhotoBtn").addEventListener("click", async () => {
        try {
            await axios.post(apiDelete, {}, { headers });
            alert("Foto profil berhasil dihapus!");
            location.reload();
        } catch {
            alert("Gagal menghapus foto profil!");
        }
    });
});
</script>
