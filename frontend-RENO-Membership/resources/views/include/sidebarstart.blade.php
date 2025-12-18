{{-- @include('include.htmlstart') --}}
<nav class="fixed top-0 z-50 w-full border-b bg-white border-gray-200 bg-  dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5  dark:bg-gray-800 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200  dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="" class="flex ms-2 md:me-24">
                    <img src="{{ asset('images/logoTeks.png') }}" class="h-12 me-3" alt="FlowBite Logo" />
                </a>
            </div>
            <div class="flex items-center">
                <div class=" p-2 rounded-full">
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
                </div>
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button"
                            class="flex text-sm rounded-full dark:text-gray-300 focus:ring-2 ring-offset-2 dark:ring-offset-gray-900  focus:ring-green-400 dark:focus:ring-[#F97300] "
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>

                            <div class="flex gap-2  p-1 xl:p-1.5 lg:p-1.5 xl:mr-2 lg:mr-2 ">
                                @if (Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/files/' . Auth::user()->profile_photo) }}"
                                        alt="{{ Auth::user()->name }}"
                                        class="w-9 h-9 rounded-full ring-green-400 dark:ring-[#F97300] ring-2 ring-offset-1">
                                @else
                                    <img src="{{ asset('images/generalUser.png') }}" class="w-9 h-9 rounded-full"
                                        alt="Default Profile Photo">
                                @endif
                                <div class="text-left hidden sm:hidden xl:block lg:block">
                                    <p class="antialiased font-sans text-sm leading-normal font-semibold">
                                        {{ Auth::user()->name }}</p>
                                    <p class="antialiased font-sans text-xs font-normal ">
                                        {{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="card z-50 hidden text-base list-none  dark:bg-gray-800 divide-y-2 divide-gray-200 rounded shadow dark:divide-gray-900"
                        id="dropdown-user">

                        <div class="px-4 py-3  hidden lg:hidden xl:hidden" role="none">
                            <p class="text-sm text-gray-900 " role="none">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                        <ul class="py-1  dark:bg-gray-800" role="none">
                            <li>
                                @if (Auth::user()->role == 'admin')
                                    <a href="{{ route('new-regis') }}"
                                        class="flex items-center gap-2 flex-row px-4 py-2 text-sm transition duration-500 text-green-500 dark:text-[#F97300] hover:bg-green-600/50 font-semibold dark:hover:bg-[#F97300] hover:text-gray-50 dark:hover:text-gray-50"
                                        role="menuitem">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>

                                        Registrasi
                                    </a>
                                @endif
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center gap-2 flex-row px-4 py-2 text-sm transition duration-500 text-green-500 dark:text-[#F97300] font-semibold dark:hover:bg-[#F97300] hover:bg-green-600/50 hover:text-gray-50 dark:hover:text-gray-50"
                                    role="menuitem" onclick="my_modal_3.showModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" />
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    </svg>
                                    Pengaturan Akun</a>
                                <dialog id="my_modal_3" class="modal ">
                                    <div class="modal-box dark:bg-gray-800">
                                        <form method="dialog">
                                            <button
                                                class="btn btn-sm btn-circle btn-ghost absolute dark:text-gray-200 right-2 top-2">✕</button>
                                        </form>
                                        <form action="/profile-user/update/{{ Auth::user()->id }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <h3 class="text-lg font-bold dark:text-gray-200">Edit Akun</h3>
                                            <div class="flex flex-row justify-center items-center mt-4 gap-4">
                                                <div class="avatar">
                                                    <div
                                                        class="ring-primary ring-offset-base-100 w-12  rounded-full ring ring-offset-2">
                                                        @if (Auth::user()->profile_photo)
                                                            <img
                                                                src="{{ asset('storage/files/' . Auth::user()->profile_photo) }}" />
                                                        @else
                                                            <img src="{{ asset('images/generalUser.png') }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <label for="set_akun">
                                                    <input type="file" id="set_akun" name="file" hidden />
                                                    <div
                                                        class="flex w-28 h-9 px-2 flex-col bg-indigo-600 rounded-full shadow text-white text-xs font-semibold leading-4 items-center justify-center cursor-pointer focus:outline-none">
                                                        Ganti</div>
                                                </label>
                                            </div>
                                            <div class="mt-4 w-full">
                                                <input type="text" id="nama" placeholder="Nama"
                                                    name="name" value="{{ old('name', Auth::user()->name) }}"
                                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                @error('name')
                                                    <p class="text-xs text-red-500">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class=" mt-4 w-full">
                                                <input type="text" id="email" placeholder="email"
                                                    name="email" value="{{ old('email', Auth::user()->email) }}"
                                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                @error('email')
                                                    <p class="text-xs text-red-500">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class=" mt-4 w-full">
                                                <input type="password" id="new_password" name="password"
                                                    placeholder="Password Baru"
                                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                @error('password')
                                                    <p class="text-xs text-red-500">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class=" mt-4 w-full">
                                                <input type="password" id="confirm_password"
                                                    name="password_confirmation" placeholder="Konfirmasi Password"
                                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                @error('password_confirmation')
                                                    <p class="text-xs text-red-500">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class=" mt-4 w-full">
                                                <input type="password" id="old_password" name="old_password"
                                                    placeholder="Password Lama (Harus di isi jika ingin memperbarui password)"
                                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                @error('old_password')
                                                    <p class="text-xs text-red-500">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <button type="submit"
                                                class="text-white mt-4 bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">Simpan</button>
                                        </form>
                                    </div>
                                </dialog>
                            </li>
                            <li>
                                <a href="/logout"
                                    class="flex items-center gap-2 flex-row px-4 py-2 text-sm transition duration-500 text-green-500 dark:text-[#F97300] font-semibold dark:hover:bg-[#F97300] hover:bg-green-600/50 hover:text-gray-50 dark:hover:text-gray-50"
                                    role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                    </svg>
                                    Keluar</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r  dark:border-gray-700 border-gray-200 dark:bg-gray-800 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto dark:bg-gray-800" x-data="{
        currentPath: window.location.pathname,
        isActive(path) {
            return this.currentPath === path
        }
    }">
        <ul class="space-y-2 mt-2 font-medium">
            @if (auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 text-green-400 dark:text-[#F97300] rounded-xl dark:hover:text-gray-50 transition-colors duration-500 hover:bg-[#198e3a] dark:hover:bg-[#F97300] hover:text-gray-50 group "
                        :class="isActive('/dashboard') ?
                            'bg-[#20b64a] dark:bg-[#F97300] text-white dark:text-white hover:text-gray-50' :
                            'shadow-none '">
                        <ion-icon name="albums" class="w-5 h-5 ml-1 "></ion-icon>

                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-primary-100 dark:bg-primary' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center  group text-green-400 dark:text-[#F97300] dark:hover:bg-[#F97300] dark:hover:text-gray-50 rounded-xl transition-colors duration-500 hover:bg-[#198e3a] hover:text-gray-50"
                            :class="{
                                'bg-[#20b64a] dark:bg-[#F97300] dark:text-white text-white hover:text-gray-50': isActive ||
                                    open
                            }"
                            role="button" aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'"
                            aria-expanded="true">
                            <span aria-hidden="true">
                                <ion-icon class="ml-3 w-5 h-5 mt-2" name="folder"></ion-icon>
                            </span>
                            <span class="group-hover:text-white ml-3 whitespace-nowrap"> Table </span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform mr-2 transform rotate-180"
                                    :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <a href="{{ route('table') }}" role="menuitem"
                                class="flex items-center p-2 text-green-400 dark:text-[#F97300] dark:hover:bg-[#F97300] dark:hover:text-gray-50 rounded-xl transition-colors duration-500 hover:bg-[#198e3a] hover:text-gray-50 group "
                                :class="isActive('/table') ?
                                    'bg-[#20b64a] dark:bg-[#F97300] dark:text-white text-white hover:text-gray-50' :
                                    'shadow-none'">
                                <ion-icon class="w-5 h-5" name="card"></ion-icon>
                                <span class="flex-1 ms-3 whitespace-nowrap">Table Member</span>
                            </a>
                            <a href="{{ route('table.transaction') }}" role="menuitem"
                                class="flex items-center p-2 text-green-400 dark:text-[#F97300] dark:hover:bg-[#F97300] dark:hover:text-gray-50 rounded-xl transition-colors duration-500 hover:bg-[#198e3a] hover:text-gray-50 group "
                                :class="isActive('/table-transaction') ?
                                    'bg-[#20b64a] dark:bg-[#F97300] dark:text-white text-white hover:text-gray-50' :
                                    'shadow-none'">
                                <ion-icon class="w-5 h-5" name="wallet"></ion-icon>
                                <span class="flex-1 ms-3 whitespace-nowrap">Table Transaksi</span>
                            </a>
                            <a href="{{ route('table.akun') }}" role="menuitem"
                                class="flex items-center p-2 text-green-400 dark:text-[#F97300] dark:hover:bg-[#F97300] dark:hover:text-gray-50 rounded-xl transition-colors duration-500 hover:bg-[#198e3a] hover:text-gray-50 group "
                                :class="isActive('/table-akun') ?
                                    'bg-[#20b64a] dark:bg-[#F97300] dark:text-white text-white hover:text-gray-50' :
                                    'shadow-none'">
                                <i class="fa-solid fa-address-card w-5 h-5"></i>
                                <span class="flex-1 ms-3 whitespace-nowrap">Table Akun</span>
                            </a>
                        </div>
                    </div>
                </li>
            @endif

            {{-- cek --}}
            @if (auth()->user()->role === 'user' && auth()->user()->member?->no_member !== null)
                <li>
                    <a href="{{ route('new-dashboard') }}"
                        class="flex items-center p-2 text-green-400 dark:text-[#F97300] dark:hover:bg-[#F97300] dark:hover:text-gray-50 rounded-xl transition-colors duration-500 hover:bg-[#198e3a] hover:text-gray-50 group"
                        :class="isActive('/new-dashboard') ?
                            'bg-[#20b64a] dark:bg-[#F97300] dark:text-white text-white hover:text-gray-50' :
                            'shadow-none'">
                        <ion-icon name="albums" class="w-5 h-5 ml-1 "></ion-icon>

                        <span class="flex-1 ms-3 whitespace-nowrap">Dashboard Member</span>
                    </a>
                </li>
            @endif

            <li>
                <a href="{{ Auth::user()->role == 'admin' ? route('form-admin.index') : route('form') }}"
                    class="flex items-center p-2 text-green-400 dark:text-[#F97300] dark:hover:text-gray-50 rounded-xl transition-colors duration-300 hover:bg-[#198e3a] dark:hover:bg-[#F97300] hover:text-gray-50 group group ":class="isActive('/form') ? 'bg-[#20b64a] dark:bg-[#F97300] dark:text-white text-white hover:text-gray-50' : 'shadow-none'">
                    <ion-icon name="layers" class="w-5 h-5 ml-1"></ion-icon>


                    <span class="flex-1 ms-3 whitespace-nowrap">Formulir</span>

                </a>
            </li>
            <li>
                <a href="/logout"
                    class="flex items-center p-2 text-green-400 dark:text-[#F97300] dark:hover:bg-[#F97300] dark:hover:text-gray-50 rounded-xl transition-colors duration-500 hover:bg-[#198e3a] hover:text-gray-50 group ">
                    <ion-icon name="log-out" class="w-6 h-6 ml-1"></ion-icon>
                    <span class="flex-1 ms-2 whitespace-nowrap">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("token"); 
    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const res = await axios.get("http://127.0.0.1:8001/api/auth/dashboardd", {
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            }
        });
        const user = res.data.user;
        document.getElementById("user-name").innerText = user.name;
        document.getElementById("user-avatar").src = user.profile_photo ?? 
            "https://pas.assalaamhypermarket.co.id/images/default-avatar.png";
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

    // Dark Mode
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

    // Burger + Overlay
    const burgerBtn   = document.getElementById("burger-btn");
    const sidebar     = document.getElementById("logo-sidebar");
    const overlay     = document.getElementById("sidebar-overlay");

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