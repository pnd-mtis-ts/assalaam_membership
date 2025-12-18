@include('include.htmlstart')
@include('include.sidebarstart')

<div class=" w-full overflow-y-hidden sm:ml-64">
    {{-- Card Member --}}
    <div class="mt-24 p-3 sm:p-2 flex flex-col w-full gap-6">

        @if (session('successMember'))
            <div id="alert"
                class="-mt-6 flex items-center p-4 mb-4 text-sm text-green-50 rounded-lg bg-green-600 dark:bg-green-600 dark:text-green-50"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Success!</span> {{ session('successMember') }}
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

        @if (session('failed'))
            <div id="alert"
                class="-mt-6 flex items-center p-4 mb-4 text-sm text-red-50 rounded-lg bg-rose-600 dark:bg-rose-600 dark:text-red-50"
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

        @if (session('error_import'))
            <div id="alert-error-import"
                class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-lg font-medium">Konfirmasi!</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    {{ session('error_import') }}
                    <p>Apakah anda yakin ingin memperbarui semua data member yang sudah ada?</p>
                </div>
                <div class="flex">
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="existing_members"
                            value="{{ json_encode(session('existing_members')) }}">
                        <button type="submit"
                            class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            <svg class="me-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 14">
                                <path
                                    d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                            </svg>
                            Ya, saya yakin
                        </button>
                    </form>
                    <button type="button"
                        class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800"
                        aria-label="Close" onclick="document.getElementById('alert-error-import').style.display='none'">
                        Batal
                    </button>
                </div>
            </div>
        @endif

        <div class="relative flex flex-col rounded-xl bg-gray-50 text-gray-700 dark:bg-gray-700 shadow-md">
            <div
                class=" bg-clip-border flex flex-row rounded-xl  bg-gradient-to-tr from-[#026631] to-[#22AA62] text-white shadow-gray-900/20 shadow-lg -mt-6 p-6 dark:bg-gradient-to-tr dark:from-[#F97300] dark:to-[#dc6f10]">
                <span
                    class="block
                text-xl antialiased flex-grow tracking-normal mt-1 justify-start font-sans font-semibold leading-relaxed
                text-white">
                    Data PAS Member</span>
                <div class="hidden sm:block">
                    <form action="/import-members" method="post" enctype="multipart/form-data">
                        <div class="block space-y-1">
                            <div class="flex justify-between">
                                <label class="text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Replace Data
                                </label>
                                <div class="flex justify-end">
                                    <div class="flex items-center me-4">
                                        <input id="false" type="radio" value="0" name="reset_table"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                            checked>
                                        <label for="false"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Tidak
                                        </label>
                                    </div>
                                    <div class="flex items-center me-4">
                                        <input id="true" type="radio" value="1" name="reset_table"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="true"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Ya
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                @csrf
                                <input
                                    class="block w-72 text-xs text-gray-900 border-2 border-lime-300 rounded-l-lg cursor-pointer bg-gray-50 dark:bg-gray-800 dark:border-gray-700 focus:ring-1 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-800 dark:focus:border-gray-800"
                                    id="small_size" type="file" name="file">
                                <button type="submit"
                                    class="px-3 py-2 text-sm font-medium text-center border-2 border-l-0 text-white bg-blue-800 rounded-r-lg hover:bg-blue-950 focus:ring-1 dark:border-gray-700 focus:outline-none focus:ring-blue-300 dark:focus:ring-gray-800 dark:bg-blue-600 dark:hover:bg-blue-700 ">Import</button>
                            </div>
                            @error('file')
                                <p class="text-gray-50 text-xs font-semibold">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex items-center me-2">
                <div class="relative px-2 py-2 flex justify-end w-full">
                    <form class="w-full sm:w-auto" action="/table" method="GET">
                        <div class="relative sm:w-[302px] flex items-center">
                            {{-- <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div> --}}
                            <input type="search" name="search"
                                class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Cari" value="{{ request()->search ? request()->search : '' }}" />
                            <button type="submit"
                                class="text-white absolute end-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cari</button>
                        </div>
                    </form>

                </div>
                <a href="/table"
                    class="px-4 py-2 bg-rose-600 dark:bg-rose-600 text-rose-50 dark:text-rose-50 font-semibold rounded-lg text-sm">
                    Reset
                </a>
            </div>
            <div class="block sm:hidden">
                <div class="flex flex-col">

                    <form action="/import-members" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="inline-flex mb-4 ms-1.5 rounded-md shadow-sm" role="group">
                            <input
                                class=" w-72 text-xs text-gray-900 border-2 border-lime-300 rounded-l-lg cursor-pointer bg-gray-50  dark:bg-gray-800 dark:border-gray-700 focus:ring-1 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-800 dark:focus:border-gray-800"
                                id="small_size" type="file">
                            <button type="submit"
                                class="px-2 py-2 text-sm font-medium text-center border-2 border-l-0 text-white bg-blue-700 rounded-r-lg hover:bg-blue-800 focus:ring-1 dark:border-gray-700 focus:outline-none focus:ring-blue-300 dark:focus:ring-gray-800 dark:bg-blue-600 dark:hover:bg-blue-700">Import</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg  dark:text-gray-200">

                <table
                    class="w-full min-w-[640px] table-auto  text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <p
                                    class="block antialiased font-sans text-[11px] font-bold uppercase text-blue-gray-400">
                                    Nama</p>
                            </th>
                            <th scope="col" class="px-6 py-3">

                                No. Member
                            </th>
                            <th scope="col" class="px-6 py-3">

                                Tanggal Lahir
                            </th>
                            <th scope="col" class="px-6 py-3">

                                Aktif Sampai
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status Member
                            </th>
                            <th scope="col" class="px-6 py-3">

                                Aksi

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $member as $member )
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800
                            border-b dark:border-gray-700">
                            <td scope="row"
                                class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="flex items-center gap-4">
                                    @if ($member->member_profile)
                                        <img src="{{ asset('storage/member-profile/' . $member->member_profile) }}"
                                            alt="{{ $member->nama }}"
                                            class="inline-block relative  object-cover object-center w-9 h-9 rounded-full">
                                    @else
                                        <img src="https://img.icons8.com/3d-fluency/50/person-male--v7.png"
                                            class="inline-block relative object-cover object-center w-9 h-9 rounded-full"
                                            alt="Default Profile Photo">
                                    @endif
                                    <div>
                                        <p
                                            class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold">
                                            {{ $member['nama'] }}</p>
                                        <p
                                            class="block antialiased font-sans text-xs font-normal text-blue-gray-500">
                                            {{ $member['no_identitas'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p
                                    class="relative grid items-center font-sans whitespace-nowrap bg-gradient-to-tr from-green-600 to-green-400 text-white rounded-lg py-0.5 px-2 text-[11px] font-medium w-fit">
                                    {{ $member['no_member'] }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="block antialiased font-sans text-xs font-semibold text-blue-gray-600">
                                     {{ \Carbon\Carbon::parse($member['tanggal_lahir'])->format('d-m-Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="block antialiased font-sans text-xs font-semibold text-blue-gray-600">
                                    {{ \Carbon\Carbon::parse($member->active_end)->format('d-m-Y') }}</p>
                            </td>
                            <td class="px-6 py-4">

                                <form action="/update-member-status" method="post">
                                    @csrf
                                    <input type="hidden" value="{{ $member->id }}" name="id_member">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="1" class="sr-only peer"
                                            {{ $member->is_active ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <div
                                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300  rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all  peer-checked:bg-green-400">
                                        </div>
                                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-200">
                                            {{ $member->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </label>
                                </form>

                            </td>
                            <td class="py-4 px-6 flex flex-row gap-2 ">
                                <a type="button"
                                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-2 py-2.5 text-center  mb-2"
                                    href="/form/edit/{{ $member->id }}">Edit</a>

                                <div x-data="{ open: false }" class="inline">
                                    <!-- Trigger Button -->
                                    {{-- <button 
                                        class="btn btn-square bg-gradient-to-tr from-rose-700 to-rose-600">
                                        hapus
                                    </button> --}}
                                    <button type="button" @click="open = true"
                                        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-2 py-2.5 text-center me-2 mb-2">Hapus</button>

                                    <!-- Modal -->
                                    <div x-show="open" x-cloak class="fixed inset-0 z-50  overflow-y-auto"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                                        <!-- Overlay -->
                                        <div class="fixed inset-0 bg-black opacity-50"></div>

                                        <!-- Modal Content -->
                                        <div class="relative min-h-screen  flex items-center justify-center p-4">
                                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                                <!-- Modal content -->
                                                <div
                                                    class="relative p-4 text-center card dark:bg-gray-800 rounded-lg shadow  sm:p-5">
                                                    <button type="button"
                                                        class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        @click="open = false">
                                                        <svg aria-hidden="true" class="w-5 h-5"
                                                            fill="currentColor" viewBox="0 0 20 20"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto"
                                                        aria-hidden="true" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <p class="mb-4 text-gray-500 dark:text-gray-300">
                                                        Apakah anda yakin akan menghapus member
                                                        "{{ $member->nama }}"?
                                                    </p>
                                                    <div class="flex justify-center items-center space-x-4">
                                                        <button type="button"
                                                            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200  focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-700 dark:border-gray-500 dark:hover:text-gray-900 dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                                                            @click="open = false">
                                                            Tidak, Batalkan
                                                        </button>
                                                        <form action="/member/delete/{{ $member->id }}"
                                                            method="get">
                                                            @csrf
                                                            <button type="submit"
                                                                class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                                Ya, Saya Yakin
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-2 px-4 py-2 text-sm ">
                
            </div>
        </div>
    </div>
    {{-- Card Member --}}
</div>

@include('include.htmlend')
