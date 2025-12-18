@include('include.htmlstart')
@include('include.sidebarstart')
<div class=" w-full  overflow-y-hidden sm:ml-64">
    {{-- Card Member --}}
    <div class="mt-24 p-3 sm:p-4 h-screen flex flex-col w-full gap-12">
        {{-- alert --}}


        @if (session('failed'))
        <div id="alert"
            class="-mt-6 flex items-center p-4 text-sm text-red-50 rounded-lg bg-rose-600 dark:bg-rose-600 dark:text-red-50"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Error!</span> {{ session('failed') }}
            </div>
            <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 bg-rose-700 text-red-50 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-rose-800 inline-flex items-center justify-center h-8 w-8"
                data-dismiss-target="#alert" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        @endif

        @if (session('successTransaction'))
        <div id="alert"
            class="-mt-4 flex items-center p-4 mb-4 text-sm text-green-50 rounded-lg bg-green-600 dark:bg-green-600 dark:text-green-50"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
            <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 bg-green-700 text-green-50 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-800 inline-flex items-center justify-center h-8 w-8"
                data-dismiss-target="#alert" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        @endif
        {{-- alert --}}
        <div class="relative flex flex-col mt-2 rounded-xl bg-gray-50 text-gray-700 dark:bg-gray-700 shadow-md">
            <div
                class=" bg-clip-border flex flex-row rounded-xl  bg-gradient-to-tr from-[#026631] to-[#22AA62] text-white shadow-gray-900/20 shadow-lg -mt-8 p-6 dark:bg-gradient-to-tr dark:from-[#F97300] dark:to-[#dc6f10]">
                <span
                    class="block text-xl antialiased flex-grow tracking-normal mt-1 justify-start font-sans font-semibold leading-relaxed text-white">
                    Data Customer</span>
                <div class="hidden md:block">
                    <form action="/import-transactions" method="post" enctype="multipart/form-data">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            @csrf
                            <input
                                class="block w-72 text-xs text-gray-900 border-2 border-lime-300 rounded-l-lg cursor-pointer bg-gray-50 dark:bg-gray-800 dark:border-gray-700 focus:ring-1 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-800 dark:focus:border-gray-800"
                                id="small_size" type="file" name="file">
                            <button type="submit"
                                class="px-3 py-2 text-sm font-medium text-center border-2 border-l-0 text-white bg-blue-800 rounded-r-lg hover:bg-blue-950 focus:ring-1 dark:border-gray-700 focus:outline-none focus:ring-blue-300 dark:focus:ring-gray-800 dark:bg-blue-600 dark:hover:bg-blue-700 ">Import</button>
                            @error('file')
                            <p>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex items-center ms-1.5 md:ms-2 mt-2 md:mt-0">
                <form action="/table-transaction" method="get">
                    <div class="flex items-center space-x-0 md:space-x-1">
                        <div class="relative group">
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                value="{{ request('tanggal_mulai') }}"
                                class="w-full px-4 py-1 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                        </div>
                        <p class="text-white">
                            -
                        </p>
                        <div class="relative group">
                            <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                                value="{{ request('tanggal_selesai') }}"
                                class="w-full px-4 py-1 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                        </div>
                        <button type="submit"
                            class="hidden md:block px-4 py-1.5 ml-2 bg-green-600 dark:bg-green-600 text-green-50 dark:text-green-50 hover:bg-green-700 dark:hover:bg-green-700 font-semibold rounded text-sm">
                            Filter
                        </button>
                    </div>
                    <button type="submit"
                        class="block md:hidden px-4 py-1.5 mt-2 w-full bg-green-600 dark:bg-green-600 text-green-50 dark:text-green-50 hover:bg-green-700 dark:hover:bg-green-700 font-semibold rounded text-sm">
                        Filter
                    </button>
                </form>
                <div class="hidden relative px-4 py-2 md:flex justify-end w-full items-center">
                    <form action="/table-transaction" method="get">
                        <div class="flex justify-center items-center">
                            <div class="sm:w-72 flex items-center relative">
                                <div class="relative sm:w-72 flex items-center">
                                    <!--<div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">-->
                                    <!--    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"-->
                                    <!--        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">-->
                                    <!--        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"-->
                                    <!--            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />-->
                                    <!--    </svg>-->
                                    <!--</div>-->
                                    <input type="search" name="search"
                                        class=" w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Cari" value="{{ request()->search ? request()->search : '' }}" />
                                    <button type="submit"
                                        class="text-white absolute end-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cari</button>
                                </div>
                            </div>
                    </form>
                    <a href="/table-transaction"
                        class="px-4 py-1.5 ml-2 bg-rose-600 dark:bg-rose-600 hover:bg-rose-700 dark:hover:bg-rose-700 text-rose-50 dark:text-rose-50 font-semibold rounded text-sm">
                        Reset
                    </a>
                </div>
            </div>
        </div>

        <div class="block md:hidden mt-2 md:mt-0">
            <div class="flex flex-col">
                <form action="/import-members" method="post" enctype="multipart/form-data">
                    <div class="inline-flex px-1 md:px-4 mb-4 rounded-md shadow-sm" role="group">
                        <input
                            class=" w-72 text-xs text-gray-900 border-2 border-lime-300 rounded-l-lg cursor-pointer bg-gray-50  dark:bg-gray-800 dark:border-gray-700 focus:ring-1 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-800 dark:focus:border-gray-800"
                            id="small_size" type="file">
                        <button type="submit"
                            class="px-3 py-2 text-sm font-medium text-center border-2 border-l-0 text-white bg-blue-700 rounded-r-lg hover:bg-blue-800 focus:ring-1 dark:border-gray-700 focus:outline-none focus:ring-blue-300 dark:focus:ring-gray-800 dark:bg-blue-600 dark:hover:bg-blue-700">Import</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="block md:hidden relative w-full mb-2 -mt-2">
            <div class="flex justify-center items-center w-full pe-2">
                <form action="/table-transaction" method="get" class="w-full px-2">
                    <div class="flex items-center relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" name="search"
                            class=" w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Cari" value="{{ request()->search ? request()->search : '' }}" />
                        <button type="submit"
                            class="text-white absolute end-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cari</button>
                    </div>
                </form>
                <a href="/table-transaction"
                    class="px-4 py-1.5 ml-2 bg-rose-600 dark:bg-rose-600 hover:bg-rose-700 dark:hover:bg-rose-700 text-rose-50 dark:text-rose-50 font-semibold rounded text-sm">
                    Reset
                </a>
            </div>
        </div>

        <div class="p-6 px-0 py-2 overflow-auto bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
            <table class="w-full min-w-[640px] table-auto">
                <thead>
                    <tr>
                        <th class="border-b border-gray-50 dark:border-gray-900 pb-2 px-5 text-left">
                            <p class="block antialiased font-sans text-[11px] font-bold uppercase text-blue-gray-400">
                                Nama</p>
                        </th>
                        <th class="border-b dark:border-gray-900 py-2 px-5 text-left">
                            <p class="block antialiased font-sans text-[11px] font-bold uppercase text-blue-gray-400">
                                No. Transaksi</p>
                        </th>
                        <th class="border-b dark:border-gray-900 py-2 px-5 text-left">
                            <p class="block antialiased font-sans text-[11px] font-bold uppercase text-blue-gray-400">
                                No. Member</p>
                        </th>
                        <th class="border-b dark:border-gray-900 py-2 px-5 text-left">
                            <p class="block antialiased font-sans text-[11px] font-bold uppercase text-blue-gray-400">
                                Tanggal</p>
                        </th>
                        <th class="border-b dark:border-gray-900 py-2 px-5 text-left">
                            <p class="block antialiased font-sans text-[11px] font-bold uppercase text-blue-gray-400">
                                Total Transaksi</p>
                        </th>
                        <th class="border-b dark:border-gray-900 py-2 px-5 text-left">
                            <p class="block antialiased font-sans text-[11px] font-bold uppercase text-blue-gray-400">
                                Poin</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                    <tr>
                        <td class="py-2 px-5 border-b dark:border-gray-900">
                            <p
                                class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold">
                                {{ $transaction->member->nama }}
                            </p>
                        </td>
                        <td class="py-2 px-5 border-b dark:border-gray-900">
                            <p class="block antialiased font-sans text-xs font-semibold text-blue-gray-600">
                                {{ $transaction->trans_no }}
                            </p>
                        </td>
                        <td class="py-2 px-5 border-b dark:border-gray-900">
                            <p class="block antialiased font-sans text-xs font-semibold text-blue-gray-600">
                                {{ $transaction->member_card_no }}
                            </p>
                        </td>
                        <td class="py-2 px-5 border-b dark:border-gray-900">
                            <p class="block antialiased font-sans text-xs font-semibold text-blue-gray-600">
                                {{ $transaction->trans_date }}
                            </p>
                        </td>
                        <td class="py-2 px-5 border-b dark:border-gray-900">
                            <p class="block antialiased font-sans text-xs font-semibold text-blue-gray-600">
                                {{-- @currency($transaction->trans_total_transaction) --}}
                                {{ Number::currency($transaction->trans_total_transaction, 'IDR', 'id') }}
                            </p>
                        </td>
                        <td class="py-2 px-5 border-b dark:border-gray-900">
                            <p class="block antialiased font-sans text-xs font-semibold text-blue-gray-600">
                                {{ $transaction->trans_poin_pas }} poin
                            </p>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-2 px-4 py-2 text-sm ">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
{{-- Card Member --}}
</div>

@include('include.htmlend')