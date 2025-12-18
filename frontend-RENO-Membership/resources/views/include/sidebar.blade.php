{{-- Navbar --}}
<nav class="fixed top-0 z-50 w-full border-b bg-white border-gray-200 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 dark:bg-gray-800 lg:pl-3" 
         x-data="sidebarData()" 
         x-init="fetchUser()">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <!-- tombol sidebar -->
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="" class="flex ms-2 md:me-24">
                    <img src="{{ asset('images/logoTeks.png') }}" class="h-12 me-3" alt="Logo" />
                </a>
            </div>

            <!-- Bagian Profile -->
            <div class="flex items-center" x-show="user">
                <div class="flex items-center ms-3">
                    <button type="button"
                        class="flex text-sm rounded-full dark:text-gray-300 focus:ring-2 ring-offset-2 dark:ring-offset-gray-900 focus:ring-green-400 dark:focus:ring-[#F97300]"
                        aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Open user menu</span>
                        <div class="flex gap-2 p-1 xl:p-1.5 lg:p-1.5 xl:mr-2 lg:mr-2">
                            <template x-if="user.profile_photo">
                                <img :src="'/storage/files/' + user.profile_photo"
                                    alt="Foto Profile"
                                    class="w-9 h-9 rounded-full ring-green-400 dark:ring-[#F97300] ring-2 ring-offset-1">
                            </template>
                            <template x-if="!user.profile_photo">
                                <img src="{{ asset('images/generalUser.png') }}" 
                                    alt="Default" 
                                    class="w-9 h-9 rounded-full">
                            </template>
                            <div class="text-left hidden sm:hidden xl:block lg:block">
                                <p class="antialiased font-sans text-sm leading-normal font-semibold" 
                                   x-text="user.name"></p>
                                <p class="antialiased font-sans text-xs font-normal" 
                                   x-text="user.email"></p>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
function sidebarData() {
    return {
        user: null,

        async fetchUser() {
            try {
                const token = localStorage.getItem("jwt_token_user") || localStorage.getItem("jwt_token_admin");
                if (!token) return;

                const res = await axios.get("http://127.0.0.1:8001/api/auth/dashboardd", {
                    headers: { Authorization: `Bearer ${token}` }
                });

                this.user = res.data.member || res.data.user; 
            } catch (e) {
                console.error("Gagal fetch user:", e);
            }
        },

        logout() {
            localStorage.removeItem("jwt_token_user");
            localStorage.removeItem("jwt_token_admin");
            window.location.href = "/login";
        },

        toggleDarkMode() {
            document.documentElement.classList.toggle("dark");
        }
    }
}
</script>
