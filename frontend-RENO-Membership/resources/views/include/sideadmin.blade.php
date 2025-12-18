<!-- NAVBAR -->
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3 flex items-center justify-between">

        <!-- Left: Logo + Burger -->
        <div class="flex items-center">
            <!-- Burger Button -->
            <button id="burger-btn" 
                class="mr-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 sm:hidden">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" 
                          d="M3 5h14a1 1 0 010 2H3a1 1 0 010-2zm0 6h14a1 1 0 010 2H3a1 1 0 010-2zm0 6h14a1 1 0 010 2H3a1 1 0 010-2z" 
                          clip-rule="evenodd"></path>
                </svg>
            </button>

           <!-- Logo + Teks -->
            <div class="flex items-center flex-1">
                <img src="https://pas.assalaamhypermarket.co.id/images/logo.png" alt="Logo" class="h-9 mr-2 rounded">
                <span class="hidden sm:inline self-center text-xl font-bold lg:text-2xl whitespace-nowrap text-gray-700 dark:text-white">
                    Admin Dashboard
                </span>
            </div>
        </div>

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

            <button id="dropdown-toggle" class="text-gray-600 dark:text-gray-300 text-sm hover:rotate-180 transition">▼</button>

            <!-- Dropdown -->
            <div id="dropdown-menu" class="hidden absolute right-0 top-12 w-48 bg-white dark:bg-gray-700 rounded-xl shadow-lg border dark:border-gray-600 overflow-hidden">
                <a href="/profile" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition">Profil</a>
                <a id="logout-btn" class="block px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600 transition">Keluar</a>
            </div>
        </div>
    </div>
</nav>

<!-- Overlay untuk sidebar -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 sm:hidden transition-opacity duration-300"></div>

<!-- Sidebar -->
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform transform -translate-x-full bg-white border-r dark:border-gray-700 border-gray-200 dark:bg-gray-800 sm:translate-x-0"
    aria-label="Sidebar">

    <div class="h-full px-3 pb-4 overflow-y-auto dark:bg-gray-800" 
         x-data="{ currentPath: window.location.pathname, isActive(path) { return this.currentPath === path } }">

        <ul class="space-y-2 mt-2 font-medium">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-2 rounded-xl transition-colors duration-300 group"
                    :class="isActive('/dashboard') ? 'bg-green-500 text-white shadow-md' : 'text-green-500 dark:text-[#F97300] hover:bg-green-600 hover:text-white'">
                    <ion-icon name="albums" class="w-5 h-5 ml-1"></ion-icon>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

          

            <!-- Register -->
            <li>
                <a href="/regcs"
                    class="flex items-center p-2 rounded-xl transition duration-300 group" :class="isActive('/regcs') ? 'bg-green-500 text-white shadow-md' : 'text-green-500 dark:text-[#F97300] hover:bg-green-600 hover:text-white'">
                    <ion-icon name="layers" class="w-5 h-5 ml-1"></ion-icon>
                    <span class="ms-3">Register</span>
                </a>
            </li>
            <li>
                <a href="/form_ubah_poin_admin"
                    class="flex items-center p-2 rounded-xl transition duration-300 group" :class="isActive('/form_ubah_poin_admin') ? 'bg-green-500 text-white shadow-md' : 'text-green-500 dark:text-[#F97300] hover:bg-green-600 hover:text-white'">
                    <ion-icon name="wallet-outline" class="w-5 h-5 ml-1"></ion-icon>
                    <span class="ms-3">Setting Minimal Poin</span>
                </a>
            </li>
                        <li>
                <a href="/tableadmin"
                    class="flex items-center p-2 rounded-xl transition duration-300 group" :class="isActive('/tableadmin') ? 'bg-green-500 text-white shadow-md' : 'text-green-500 dark:text-[#F97300] hover:bg-green-600 hover:text-white'">
                    <ion-icon name="file-tray-stacked-outline" class="w-5 h-5 ml-1"></ion-icon>
                    <span class="ms-3">Data Admin</span>
                </a>
            </li>

            <!-- Logout -->
            <li>
                <a id="logout-btn-sidebar"
                    class="flex items-center p-2 rounded-xl transition duration-300 text-red-500 hover:bg-red-600 hover:text-white dark:text-red-400">
                    <ion-icon name="log-out" class="w-6 h-6 ml-1"></ion-icon>
                    <span class="ms-3">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", async () => {
    const apiUrl = "{{ api_url('/api/auth/dashboard') }}";
    const token = localStorage.getItem("jwt_token_admin"); 
    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const res = await axios.get(apiUrl, {
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            }
        });

        const member = res.data.member;
        document.getElementById("user-name").innerText = member?.name ?? "User";

        const avatarImg = document.getElementById("user-avatar");
        const avatarFallback = document.getElementById("user-avatar-fallback");

        if (member?.photo_url) {
            avatarImg.src = member.photo_url;
            avatarImg.classList.remove("hidden");
            avatarFallback.classList.add("hidden");
        } else {
            const initial = member?.name ? member.name.charAt(0).toUpperCase() : "U";
            avatarFallback.textContent = initial;
            avatarFallback.classList.remove("hidden");
            avatarImg.classList.add("hidden");
        }

    } catch (error) {
        console.error("Gagal ambil profil:", error);
        if (error.response && error.response.status === 401) {
            window.location.href = "/login";
        }
    }

    // Dropdown
    const toggleBtn = document.getElementById("dropdown-toggle");
    const menu = document.getElementById("dropdown-menu");
    toggleBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        menu.classList.toggle("hidden");
    });
    document.addEventListener("click", (e) => {
        if (!menu.contains(e.target) && !toggleBtn.contains(e.target)) {
            menu.classList.add("hidden");
        }
    });
                document.getElementById("logout-btn").addEventListener("click", () => {
    localStorage.removeItem("jwt_token_admin"); 
    window.location.href = "/logout";
});

document.getElementById("logout-btn-sidebar").addEventListener("click", () => {
    localStorage.removeItem("jwt_token_admin");
    window.location.href = "/logout";
});

    // Burger + Overlay
    const burgerBtn = document.getElementById("burger-btn");
    const sidebar = document.getElementById("logo-sidebar");
    const overlay = document.getElementById("sidebar-overlay");

    burgerBtn.addEventListener("click", () => {
        sidebar.classList.toggle("-translate-x-full");
        overlay.classList.toggle("hidden");
    });

    overlay.addEventListener("click", () => {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    });
});
</script>
