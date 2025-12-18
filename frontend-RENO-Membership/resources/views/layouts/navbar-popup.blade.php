{{-- resources/views/layouts/navbar-popup.blade.php --}}
{{-- NAVBAR --}}
<nav class="fixed top-0 z-50 w-full border-b 
    bg-white dark:bg-gray-900 
    border-gray-200 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3 flex justify-between items-center">

        {{-- Burger Button --}}
        <button id="burger-btn" 
            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg 
                   hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" 
                      d="M3 5h14a1 1 0 010 2H3a1 1 0 010-2zm0 6h14a1 1 0 010 2H3a1 1 0 010-2zm0 6h14a1 1 0 010 2H3a1 1 0 010-2z" 
                      clip-rule="evenodd"></path>
            </svg>
        </button>

        {{-- Logo --}}
        <a href="/" class="flex items-center ms-2 md:me-24">
            <img src="{{ asset('images/logoTeks.png') }}" 
                 class="h-10 sm:h-12 w-auto max-w-[140px] object-contain me-3" 
                 alt="Logo" />
        </a>

        {{-- User Info --}}
        <div id="user-profile" class="relative flex items-center space-x-2 sm:space-x-3">
            <img id="user-avatar"
                src=""
                class="hidden w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-gray-300 
                       dark:border-gray-600 shadow-sm cursor-pointer hover:scale-105 transition"
                alt="Avatar">

            <div id="user-avatar-fallback"
                class="hidden w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center 
                       rounded-full border-2 border-gray-300 dark:border-gray-600 shadow-sm 
                       bg-green-600 text-white font-bold text-sm sm:text-base cursor-pointer hover:scale-105 transition">
            </div>

            <div class="hidden sm:block text-sm font-semibold text-gray-700 dark:text-gray-200">
                <span id="user-name">Loading...</span>
            </div>

            <button id="dropdown-toggle" 
                class="text-gray-600 dark:text-gray-300 text-sm hover:rotate-180 transition">
                ▼
            </button>

            {{-- Dark Mode Toggle --}}
            <label class="swap swap-rotate cursor-pointer">
                <input type="checkbox" onclick="toggleDarkMode()" class="hidden" />
                <svg class="swap-on h-5 w-5 text-green-500 dark:text-lime-500 fill-current"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                    <path d="M15 4a1 1 0 010 2..."/>
                </svg>
                <svg class="swap-off h-5 w-5 text-green-500 dark:text-[#F97300] fill-current"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M21.64,13a1,1,0,0,0-1.05..."/>
                </svg>
            </label>

            {{-- Dropdown --}}
            <div id="dropdown-menu" 
                class="hidden absolute right-0 top-12 w-44 
                bg-white dark:bg-gray-800 
                text-gray-700 dark:text-gray-200
                rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 
                overflow-hidden">
                <a href="/profile" 
                    class="block px-4 py-3 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Profil
                </a>
                <a href="/logout" 
                    class="block px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Keluar
                </a>
            </div>
        </div>
    </div>
</nav>


{{-- OVERLAY --}}
<div id="sidebar-overlay" 
     class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

{{-- POPUP SIDEBAR (dari kanan) --}}
<aside id="logo-sidebar"
    class="fixed top-0 right-0 z-50 w-64 h-screen pt-20 transition-transform translate-x-full
    bg-white dark:bg-gray-900 border-l border-gray-200 dark:border-gray-700">

    <div class="h-full px-3 pb-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('new-dashboard') }}"
                    class="flex items-center p-2 rounded-lg 
                    text-green-600 dark:text-green-400
                    hover:bg-green-600 hover:text-white transition-all">
                    <ion-icon name="albums" class="w-6 h-6"></ion-icon>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>

            {{-- Logout --}}
            <li>
                <a href="/logout"
                    class="flex items-center p-2 rounded-lg 
                    text-red-600 dark:text-red-400 
                    hover:bg-red-600 hover:text-white transition-all">
                    <ion-icon name="log-out" class="w-6 h-6"></ion-icon>
                    <span class="ml-3">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>


{{-- Axios --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("jwt_token_user"); 
    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const res = await axios.get("http://127.0.0.1:8001/api/auth/dashboard", {
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

    // === Dropdown ===
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

    // === Dark Mode ===
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

    // === Popup Sidebar ===
    const burgerBtn   = document.getElementById("burger-btn");
    const sidebar     = document.getElementById("logo-sidebar");
    const overlay     = document.getElementById("sidebar-overlay");

    burgerBtn.addEventListener("click", () => {
        sidebar.classList.toggle("translate-x-full");
        overlay.classList.toggle("hidden");
    });

    overlay.addEventListener("click", () => {
        sidebar.classList.add("translate-x-full");
        overlay.classList.add("hidden");
    });
});
</script>
