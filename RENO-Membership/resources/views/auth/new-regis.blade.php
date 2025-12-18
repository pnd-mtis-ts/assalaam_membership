@include('include.htmlstart')
@include('include.sideadmin')

{{-- ===== MAIN CONTENT AREA ===== --}}
<div class="w-full sm:ml-64 bg-gray-100 min-h-screen flex flex-col items-center">

  {{-- Spacer untuk navbar (khusus mobile) --}}
  <div class="block lg:hidden h-20"></div>

  {{-- Container Utama --}}
  <div class="w-full max-w-6xl bg-white border border-gray-200 rounded-2xl shadow-md overflow-hidden flex flex-col lg:flex-row transition-all duration-300 my-6 mx-4 sm:mx-6">

    {{-- ===== LEFT IMAGE (DESKTOP) ===== --}}
    <div class="relative hidden lg:flex w-1/2 bg-gradient-to-br from-green-700 to-green-900">
      <img src="https://pas.assalaamhypermarket.co.id/images/assalamBg.png"
           alt="Background"
           class="absolute inset-0 w-full h-full object-cover opacity-60">
      <div class="relative z-10 flex flex-col items-center justify-center text-center p-10 text-white">
        <img src="https://pas.assalaamhypermarket.co.id/images/logo.png"
             alt="Logo"
             class="h-16 mb-5 drop-shadow-lg">
        <h2 class="text-3xl font-bold leading-snug drop-shadow-md">
          Tambah Akun Baru <br><span class="text-green-300">(Admin / CS)</span>
        </h2>
        <p class="mt-4 text-sm text-gray-200">Kelola akun dengan mudah di sistem Assalaam Hypermarket</p>
      </div>
    </div>

    {{-- ===== RIGHT FORM SECTION ===== --}}
    <div class="flex-1 flex items-start lg:items-center justify-center py-10 px-5 sm:px-10 bg-white">
      <div class="w-full max-w-md mt-6 sm:mt-0">

        {{-- Header (mobile only) --}}
        <div class="block lg:hidden text-center mb-8 mt-4">
          <h1 class="text-2xl font-bold text-gray-800">Tambah Akun Baru</h1>
          <p class="text-gray-500 text-sm">Admin / Customer Service</p>
        </div>

        {{-- ✅ FORM REGISTER --}}
        <form x-data="registerForm()" @submit.prevent="submitForm" class="space-y-5 bg-white">
          @csrf

          {{-- Nama --}}
          <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
            <input type="text" id="name" x-model="form.name" placeholder="Nama lengkap"
              class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
          </div>

          {{-- Email --}}
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" id="email" x-model="form.email" placeholder="Masukkan email"
              class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
          </div>

          {{-- Role --}}
          <div>
            <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
            <select id="role" x-model="form.role"
              class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition bg-white">
              <option value="" disabled selected>~ Pilih Role ~</option>
              <option value="admin">Admin</option>
              <option value="cs">Customer Service</option>
            </select>
          </div>

          {{-- Password --}}
          <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input type="password" id="password" x-model="form.password" placeholder="Masukkan password"
              class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
          </div>

          {{-- Konfirmasi Password --}}
          <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" x-model="form.password_confirmation" placeholder="Konfirmasi password"
              class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
          </div>

          {{-- Alert Message --}}
          <template x-if="message">
            <div :class="success ? 'text-green-700 bg-green-50 border border-green-200' : 'text-red-700 bg-red-50 border border-red-200'"
              class="p-3 rounded-lg font-medium text-sm transition">
              <p x-text="message"></p>
            </div>
          </template>

          {{-- Tombol Submit --}}
          <div>
            <button type="submit"
              class="w-full bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 active:scale-[.98] transition-all disabled:opacity-60"
              :disabled="loading">
              <span x-show="!loading">Buat Akun</span>
              <span x-show="loading">Menyimpan...</span>
            </button>
          </div>
        </form>

        {{-- Footer kecil --}}
        <p class="text-center text-gray-400 text-xs mt-6">© 2025 Assalaam Hypermarket. All rights reserved.</p>
      </div>
    </div>
  </div>
</div>

{{-- ===== SCRIPT ===== --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
  const API_URL        = "{{ api_url('/api/admin/register-cs') }}";
  function registerForm() {
    return {
      form: { name: '', email: '', password: '', password_confirmation: '', role: '' },
      message: '',
      success: false,
      loading: false,
      submitted: false,

      async submitForm() {
  if (this.loading || this.submitted) return; // cegah double click

  this.message = ''
  this.success = false
  this.loading = true
  this.submitted = true

        try {
          const token = localStorage.getItem('jwt_token_admin')
          if (!token) {
            this.message = 'Token admin tidak ditemukan. Silakan login terlebih dahulu.'
            return
          }

          const response = await axios.post(
            API_URL,
            this.form,
            {
              headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
              validateStatus: () => true
            }
          )

          let msg = 'Terjadi kesalahan pada proses registrasi.'
          let ok = false

          if (response.status === 200 || response.status === 201) {
            ok = true
            msg = response.data.message || 'Registrasi berhasil! Silakan cek email untuk verifikasi.'
            this.form = { name: '', email: '', password: '', password_confirmation: '', role: '' }
          } else if (response.status === 422) {
            msg = Object.values(response.data.errors || {}).flat().join(', ') || msg
          } else if (response.status === 403) {
            msg = 'Akses ditolak. Hanya admin yang dapat menambahkan akun baru.'
          } else if (response.data?.message) {
            msg = response.data.message
          }

          this.success = ok
          this.message = msg
        } catch (err) {
          console.error('🔥 Catch Error:', err)
          this.success = false
          this.message = 'Kesalahan tak terduga. Coba lagi nanti.'
        } finally {
          this.loading = false
          this.submitted = false
        }
      }
    }
  }
</script>

@include('include.htmlend')
