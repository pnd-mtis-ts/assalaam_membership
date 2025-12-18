<div class="drawer">
    <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex mx-4 flex-col">
        <!-- Navbar -->
        <div
            class="navbar top-4 rounded-xl outline outline-2 outline-gray-800/10 backdrop-blur-sm bg-white/50 sticky z-50 w-full">
            <div class="flex-none">
                <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block h-6 w-6 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>
            </div>
            {{-- title page --}}
            <div class="mx-2 flex-1 px-2"></div>
            {{-- title page --}}
            <div class="hidden flex-none lg:block">
                <ul class="menu menu-horizontal">
                    <!-- Navbar menu content here -->

                    <li class="cursor-none"><span>
                            <div class="flex cursor-none items-center -m-2 gap-2 p-1.5">
                                   
                                                    <img src="{{ asset('https://pas.assalaamhypermarket.co.id/images/generalUser.png') }}"
                                                        class="inline-block relative object-cover object-center w-9 h-9 rounded-md"
                                                        alt="Default Profile Photo"> 
                                    <div>
                                <p
                                    class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold">
                                    </p>
                                <p class="block antialiased font-sans text-xs font-normal text-blue-gray-500">
                                    </p>
                            </div>
            </div>
            </span></li>
            <li class="sm:block md:block">
                <div class="drawer drawer-end p-0">
                    <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />

                    <label for="my-drawer-4" class=" btn btn-square btn-ghost">
                        <img class="w-8 h-8" src="https://img.icons8.com/ios-filled/50/4D4D4D/gears.png"
                            alt="gears" />
                    </label>

                    <div class="drawer-side">
                        <label for="my-drawer-4" aria-label="close sidebar"
                            class="drawer-overlay !bg-white/0 !opacity-100"></label>
                        <ul
                            class="menu rounded-xl drop-shadow-2xl bg-base-200 text-base-content gap-2 min-h-full w-80 p-4">
                            {{-- menu down --}}
                            <div x-data="{ isActive: false, open: false }">
                                <!-- active & hover classes 'bg-primary-100 dark:bg-primary' -->
                                <a href="#" @click="$event.preventDefault(); open = !open"
                                    class="flex items-center p-3 text-gray-900 transition-colors rounded-lg dark:text-light hover:bg-gray-600 hover:text-white active:bg-gray-800"
                                    :class="{ 'bg-gray-600 text-white': isActive || open }" role="button"
                                    aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                                    <div class="flex items-center -m-2 gap-2 p-1.5 ">
                                       
                                            <img src="{{ asset('https://pas.assalaamhypermarket.co.id/images/generalUser.png') }}"
                                                class="inline-block relative object-cover object-center w-9 h-9 rounded-md"
                                                alt="Default Profile Photo">
                                     
                                        <div>
                                            <p
                                                class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold">
                                                </p>
                                            <p
                                                class="block antialiased font-sans text-xs font-normal text-blue-gray-500">
                                               </p>
                                        </div>
                                    </div>
                                    <span aria-hidden="true" class="ml-auto">
                                        <!-- active class 'rotate-180' -->
                                        <svg class="w-4 h-4 transition-transform transform"
                                            :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </a>
                                <div x-show="open" class="mt-2 space-y-2 px-7" role="menu"
                                    aria-label="Authentication">
                                    <!-- active & hover classes 'text-gray-700 dark:text-light' -->
                                    <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
                                    <a href="" role="menuitem"
                                        class="block p-2 hover:bg-gray-600 hover:text-white text-sm text-gray-900 transition-colors duration-200 rounded-md dark:hover:text-light">
                                        Register
                                    </a>
                                    <a href="auth/login.html" role="menuitem"
                                        class="block p-2 hover:bg-gray-600 hover:text-white text-sm text-gray-900 transition-colors duration-200 rounded-md dark:hover:text-light">
                                        Login
                                    </a>
                                    <a href="auth/forgot-password.html" role="menuitem"
                                        class="block p-2 hover:bg-gray-600 hover:text-white text-sm text-gray-900 transition-colors duration-200 rounded-md dark:hover:text-light">
                                        Forgot Password
                                    </a>
                                    <a href="auth/reset-password.html" role="menuitem"
                                        class="block p-2 hover:bg-gray-600 hover:text-white text-sm text-gray-900 transition-colors duration-200 rounded-md dark:hover:text-light">
                                        Reset Password
                                    </a>
                                </div>
                            </div>
                            {{-- menu down --}}
                            <li>
                                {{-- <form method="POST" action="{{ route('logout') }}"> --}}
                                <a href="/logout" class="hover:bg-gray-600 hover:text-white">
                                    <div class="text-xl">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    </div>
                                    <p> Keluar </p>
                                </a>
                                {{-- </form> --}}
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            </ul>
        </div>
    </div>
</div>


{{-- Content --}}

<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
        </div>
        <div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
        </div>
        <div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </p>
            </div>
        </div>
    </div>
</div>
