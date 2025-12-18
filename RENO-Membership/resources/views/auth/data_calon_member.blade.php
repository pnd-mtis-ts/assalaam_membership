@include('include.htmlstart')
@include('include.sidecs')

<div class="w-full sm:ml-64">
  <div class="mt-24 p-3 sm:p-6 flex flex-col min-h-screen w-full gap-6">
    
    <!-- Header -->
    <div
      class="flex flex-row justify-between items-center rounded-xl bg-gradient-to-tr from-[oklch(97% 0 0)] to-[#22AA62] text-white shadow-md -mt-6 p-6 dark:bg-gradient-to-tr dark:from-[#F97300] dark:to-[#dc6f10]">
      <span class="block text-lg sm:text-xl font-semibold text-zinc-950">Data Calon Member</span>
    </div>

    <div class="flex flex-wrap gap-2 w-full sm:w-auto">
  <input 
    type="text" 
    id="searchInput"
    placeholder="Cari nama atau nomor kartu..."
    class="px-4 py-2 border rounded-lg w-full sm:w-64 dark:bg-gray-800 dark:text-white"
    oninput="onSearch(this)"
  >
</div>

    <!-- Container Table / Card -->
<div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-2 md:p-0">
  <!-- Desktop Table -->
   
  <table class="w-full table-auto text-xs sm:text-sm md:text-base hidden md:table">
    <thead class="bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
      <tr>
        <th class="border-b py-3 px-4 text-left">Nomor Card</th>
        <th class="border-b py-3 px-4 text-left">Nama</th>
        <th class="border-b py-3 px-4 text-left">Status Validasi</th>
        <th class="border-b py-3 px-4 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody id="calonTableDesktop" class="dark:text-gray-200"></tbody>
  </table>

  <!-- Mobile Card -->
  <div id="calonTableMobile" class="flex flex-col gap-4 md:hidden"></div>
</div>



<!-- Modal Detail -->
<div id="detailModal"
  class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300 opacity-0">
 <div id="detailBox"
  class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-[95%] sm:w-[500px] 
         max-h-[80vh] overflow-y-auto relative transform transition-all 
         duration-500 opacity-0 scale-75">

  <!-- HEADER -->
<div class="flex justify-between items-center px-6 py-4 border-b 
            bg-white dark:bg-gray-800 sticky top-0 z-10">
  <h2 class="text-lg font-bold">Detail Member</h2>
  <button onclick="closeModal()"
    class="text-gray-600 hover:text-red-600 text-2xl leading-none font-bold">
    &times;
  </button>
</div>


  <!-- CONTENT -->
  <div id="detailContent" class="space-y-2 text-sm p-6"></div>

</div>

</div>
<!-- Modal Konfirmasi -->
<div id="confirmModal"
  class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300 opacity-0">
  <div id="confirmBox"
    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[90%] sm:w-[400px] transform transition-all duration-500 opacity-0 scale-75">
    <h2 class="text-lg font-bold mb-4">Konfirmasi Validasi</h2>
    <p id="confirmText" class="text-sm mb-6 text-gray-700 dark:text-gray-300"></p>
    <div class="flex justify-end gap-3">
      <button onclick="closeConfirmModal()" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
        Batal
      </button>
      <button id="confirmYesBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        Ya, Validasi
      </button>
    </div>
  </div>
</div>

<!-- Pagination -->
      <div id="pagination" class="flex justify-center items-center gap-2 mt-6 mb-4"></div>
<!-- Toast -->
<div id="toast"
  class="fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-md hidden z-50 text-white text-sm">
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

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
/* ============================================
   CONFIG
===============================================*/
const API_URL = "{{ api_url('/api/admin/card-guest') }}";
const getToken = () => localStorage.getItem("jwt_token_cs");

let guests = [];
let pagination = {};
let detailMember = null;
let searchKeyword = "";
let theme = localStorage.getItem("theme") || "light";

/* ============================================
   TOAST
===============================================*/
function showToast(message, type = "success") {
  const toast = document.getElementById("toast");
  toast.innerText = message;
  toast.className =
    `fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-md z-50 text-white text-sm ${type === "success" ? "bg-green-600" : "bg-red-600"}`;
  toast.classList.remove("hidden");
  setTimeout(() => toast.classList.add("hidden"), 3000);
}

/* ============================================
   CONFIRM MODAL
===============================================*/
function openConfirmModal(message, onConfirm) {
  const modal = document.getElementById("confirmModal");
  const box = document.getElementById("confirmBox");
  const text = document.getElementById("confirmText");
  const yesBtn = document.getElementById("confirmYesBtn");

  text.innerText = message;
  modal.classList.remove("hidden");
  modal.classList.add("flex");

  setTimeout(() => {
    modal.classList.remove("opacity-0");
    box.classList.remove("opacity-0", "scale-75");
    box.classList.add("scale-100");
  }, 10);

  yesBtn.onclick = () => {
    closeConfirmModal();
    onConfirm();
  };
}

function closeConfirmModal() {
  const modal = document.getElementById("confirmModal");
  const box = document.getElementById("confirmBox");

  modal.classList.add("opacity-0");
  box.classList.add("opacity-0", "scale-75");

  setTimeout(() => {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
  }, 300);
}

/* ============================================
   FORMATTER
===============================================*/
const formatDate = (date) =>
  date
    ? new Date(date).toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "short",
        year: "numeric",
      })
    : "-";

const getValidText = (v) => (Number(v) === 1 ? "Valid" : "Belum Valid");

/* ============================================
   FETCH DATA (WITH SEARCH)
===============================================*/
async function fetchGuests(page = 1) {
  try {
    const token = getToken();
    if (!token) return (window.location.href = "/login");

    const res = await axios.get(
      `${API_URL}?page=${page}&search=${encodeURIComponent(searchKeyword)}`,
      { headers: { Authorization: `Bearer ${token}` } }
    );

    const json = res.data;

    const raw = json.data ?? json.data?.data ?? [];

    guests = raw.map((g) => ({
      MEMBER_ID: g.MEMBER_ID,
      MEMBER_NAME: g.MEMBER_NAME,
      MEMBER_CARD_NO: g.MEMBER_CARD_NO || "-",
      MEMBER_IS_VALID: g.MEMBER_IS_VALID,
      MEMBER_TYPE: g.MEMBER_TYPE ?? "",
      selectedType: g.MEMBER_TYPE ?? "PAS",

      MEMBER_PLACE_OF_BIRTH: g.MEMBER_PLACE_OF_BIRTH || "-",
      MEMBER_DATE_OF_BIRTH: g.MEMBER_DATE_OF_BIRTH || null,
      MEMBER_KTP_NO: g.MEMBER_KTP_NO || "-",
      MEMBER_ADDRESS: g.MEMBER_ADDRESS || "-",
      MEMBER_KELURAHAN: g.MEMBER_KELURAHAN || "-",
      MEMBER_KECAMATAN: g.MEMBER_KECAMATAN || "-",
      MEMBER_KOTA: g.MEMBER_KOTA || "-",
      MEMBER_RT: g.MEMBER_RT || "-",
      MEMBER_RW: g.MEMBER_RW || "-",
      MEMBER_POST_CODE: g.MEMBER_POST_CODE || "-",
      MEMBER_JML_TANGGUNGAN: g.MEMBER_JML_TANGGUNGAN || "-",
      MEMBER_PENDAPATAN: g.MEMBER_PENDAPATAN || "-",
      MEMBER_TELP: g.MEMBER_TELP || "-",
      MEMBER_NPWP: g.MEMBER_NPWP || "-",
    }));

    pagination = json.pagination ?? {
      current_page: res.data.current_page,
      last_page: res.data.last_page,
      total: res.data.total,
      per_page: res.data.per_page,
    };

    renderGuests();
    renderPagination();
  } catch (err) {
    console.error("Fetch Error:", err);
    document.getElementById("calonTableDesktop").innerHTML =
      `<tr><td colspan="4" class="text-center text-red-500 py-4">Gagal ambil data</td></tr>`;
  }
}

/* ============================================
   RENDER TABLE
===============================================*/
function renderGuests() {
  const des = document.getElementById("calonTableDesktop");
  const mob = document.getElementById("calonTableMobile");
  des.innerHTML = "";
  mob.innerHTML = "";

  if (guests.length === 0) {
    des.innerHTML = `<tr><td colspan="4" class="text-center py-4">Tidak ada data</td></tr>`;
    mob.innerHTML = `<div class="text-center py-4">Tidak ada data</div>`;
    return;
  }

  guests.forEach((g, i) => {
    des.insertAdjacentHTML(
      "beforeend",
      `
      <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
        <td class="py-2 px-4">${g.MEMBER_CARD_NO}</td>
        <td class="py-2 px-4">${g.MEMBER_NAME}</td>
        <td class="py-2 px-4">${getValidText(g.MEMBER_IS_VALID)}</td>
        <td class="py-2 px-4 text-center">
          <div class="flex flex-col sm:flex-row justify-center gap-2">

            ${
              g.MEMBER_IS_VALID == 0 || g.MEMBER_IS_VALID == null
                ? `<button onclick="validateMember(${i})"
                   class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">
                   Validasi (PAS)
                 </button>`
                : `<span class="text-xs px-2 py-1 rounded bg-green-600 text-white">${g.MEMBER_TYPE}</span>`
            }

            <button onclick="showDetail(${i})"
              class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">
              Detail
            </button>

          </div>
        </td>
      </tr>
    `
    );

    mob.insertAdjacentHTML(
      "beforeend",
      `
      <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow flex flex-col gap-2">
        <div><span class="font-medium">Nomor Card: </span>${g.MEMBER_CARD_NO}</div>
        <div><span class="font-medium">Nama: </span>${g.MEMBER_NAME}</div>
        <div><span class="font-medium">Status: </span>${getValidText(g.MEMBER_IS_VALID)}</div>

        <div class="flex flex-wrap gap-2 mt-2">
          ${
            g.MEMBER_IS_VALID == 0 || g.MEMBER_IS_VALID == null
              ? `<button onclick="validateMember(${i})"
                   class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">
                   Validasi (PAS)
                 </button>`
              : `<span class="text-xs px-2 py-1 rounded bg-green-600 text-white">${g.MEMBER_TYPE}</span>`
          }

          <button onclick="showDetail(${i})"
            class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
            Detail
          </button>
        </div>
      </div>
    `
    );
  });
}

/* ============================================
   PAGINATION
===============================================*/
function renderPagination() {
  const container = document.getElementById("pagination");
  container.innerHTML = "";

  const { current_page, last_page } = pagination;
  if (last_page <= 1) return;

  container.className = "flex justify-center items-center gap-2 mt-6 mb-4";

  if (current_page > 1) {
    container.insertAdjacentHTML(
      "beforeend",
      `<button onclick="fetchGuests(${current_page - 1})"
        class="px-3 py-1 border rounded shadow">← Prev</button>`
    );
  }

  for (let i = 1; i <= last_page; i++) {
    if (Math.abs(current_page - i) <= 2 || i === 1 || i === last_page) {
      container.insertAdjacentHTML(
        "beforeend",
        `<button onclick="fetchGuests(${i})"
          class="px-3 py-1 border rounded shadow ${
            i === current_page ? "bg-green-500 text-white" : "bg-white"
          }">${i}</button>`
      );
    }
  }

  if (current_page < last_page) {
    container.insertAdjacentHTML(
      "beforeend",
      `<button onclick="fetchGuests(${current_page + 1})"
        class="px-3 py-1 border rounded shadow">Next →</button>`
    );
  }
}

/* ============================================
   VALIDATE MEMBER
===============================================*/
function validateMember(index) {
  const g = guests[index];
  const selectedType = "PAS";

  openConfirmModal(
    `Validasi ${g.MEMBER_NAME} sebagai ${selectedType}?`,
    async () => {
      try {
        const token = getToken();

        const res = await axios.post(
          `${API_URL}/${g.MEMBER_ID}/activate`,
          { member_type: selectedType },
          { headers: { Authorization: `Bearer ${token}` } }
        );

        g.MEMBER_IS_VALID = 1;
        g.MEMBER_TYPE = selectedType;
        g.MEMBER_CARD_NO = res.data.member_card_no;

        showToast(res.data.message ?? "Berhasil!", "success");
        renderGuests();
      } catch (err) {
        showToast("Gagal validasi", "error");
        console.error(err);
      }
    }
  );
}

/* ============================================
   DETAIL MODAL
===============================================*/
function showDetail(index) {
  detailMember = guests[index];
  const g = detailMember;

  const detail = {
    "Nama": g.MEMBER_NAME,
    "Nomor Kartu": g.MEMBER_CARD_NO,
    "Status": getValidText(g.MEMBER_IS_VALID),
    "Tempat Lahir": g.MEMBER_PLACE_OF_BIRTH,
    "Tanggal Lahir": formatDate(g.MEMBER_DATE_OF_BIRTH),
    "Alamat": g.MEMBER_ADDRESS,
    "RT/RW": `${g.MEMBER_RT} / ${g.MEMBER_RW}`,
    "Kelurahan": g.MEMBER_KELURAHAN,
    "Kecamatan": g.MEMBER_KECAMATAN,
    "Kota": g.MEMBER_KOTA,
    "Kode Pos": g.MEMBER_POST_CODE,
    "No. Telepon": g.MEMBER_TELP,
    "NPWP": g.MEMBER_NPWP,
    "Jumlah Tanggungan": g.MEMBER_JML_TANGGUNGAN,
    "Pendapatan": g.MEMBER_PENDAPATAN,
  };

  let html = `<div class="space-y-4 px-2">`;
  for (const [label, v] of Object.entries(detail)) {
    html += `
      <div class="border-b pb-2">
        <span class="font-medium">${label}</span>
        <span class="block">${v}</span>
      </div>
    `;
  }
  html += "</div>";

  document.getElementById("detailContent").innerHTML = html;
  openModal();
}

function openModal() {
  const modal = document.getElementById("detailModal");
  const box = document.getElementById("detailBox");

  modal.classList.remove("hidden");
  modal.classList.add("flex");

  setTimeout(() => {
    modal.classList.remove("opacity-0");
    box.classList.remove("opacity-0", "scale-75");
    box.classList.add("scale-100");
  }, 10);
}

function closeModal() {
  const modal = document.getElementById("detailModal");
  const box = document.getElementById("detailBox");

  modal.classList.add("opacity-0");
  box.classList.add("opacity-0", "scale-75");

  setTimeout(() => {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
  }, 300);
}

/* ============================================
   SEARCH (LIVE SEARCH)
===============================================*/
function onSearch(input) {
  searchKeyword = input.value.trim();
  fetchGuests(1);
}

/* ============================================
   THEME
===============================================*/
function toggleTheme() {
  theme = theme === "light" ? "dark" : "light";
  localStorage.setItem("theme", theme);
  updateThemeClass();
}

function updateThemeClass() {
  const el = document.querySelector(".admin-container");
  if (el) {
    el.classList.toggle("dark", theme === "dark");
  }
}

/* ============================================
   LOGOUT
===============================================*/
function logout() {
  localStorage.removeItem("jwt_token_cs");
  window.location.href = "/login";
}

/* ============================================
   AXIOS INTERCEPTOR
===============================================*/
axios.interceptors.response.use(
  (r) => r,
  (err) => {
    if (err.response?.status === 401) {
      logout();
    }
    return Promise.reject(err);
  }
);

/* ============================================
   INIT
===============================================*/
document.addEventListener("DOMContentLoaded", () => {
  fetchGuests();
  updateThemeClass();
});
</script>

@include('include.htmlend')
