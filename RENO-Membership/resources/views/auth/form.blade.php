@include('include.htmlstart')
@include('include.sidemember')

<div class=" w-full sm:ml-64">
    <div class="min-h-screen py-12 mt-10 px-4 sm:px-4 lg:px-6">
        <div class="max-w-6xl mx-auto">
            <!-- Form Header -->
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Registrasi PAS Member</h2>
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

                <form action="" method="POST" class="p-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <!-- Section: Personal Information -->
                    <div class="mb-10">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                            <span
                                class="bg-green-500 dark:bg-[#F97300] text-white  rounded-full w-8 h-8 flex items-center justify-center mr-3">1</span>
                            Personal Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {{-- Nama --}}
                            <div class="relative group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                    Lengkap</label>
                                <div class="relative">
                                    <input type="text" name="nama" id="nama" required value="{{ old('nama') }}"
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                        placeholder="Masukan Nama Lengkap">
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    @error('nama')
                                    <p class="text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>

                            {{-- No Member --}}
                            <div class="relative group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No
                                    Member</label>
                                <div class="relative">
                                    <input type="text" id="no_member" name="no_member" value="{{ old('no_member') }}"
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                        placeholder="Masukan No. Member">
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pt-1 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                        <i class="w-5 h-5 fa-regular fa-credit-card"></i>
                                    </div>
                                    @error('no_member')
                                    <p class="text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tgl Lahir --}}
                            <div class="relative group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                    Lahir</label>
                                <input type="date" value="{{ old('tanggal_lahir') }}" id="tanggal_lahir"
                                    name="tanggal_lahir"
                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-4 gap-6">
                            <!-- Tempat Lahir -->
                            <div class="relative group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tempat
                                    Lahir</label>
                                <div class="relative">
                                    <input type="text" id="tempat_lahir" name="tempat_lahir"
                                        value="{{ old('tempat_lahir') }}"
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                        placeholder="Masukan Tempat Lahir">
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                        <i class="w-5 h-5 pt-0.5 fa-solid fa-earth-asia"></i>
                                    </div>
                                </div>
                                @error('tempat_lahir')
                                <p class="text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- No Identitas -->
                            <div class="relative group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No
                                    Identitas</label>
                                <div class="relative">
                                    <input type="text" id="no_identitas" name="no_identitas"
                                        value="{{ old('no_identitas') }}"
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                        placeholder="Masukan No. Identitas">
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                        <i class="h-5 w-5 pt-0.5 fa-regular fa-address-card"></i>
                                    </div>
                                </div>
                                @error('no_identitas')
                                <p class="text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                            {{-- Gender --}}
                            <div class="relative group">
                                <label for="jenis_kelamin"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis
                                    Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="w-full select rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                                    <option selected disabled>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                <p class="text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-4 gap-6">
                            <!-- Status -->
                            <div class="relative group">
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                <div class="relative">
                                    <select name="status" id="status"
                                        class="w-full select rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                                        <option value="">Pilih Status</option>
                                        <option value="lajang">Lajang</option>
                                        <option value="menikah">Menikah</option>
                                    </select>
                                    @error('status')
                                    <p class="text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Agama -->
                            <div class="relative group">
                                <label for="agama"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Agama</label>
                                <div class="relative">
                                    <select name="agama" id="agama"
                                        class="w-full select rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                                        <option selected disabled>Pilih Agama</option>
                                        <option value="ISLAM">Islam</option>
                                        <option value="HINDU">Hindu</option>
                                        <option value="BUDHA">Budha</option>
                                        <option value="KATOLIK">Katolik</option>
                                        <option value="KRISTEN">Kristen</option>
                                        <option value="KONGHUCU">Konghucu</option>
                                    </select>
                                    @error('agama')
                                    <p class="text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            {{-- Kewarganegaraan --}}
                            <div class="relative group">
                                <label for="kewarganegaraan"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                    for="kewarganegaraan">Kewarganegaraan</label>
                                <select name="kewarganegaraan" id="kewarganegaraan"
                                    class="w-full select rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]">
                                    <option selected disabled>Pilih Kewarganegaraan</option>
                                    <option value="wni">WNI (Warga Negara Indonesia)</option>
                                    <option value="wna">WNA (Warga Negara Asing)</option>
                                </select>
                                @error('kewarganegaraan')
                                <p class="text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                            <span
                                class="bg-green-400 dark:bg-[#EF6C00] text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">2</span>
                            Kontak Informasi
                        </h3>

                        <div class="space-y-6">
                            {{-- Alamat --}}
                            <div class="relative group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat
                                    Lengkap</label>
                                <input type="text" id="alamat" name="alamat" rows="3" value="{{ old('alamat') }}"
                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                    placeholder="Masukan Alamat Lengkap"></input>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                    <i class="w-5 h-5 pt-3 fa-solid fa-map-location-dot"></i>
                                </div>
                            </div>
                            @error('alamat')
                            <p class="text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                            {{-- RT RW --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="relative group">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">RT /
                                        RW</label>
                                    <div class="relative">
                                        <input type="text" id="rt_rw" name="rt_rw" value="{{ old('rt_rw') }}"
                                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                            placeholder="Masukan RT / RW">
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                            <i class="w-5 h-5 pt-0.5 fa-solid fa-mountain-city"></i>
                                        </div>
                                    </div>
                                    @error('rt_rw')
                                    <p class="text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                {{-- Kelurahan --}}
                                <div class="relative group">
                                    <label for="kelurahan"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelurahan</label>
                                    <div class="relative">
                                        <input type="kelurahan" name="kelurahan" value="{{ old('kelurahan') }}"
                                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                            placeholder="Masukan Kelurahan">
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                            <i class="w-5 h-5 pt-0.5 fa-solid fa-building-user"></i>
                                        </div>
                                    </div>
                                    @error('kelurahan')
                                    <p class="text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                {{-- Kecamatan --}}
                                <div class="relative group">
                                    <label for="kecamatan"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kecamatan</label>
                                    <div class="relative">
                                        <input type="text" name="kecamatan" id="kecamatan"
                                            value="{{ old('kecamatan') }}"
                                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                            placeholder="Masukan Kecamatan">
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                            <i class="w-5 h-5 pt-[4px] fa-solid fa-building"></i>
                                        </div>
                                    </div>
                                    @error('kecamatan')
                                    <p class="text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            {{-- Kota --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative group">
                                    <label for="kota"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kota</label>
                                    <div class="relative">
                                        <input type="text" id="kota" name="kota" value="{{ old('kota') }}"
                                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                            placeholder="Masukan Kota">
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                            <i class="w-5 h-5 pt-0.5 fa-solid fa-city"></i>
                                        </div>
                                    </div>

                                    @error('kota')
                                    <p class="text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                {{-- Kode Pos --}}
                                <div class="relative group">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode
                                        Pos</label>
                                    <div class="relative">
                                        <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}"
                                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                            placeholder="Masukan Kode Pos">
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                            <i class="w-5 h-5 pt-[4px] fa-solid fa-envelopes-bulk"></i>
                                        </div>
                                    </div>
                                    @error('kode_pos')
                                    <p class="text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Additional Information -->
                    <div class="mb-10">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                            <span
                                class="bg-green-400/90 dark:bg-[#FFA726] text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">3</span>
                            Informasi Tambahan
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- No Hp --}}
                            <div class="relative group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Hp /
                                    WA</label>
                                <div class="relative">
                                    <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                        placeholder="Masukan No. Hp">
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('no_hp')
                                <p class="text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                            {{-- jumlah tanggungan --}}
                            <div class="relative group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah
                                    Tanggungan</label>
                                <div class="relative">
                                    <input type="text" id="jumlah_tanggungan" name="jumlah_tanggungan"
                                        value="{{ old('jumlah_tanggungan') }}"
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                        placeholder="Masukan Jumlah Tanggungan">
                                </div>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                    <i class="w-5 h-5 pt-[14px] fa-solid fa-hand-holding-dollar"></i>
                                </div>
                                @error('tanggungan')
                                <p class="text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            {{-- pendapatan perbulan --}}
                            <div class="relative group">
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pendapatan
                                    Perbulan</label>
                                <div class="relative">
                                    <input type="text" id="pendapatan" name="pendapatan" value="{{ old('pendapatam') }}"
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                        placeholder="Masukkan Pendapatan">
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500 dark:group-hover:text-[#F97300]">
                                        <i class="w-5 h-5 pt-[4px] fa-solid fa-wallet"></i>
                                    </div>
                                </div>
                                @error('pendapatan')
                                <p class="text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:flex md:justify-between pt-4 md:pt-5 gap-4">
                            {{-- Pajak --}}
                            <div class="relative md:w-1/4 group">
                                <label for=""
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pengusaha
                                    Kena
                                    Pajak</label>
                                <div class="flex justify-start">
                                    <div class="flex items-center">
                                        <div class="flex px-4 py-3  items-center me-4">
                                            <input id="yesValidation" type="radio" value="1" name="validation"
                                                class="w-4 h-4 text-green-600 dark:text-[#F97300] bg-gray-100 border-gray-300">
                                            <label for="yesValidation"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="flex items-center me-4">
                                            <input id="noValidation" type="radio" value="0" name="validation"
                                                class="w-4 h-4 text-green-600 dark:text-[#F97300] bg-gray-100 border-gray-300">
                                            <label for="noValidation"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 ">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('validation')
                                <p class="text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                            {{-- NPWP --}}
                            <div class="relative md:w-full group">
                                <label
                                    class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-1">NPWP</label>
                                <input type="text" id="npwp" name="npwp" value="{{ old('npwp') }}"
                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-all duration-200 outline-none dark:bg-gray-800 dark:border-gray-400/50 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#F97300] dark:focus:border-[#F97300]"
                                    placeholder="Masukan No. NPWP">
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-hover:text-green-500">
                                    <i
                                        class="w-5 h-5 pt-[14px] fa-solid fa-credit-card dark:group-hover:text-[#F97300]"></i>
                                </div>
                            </div>
                            @error('npwp')
                            <p class="text-red-500">
                                {{ $message }}
                            </p>
                            @enderror
                            <div class="relative md:w-full group">
                                <label for="file"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto
                                    Profil</label>
                                <div class="relative text-xs flex items-center">
                                    <input type="file" name="file" value="{{ old('file') }}"
                                        class="file-input file-input-primary border-2 text-sm text-gray-400 border-gray-300 dark:border-gray-400/50 rounded-md focus:outline-green-600 dark:focus:outline-[#F97300] file-input-bordered w-full dark:focus:ring-[#F97300] " />
                                </div>
                            </div>
                            @error('file')
                            <p class="text-red-500">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                    <!-- Form Actions -->
                    <div class="flex flex-wrap justify-end gap-4 pt-6 border-t border-gray-100">
                        <button type="submit"
                            class="px-8 py-3 font-semibold rounded-lg bg-green-600 dark:bg-[#F97300] dark:hover:bg-[#de6801] text-white hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-all duration-200">
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
@include('include.htmlend')