@include('include.htmlstart')
@include('include.sidecs')

<div class="w-full sm:ml-64">
  <div class="mt-24 p-3 sm:p-6 flex flex-col min-h-screen w-full gap-6">

    <!-- Header -->
    <div
      class="flex flex-row justify-between items-center rounded-xl bg-gradient-to-tr from-[oklch(97% 0 0)] to-[#22AA62] text-white shadow-md -mt-6 p-6 dark:bg-gradient-to-tr dark:from-[#F97300] dark:to-[#dc6f10]">
      <span class="block text-lg sm:text-xl font-semibold text-zinc-950">Daftar Akun User</span>
    </div>

    <!-- Toggle Filter -->
    <div class="flex justify-center gap-3 mb-4">
      <button id="btnAll" class="px-4 py-2 rounded-lg font-semibold transition-all shadow">Semua</button>
      <button id="btnVerified" class="px-4 py-2 rounded-lg font-semibold transition-all shadow">Sudah Verifikasi</button>
      <button id="btnUnverified" class="px-4 py-2 rounded-lg font-semibold transition-all shadow">Belum Verifikasi</button>
    </div>

    <!-- 🔍 Search -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
      <div class="flex flex-wrap gap-2 w-full sm:w-auto">
        <input id="searchName" type="text" placeholder="Cari nama atau email..."
          class="px-4 py-2 border rounded-lg w-full sm:w-64 focus:ring-2 focus:ring-green-400 outline-none">
      </div>
      <button id="btnClearSearch"
        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-all">
        Reset
      </button>
    </div>

    <!-- Table Container -->
    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg shadow-md p-2 md:p-0">
      <table class="w-full table-auto text-xs sm:text-sm md:text-base hidden md:table">
        <thead id="tableHead"
          class="bg-green-100 dark:bg-green-800 dark:text-gray-200 transition-colors duration-300">
          <tr>
            <th class="border-b py-3 px-4 text-left">Nama</th>
            <th class="border-b py-3 px-4 text-left">Email</th>
            <th class="border-b py-3 px-4 text-center">Status</th>
          </tr>
        </thead>
        <tbody id="userTableDesktop" class="dark:text-gray-200"></tbody>
      </table>

      <!-- Mobile Card -->
      <div id="userTableMobile" class="flex flex-col gap-4 md:hidden"></div>

      <!-- Pagination -->
      <div id="pagination" class="flex justify-center items-center gap-2 mt-6 mb-4"></div>
    </div>

  </div>
</div>
<style>
  #cssLoader {
    animation: hideLoader 1s ease forwards;
    animation-delay: 0.7s; /* lama loading di layar */
  }

  @keyframes hideLoader {
    to {
      opacity: 0;
      visibility: hidden;
    }
  }
</style>

<!-- CSS ONLY LOADING OVERLAY -->
<div 
  id="cssLoader"
  class="fixed inset-0 bg-black bg-opacity-50 
         flex items-center justify-center 
         z-[9999] opacity-100">

  <div class="w-14 h-14 border-4 border-gray-300 border-t-green-500 
              rounded-full animate-spin"></div>
</div>


<!-- Toast -->
<div id="toast"
  class="fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-md hidden z-50 text-gray-50 text-sm"></div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const API_USERS = "{{ api_url('/api/admin/all-users') }}";
const token = localStorage.getItem("jwt_token_cs");

const api = axios.create({
  headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" }
});

let users = [];
let pagination = {};
let currentFilter = "all"; // all | verified | unverified
let searchName = "";

// === TOAST ===
function showToast(msg, type = "success") {
  const toast = document.getElementById("toast");
  toast.innerText = msg;
  toast.className = `
    fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-md z-50 text-gray-50 text-sm
    ${type === "success" ? "bg-green-600" : "bg-red-600"}
  `;
  toast.classList.remove("hidden");
  setTimeout(() => toast.classList.add("hidden"), 3000);
}

// === Update Filter Button UI ===
function updateFilterButtons() {
  const buttons = {
    all: document.getElementById("btnAll"),
    verified: document.getElementById("btnVerified"),
    unverified: document.getElementById("btnUnverified")
  };
  Object.values(buttons).forEach(btn => btn.className = "px-4 py-2 rounded-lg font-semibold transition-all shadow bg-gray-200 text-gray-800");

  if (currentFilter === "verified")
    buttons.verified.className = "px-4 py-2 rounded-lg font-semibold transition-all shadow bg-green-600 text-gray-50";
  else if (currentFilter === "unverified")
    buttons.unverified.className = "px-4 py-2 rounded-lg font-semibold transition-all shadow bg-red-600 text-gray-50";
  else
    buttons.all.className = "px-4 py-2 rounded-lg font-semibold transition-all shadow bg-blue-600 text-gray-50";
}
function showLoader() {
  const loader = document.getElementById("cssLoader");
  if (loader) {
    loader.classList.remove("hidden");
    loader.classList.add("flex");
  }
}

function hideLoader() {
  const loader = document.getElementById("cssLoader");
  if (loader) {
    loader.classList.add("hidden");
    loader.classList.remove("flex");
  }
}

// === Fetch Data ===
async function fetchUsers(page = 1) {
  try {
    showLoader(); // tampilkan loader sebelum request

    let params = `?page=${page}`;
    if (currentFilter === "verified") params += "&verified=1";
    else if (currentFilter === "unverified") params += "&verified=0";
    if (searchName) params += `&q=${encodeURIComponent(searchName)}`;

    const res = await api.get(`${API_USERS}${params}`);
    const result = res.data;

    if (!result.success) throw new Error(result.message);
    users = result.data;
    pagination = result.pagination;

    renderTable();
    renderPagination();
  } catch (err) {
    console.error("Gagal ambil data:", err);
    showToast("Token invalid atau gagal memuat data", "error");
  } finally {
    hideLoader(); // sembunyikan loader setelah selesai
  }
}


// === Render Table ===
function renderTable() {
  const tbodyDesktop = document.getElementById("userTableDesktop");
  const tbodyMobile = document.getElementById("userTableMobile");
  tbodyDesktop.innerHTML = "";
  tbodyMobile.innerHTML = "";

  if (users.length === 0) {
    tbodyDesktop.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data ditemukan</td></tr>`;
    tbodyMobile.innerHTML = `<div class="text-center py-4 text-gray-500">Tidak ada data ditemukan</div>`;
    return;
  }

  users.forEach(u => {
    const verified = u.email_verified_at ? 
      '<span class="text-green-600 font-semibold">Sudah</span>' : 
      '<span class="text-red-600 font-semibold">Belum</span>';

    // Desktop
    tbodyDesktop.insertAdjacentHTML("beforeend", `
      <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
        <td class="py-2 px-4">${u.name ?? '-'}</td>
        <td class="py-2 px-4">${u.email ?? '-'}</td>
        <td class="py-2 px-4 text-center">${verified}</td>
      </tr>
    `);

    // Mobile
    tbodyMobile.insertAdjacentHTML("beforeend", `
      <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 shadow flex flex-col gap-2">
        <div><span class="font-medium">Nama:</span> ${u.name ?? '-'}</div>
        <div><span class="font-medium">Email:</span> ${u.email ?? '-'}</div>
        <div><span class="font-medium">Status:</span> ${verified}</div>
      </div>
    `);
  });
}

// === Pagination ===
function renderPagination() {
  const container = document.getElementById("pagination");
  container.innerHTML = "";

  const { current_page, last_page } = pagination;

  if (last_page <= 1) return;

  container.className =
    "flex justify-center items-center gap-2 mt-6 mb-4 flex-wrap";

  // Tombol Prev
  if (current_page > 1) {
    container.insertAdjacentHTML("beforeend", `
      <button onclick="fetchUsers(${current_page - 1})"
        class="px-3 py-1 border rounded bg-white hover:bg-gray-100 shadow text-sm">
        ← Prev
      </button>
    `);
  }

  // === Numbered Pagination ===
  const maxPagesToShow = 5;
  let start = Math.max(1, current_page - 2);
  let end = Math.min(last_page, start + maxPagesToShow - 1);

  if (end - start < maxPagesToShow - 1) {
    start = Math.max(1, end - maxPagesToShow + 1);
  }

  // Jika halaman awal > 1, kasih "1 ..."
  if (start > 1) {
    container.insertAdjacentHTML("beforeend", `
      <button onclick="fetchUsers(1)"
        class="px-3 py-1 border rounded bg-white hover:bg-gray-100 shadow text-sm">
        1
      </button>
      <span class="px-2 text-gray-500">...</span>
    `);
  }

  // Loop nomor halaman
  for (let i = start; i <= end; i++) {
    container.insertAdjacentHTML("beforeend", `
      <button onclick="fetchUsers(${i})"
        class="px-3 py-1 border rounded text-sm shadow
          ${i === current_page ? "bg-green-500 text-white" : "bg-white hover:bg-gray-100"}">
        ${i}
      </button>
    `);
  }

  // Jika akhir < total halaman, kasih "... last_page"
  if (end < last_page) {
    container.insertAdjacentHTML("beforeend", `
      <span class="px-2 text-gray-500">...</span>
      <button onclick="fetchUsers(${last_page})"
        class="px-3 py-1 border rounded bg-white hover:bg-gray-100 shadow text-sm">
        ${last_page}
      </button>
    `);
  }

  // Tombol Next
  if (current_page < last_page) {
    container.insertAdjacentHTML("beforeend", `
      <button onclick="fetchUsers(${current_page + 1})"
        class="px-3 py-1 border rounded bg-white hover:bg-gray-100 shadow text-sm">
        Next →
      </button>
    `);
  }
}

// === Event Listener ===
document.getElementById("btnAll").addEventListener("click", () => {
  currentFilter = "all"; updateFilterButtons(); fetchUsers(1);
});
document.getElementById("btnVerified").addEventListener("click", () => {
  currentFilter = "verified"; updateFilterButtons(); fetchUsers(1);
});
document.getElementById("btnUnverified").addEventListener("click", () => {
  currentFilter = "unverified"; updateFilterButtons(); fetchUsers(1);
});

document.getElementById("searchName").addEventListener("input", e => {
  searchName = e.target.value; fetchUsers(1);
});
document.getElementById("btnClearSearch").addEventListener("click", () => {
  searchName = ""; document.getElementById("searchName").value = ""; fetchUsers(1);
});

// === INIT ===
document.addEventListener("DOMContentLoaded", () => {
  updateFilterButtons();
  fetchUsers(1);
});
</script>

@include('include.htmlend')
