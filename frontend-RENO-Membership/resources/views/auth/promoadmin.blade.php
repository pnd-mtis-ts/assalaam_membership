@include('include.htmlstart')
@include('include.sideadmin')

<body class="font-[sans-serif] bg-gray-50 dark:bg-gray-900">

  <div class="w-full sm:ml-64">
    <div class="mt-20 p-4 sm:p-6 max-w-6xl mx-auto">

      <!-- Header -->
      <div class="text-center mb-8 sm:mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold bg-green-500 text-transparent bg-clip-text">
          Manajemen Promo
        </h1>
        <p class="text-gray-500 mt-2">Kelola gambar promo untuk toko Anda dengan mudah</p>
      </div>

      <!-- Upload Card -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-5 sm:p-8 mb-10 transition-all">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Upload Promo Baru</h2>

        <form id="promoForm" enctype="multipart/form-data" class="space-y-4">
          <!-- Judul -->
          <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Judul Promo</label>
            <input type="text" id="promoTitle" name="judul"
              class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
              placeholder="Masukkan judul promo" required>
          </div>

          <!-- Deskripsi -->
          <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Deskripsi Promo</label>
            <textarea id="promoDesc" name="deskripsi" rows="3"
              class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
              placeholder="Masukkan deskripsi singkat" required></textarea>
          </div>

          <!-- Tanggal Berakhir -->
          <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Tanggal Berakhir</label>
            <input type="date" id="promoEnd" name="tanggal_berakhir"
              class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
              required>
          </div>

          <!-- Upload Gambar -->
          <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center hover:border-green-500 transition cursor-pointer relative">
            <input type="file" id="fileInput" name="image" accept=".webp,.jpg,.jpeg,.png" hidden />
            
            <!-- Preview Gambar -->
            <img id="previewImage" class="w-48 h-48 object-cover mb-3 rounded-md hidden" alt="Preview Promo">

            <label for="fileInput" class="flex flex-col items-center text-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mb-3" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 16.5v.75A2.25 2.25 0 0 0 5.25 19.5h13.5A2.25 2.25 0 0 0 21 17.25v-.75m-9-12v12m0 0l-3.75-3.75M12 16.5l3.75-3.75" />
              </svg>
              <span class="text-gray-700 dark:text-gray-200 font-medium" id="fileLabel">Pilih gambar promo</span>
              <span class="text-gray-400 text-sm mt-1">Format: JPG, PNG, WebP (Maks. 5MB)</span>
            </label>
          </div>

          <button type="submit" id="uploadBtn"
            class="w-full bg-green-500 text-white py-2.5 rounded-lg font-semibold hover:opacity-90 transition">
            Upload Promo
          </button>

          <div id="messageBox" class="hidden mt-4 p-3 rounded-lg text-center font-medium"></div>
        </form>
      </div>

      <!-- Daftar Promo -->
      <div id="promoContainer" class="grid lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6"></div>

      <!-- Empty State -->
      <div id="emptyState" class="hidden text-center mt-10">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" stroke="currentColor"
          stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
          class="mx-auto text-gray-400 mb-3">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
          <circle cx="8.5" cy="8.5" r="1.5"></circle>
          <polyline points="21 15 16 10 5 21"></polyline>
        </svg>
        <h3 class="text-gray-600 font-semibold">Belum ada promo</h3>
        <p class="text-gray-400">Upload gambar promo pertama Anda untuk ditampilkan di sini.</p>
      </div>
    </div>
  </div>

 <script>
document.addEventListener("DOMContentLoaded", () => {
  const adminToken = localStorage.getItem('jwt_token_admin');
  const csToken = localStorage.getItem('jwt_token_cs');
  const token = adminToken || csToken;

  const BASE_URL = "{{ config('services.api.base_url', 'http://127.0.0.1:8001') }}";
  const apiUrl = `${BASE_URL}/api/admin/promo`;
  const apiSave = `${BASE_URL}/api/admin/promo-save`;

  const fileInput = document.getElementById('fileInput');
  const fileLabel = document.getElementById('fileLabel');
  const uploadBtn = document.getElementById('uploadBtn');
  const messageBox = document.getElementById('messageBox');
  const promoContainer = document.getElementById('promoContainer');
  const emptyState = document.getElementById('emptyState');
  const previewImage = document.getElementById('previewImage');
  const promoTitle = document.getElementById('promoTitle');
  const promoDesc = document.getElementById('promoDesc');
  const promoEnd = document.getElementById('promoEnd');

  if (token) fetchPromos();

  fileInput.addEventListener('change', handleFileChange);
  document.getElementById('promoForm').addEventListener('submit', handleUpload);

  async function handleFileChange() {
    const file = fileInput.files[0];
    if (!file) return;

    // Maksimum 2MB
    const MAX_SIZE = 2 * 1024 * 1024;

    let finalFile = file;
    if (file.size > MAX_SIZE) {
      showMessage("Gambar terlalu besar (>2MB), sedang dikompres otomatis...", false);
      finalFile = await compressImage(file, MAX_SIZE);
      showMessage("Gambar telah berhasil dikompres di bawah 2MB.", true);
    }

    // Update input file dengan hasil kompres
    const dt = new DataTransfer();
    dt.items.add(finalFile);
    fileInput.files = dt.files;

    fileLabel.textContent = finalFile.name;

    // Tampilkan preview
    const reader = new FileReader();
    reader.onload = e => {
      previewImage.src = e.target.result;
      previewImage.classList.remove('hidden');
    };
    reader.readAsDataURL(finalFile);
  }

  async function handleUpload(e) {
    e.preventDefault();

    if (!fileInput.files[0] || !promoTitle.value.trim() || !promoDesc.value.trim() || !promoEnd.value.trim()) {
      alert("Semua field harus diisi.");
      return;
    }

    uploadBtn.disabled = true;
    uploadBtn.textContent = 'Mengupload...';
    messageBox.classList.add('hidden');

    const formData = new FormData();
    formData.append('image', fileInput.files[0]);
    formData.append('judul', promoTitle.value);
    formData.append('deskripsi', promoDesc.value);
    formData.append('tanggal_berakhir', promoEnd.value);

    try {
      const res = await fetch(apiSave, {
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token },
        body: formData
      });

      const data = await res.json();
      showMessage(data.message || 'Upload berhasil!', true);
      resetForm();
      fetchPromos();
    } catch (err) {
      console.error(err);
      showMessage('Upload gagal!', false);
    } finally {
      uploadBtn.disabled = false;
      uploadBtn.textContent = 'Upload Promo';
    }
  }

  async function fetchPromos() {
    try {
      const res = await fetch(apiUrl, { headers: { 'Authorization': 'Bearer ' + token } });
      const result = await res.json();
      const promos = Array.isArray(result.data) ? result.data : [];

      promoContainer.innerHTML = '';
      if (!promos.length) {
        emptyState.classList.remove('hidden');
        return;
      }
      emptyState.classList.add('hidden');

      promos.forEach(promo => {
        const card = document.createElement('div');
        card.className = 'bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden relative group transition hover:shadow-2xl';
        const endDate = formatDate(promo.tanggal_berakhir);

        card.innerHTML = `
          <img src="${BASE_URL}/storage/${promo.path}" class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">${promo.judul}</h3>
            <p class="text-gray-600 dark:text-gray-400 mt-1">${promo.deskripsi || ''}</p>
            <p class="text-sm text-gray-400 mt-2">Berakhir: ${endDate}</p>
          </div>
          <button onclick="deletePromo(${promo.id})"
            class="absolute top-2 right-2 bg-green-500 hover:bg-black text-white px-3 py-1 rounded-lg text-sm font-medium opacity-0 group-hover:opacity-100 transition">
            Hapus
          </button>
        `;
        promoContainer.appendChild(card);
      });
    } catch (err) {
      console.error(err);
      promoContainer.innerHTML = '';
      emptyState.classList.remove('hidden');
    }
  }

  window.deletePromo = async function(id) {
    if (!confirm('Yakin ingin hapus promo ini?')) return;
    try {
      await fetch(`${apiUrl}/${id}`, {
        method: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token }
      });
      fetchPromos();
    } catch (err) {
      console.error(err);
      alert('Gagal menghapus promo.');
    }
  };

  function resetForm() {
    fileInput.value = '';
    fileLabel.textContent = 'Pilih gambar promo';
    resetPreview();
    promoTitle.value = '';
    promoDesc.value = '';
    promoEnd.value = '';
  }

  function resetPreview() {
    previewImage.src = '';
    previewImage.classList.add('hidden');
  }

  function showMessage(msg, success = true) {
    messageBox.textContent = msg;
    messageBox.className = `mt-4 p-3 rounded-lg text-center ${
      success
        ? 'text-green-700 bg-green-100 border border-green-300'
        : 'text-red-700 bg-red-100 border border-red-300'
    }`;
    messageBox.classList.remove('hidden');
  }

  function formatDate(dateStr) {
    if (!dateStr) return '-';
    const date = new Date(dateStr);
    if (isNaN(date)) return '-';
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
  }

  async function compressImage(file, maxSize) {
    return new Promise(resolve => {
      const reader = new FileReader();
      reader.onload = e => {
        const img = new Image();
        img.src = e.target.result;
        img.onload = () => {
          const canvas = document.createElement('canvas');
          const ctx = canvas.getContext('2d');

          let quality = 0.9;
          let width = img.width;
          let height = img.height;

          const process = () => {
            canvas.width = width;
            canvas.height = height;
            ctx.drawImage(img, 0, 0, width, height);

            canvas.toBlob(async blob => {
              if (blob.size > maxSize && quality > 0.3) {
                // Kurangi kualitas & ukuran sampai di bawah batas
                quality -= 0.1;
                width *= 0.9;
                height *= 0.9;
                process();
              } else {
                resolve(new File([blob], file.name, { type: file.type }));
              }
            }, file.type, quality);
          };
          process();
        };
      };
      reader.readAsDataURL(file);
    });
  }
});
</script>
include('include.htmlend')