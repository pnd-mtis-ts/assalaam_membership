@include('include.htmlstart')
@include('include.sidecs')

<div class="w-full sm:ml-64">
  <div class="mt-24 p-3 sm:p-6 flex flex-col min-h-screen w-full gap-6">

 

    <!-- Header -->
    <div
      class="flex flex-row justify-between items-center rounded-xl bg-gradient-to-tr from-[oklch(97% 0 0)] to-[#22AA62] text-white shadow-md -mt-6 p-6 dark:bg-gradient-to-tr dark:from-[#F97300] dark:to-[#dc6f10]">
      <span class="block text-lg sm:text-xl font-semibold text-zinc-950">Daftar Member</span>
    </div>


    
    <!-- Toggle Filter -->
<div class="flex justify-center gap-3 mb-4">
  <button id="btnActive"
    class="px-4 py-2 rounded-lg font-semibold transition-all shadow">
    Member Aktif
  </button>
   <button id="btnExpiring"
    class="px-4 py-2 rounded-lg font-semibold transition-all shadow">
    Mendekati Kadaluarsa
  </button>
    <button id="btnExpired"
  class="px-4 py-2 rounded-lg font-semibold transition-all shadow bg-gray-300 text-gray-800">
  Expired
  </button>
  <button id="btnInactive"
    class="px-4 py-2 rounded-lg font-semibold transition-all shadow">
    Member Non-Aktif
  </button>


</div>


    
    <!-- 🔍 Search -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
      <div class="flex flex-wrap gap-2 w-full sm:w-auto">
        <input id="searchName" type="text" placeholder="Cari member..."
          class="px-4 py-2 border rounded-lg w-full sm:w-64 focus:ring-2 focus:ring-green-400 outline-none">
        <input id="searchDate" type="date"
          class="px-4 py-2 border rounded-lg w-full sm:w-48 focus:ring-2 focus:ring-green-400 outline-none">
      </div>
      <button id="btnClearSearch"
        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-all">
        Reset
      </button>
    </div>
    




    
    <!-- Container Table / Card -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-2 md:p-0">
      <table class="w-full table-auto text-xs sm:text-sm md:text-base hidden md:table">
        <thead id="tableHead"
          class="bg-green-100 dark:bg-green-800 dark:text-gray-200 transition-colors duration-300">
          <tr>
            <th class="border-b py-3 px-4 text-left">Nama</th>
            <th class="border-b py-3 px-4 text-left">No Kartu</th>
            <th class="border-b py-3 px-4 text-left">Aktif Sampai</th>
            <th class="border-b py-3 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody id="userTableDesktop" class="dark:text-gray-200"></tbody>
      </table>

      <!-- Card Mobile -->
      <div id="userTableMobile" class="flex flex-col gap-4 md:hidden"></div>

      <!-- Pagination -->
      <div id="pagination" class="flex justify-center items-center gap-2 mt-6 mb-4"></div>
    </div>
  </div>
</div>
 
<!-- Modal Detail -->
<div id="detailModal"
  class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-500 opacity-0">
  <div id="detailBox"
    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-[95%] sm:w-[500px] max-h-[80vh] overflow-hidden relative transform transition-all duration-500 opacity-0 rotate-12 scale-75 flex flex-col">
    
   <div class="flex justify-between items-center p-6 border-b">
  <h2 class="text-lg font-bold">Detail Member</h2>
  <button onclick="closeModal()" 
    class="text-gray-500 hover:text-red-500 text-xl font-bold transition">
    &times;
  </button>
</div>
<!-- === GLOBAL CONFIRM DIALOG === -->
<div id="confirmDialog" 
     class="fixed inset-0 flex items-center justify-center z-50 bg-transparent hidden">

  <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-lg max-w-sm w-full">
    <h2 class="text-lg font-bold mb-4 text-center">Konfirmasi Validasi</h2>
    <p id="confirmMessage" class="text-sm mb-6 text-gray-700 dark:text-gray-300 text-center"></p>

    <div class="flex justify-center gap-3">
      <button id="confirmCancel" 
              class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
        Batal
      </button>
      <button id="confirmOk" 
              class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        Ya
      </button>
    </div>
  </div>
</div>
    
    <!-- Konten Scrollable -->
    <div id="detailContent" class="flex-1 overflow-y-auto p-6 grid grid-cols-1 gap-4 text-sm"></div>

    <!-- Footer tetap -->
    <div id="detailFooter" class="flex justify-end gap-3 p-4 border-t bg-white dark:bg-gray-800">
      <!-- tombol akan diisi dari JS -->
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
  class="fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-md hidden z-50 text-white text-sm"></div>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  const API_MEMBERS = "{{ api_url('/api/admin/card-members') }}";
  const API_EDIT = "{{ api_url('/api/member/profile-update') }}";
  const API_CHECK = "{{ api_url('/api/member/check-email') }}";
  const API_EXTEND = "{{ api_url('/api/admin/card-members/extend') }}";
  const token = localStorage.getItem("jwt_token_cs");

  const api = axios.create({
    headers: {  
      "Authorization": `Bearer ${token}`,
      "Accept": "application/json"
    }
  });

  let members = [];
let pagination = {};
let currentStatus = "active"; // default filter
let searchName = "";
let searchDate = "";

function showConfirm(message) {
  return new Promise(resolve => {
    const dialog = document.getElementById("confirmDialog");
    const msg = document.getElementById("confirmMessage");
    const btnOk = document.getElementById("confirmOk");
    const btnCancel = document.getElementById("confirmCancel");

    msg.textContent = message;

    dialog.classList.remove("hidden");
    dialog.classList.add("flex");

    // Hapus listener lama agar tidak dobel
    btnOk.onclick = () => {
      dialog.classList.add("hidden");
      resolve(true);
    };
    btnCancel.onclick = () => {
      dialog.classList.add("hidden");
      resolve(false);
    };
  });
}


function updateFilterButtons() {
  const btnActive = document.getElementById("btnActive");
  const btnInactive = document.getElementById("btnInactive");
  const btnExpiring = document.getElementById("btnExpiring");
  const btnExpired = document.getElementById("btnExpired");

  btnActive.className = "px-4 py-2 rounded-lg font-semibold transition-all shadow";
  btnInactive.className = "px-4 py-2 rounded-lg font-semibold transition-all shadow";
  btnExpiring.className = "px-4 py-2 rounded-lg font-semibold transition-all shadow";
  btnExpired.className = "px-4 py-2 rounded-lg font-semibold transition-all shadow";

  // RESET semua tombol
  [btnActive, btnInactive, btnExpiring, btnExpired].forEach(btn => {
    btn.classList.remove(
      "bg-green-600", "bg-red-600", "bg-yellow-600", "bg-gray-600",
      "text-white"
    );
    btn.classList.add("bg-gray-300", "text-gray-800");
  });

  // AKTIFKAN tombol sesuai status
  if (currentStatus === "active") {
    btnActive.classList.add("bg-green-600", "text-white");
    btnActive.classList.remove("bg-gray-300", "text-gray-800");
  }

  else if (currentStatus === "inactive") {
    btnInactive.classList.add("bg-red-600", "text-white");
    btnInactive.classList.remove("bg-gray-300", "text-gray-800");
  }

  else if (currentStatus === "expiring") {
    btnExpiring.classList.add("bg-yellow-600", "text-white");
    btnExpiring.classList.remove("bg-gray-300", "text-gray-800");
  }

  else if (currentStatus === "expired") {
    btnExpired.classList.add("bg-gray-600", "text-white");
    btnExpired.classList.remove("bg-gray-300", "text-gray-800");
  }

}

  // === TOAST ===
  function showToast(message, type = "success") {
  const toast = document.getElementById("toast");
  toast.innerText = message;
  toast.className = `
    fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-md z-50 text-white text-sm
    ${type === "success" ? "bg-green-600" : "bg-red-600"}
  `;
  toast.classList.remove("hidden");
  setTimeout(() => toast.classList.add("hidden"), 3000);
}

  // === FORMAT TANGGAL ===
  function formatDate(dateStr) {
    if (!dateStr) return "-";
    const d = new Date(dateStr);
    return isNaN(d)
      ? "-"
      : d.toLocaleDateString("id-ID", { day: "2-digit", month: "2-digit", year: "numeric" });
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
// === FETCH MEMBERS ===

  async function fetchMembers(page = 1) {
  try {
    showLoader(); // tampilkan loading sebelum request

    const params = new URLSearchParams({
      status: currentStatus,
      page: page,
      q: searchName || "",
      date: searchDate || ""
    });

    const res = await api.get(`${API_MEMBERS}?${params.toString()}`);
    const result = res.data;

    if (!result.success) throw new Error(result.message);

    members = result.data;
    pagination = result.pagination;

    renderTable();
    renderPagination();
  } catch (err) {
    console.error("Gagal ambil data:", err);
    showToast("Token invalid / data gagal dimuat", "error");
  } finally {
    hideLoader(); // sembunyikan loading setelah selesai
  }
}


// === RENDER TABLE ===
function renderTable() {
  const tbodyDesktop = document.getElementById("userTableDesktop");
  const tbodyMobile = document.getElementById("userTableMobile");
  const head = document.getElementById("tableHead");

  if (!tbodyDesktop || !tbodyMobile || !head) return;

  tbodyDesktop.innerHTML = "";
  tbodyMobile.innerHTML = "";

  // Ganti warna head sesuai status
  if (currentStatus === "active")
    head.className = "bg-green-100 dark:bg-green-800 dark:text-gray-200";
  else if (currentStatus === "inactive")
    head.className = "bg-red-100 dark:bg-red-800 dark:text-gray-200";
  else if (currentStatus === "expiring")
    head.className = "bg-yellow-100 dark:bg-yellow-800 dark:text-gray-200";
  else if (currentStatus === "expired")
  head.className = "bg-gray-200 dark:bg-gray-700 dark:text-gray-200";


  const data = members; // langsung pakai data dari backend

  if (!data.length) {
    tbodyDesktop.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data.</td></tr>`;
    tbodyMobile.innerHTML = `<div class="text-center py-4 text-gray-500">Tidak ada data.</div>`;
    return;
  }

  data.forEach(m => {
    const btnText = m.MEMBER_IS_ACTIVE == 1 ? "Nonaktifkan" : "Aktifkan";
    const btnColor = m.MEMBER_IS_ACTIVE == 1
      ? "bg-red-600 hover:bg-red-700"
      : "bg-green-600 hover:bg-green-700";

    // DESKTOP
    tbodyDesktop.insertAdjacentHTML("beforeend", `
      <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
        <td class="py-2 px-4">${m.MEMBER_NAME ?? "-"}</td>
        <td class="py-2 px-4">${m.MEMBER_CARD_NO ?? "-"}</td>
        <td class="py-2 px-4">${m.MEMBER_ACTIVE_TO ? new Date(m.MEMBER_ACTIVE_TO).toLocaleDateString('id-ID') : "-"}</td>
        <td class="py-2 px-4 text-center">
          <div class="flex justify-center gap-2">

            <button onclick="showDetail('${m.MEMBER_ID ?? ""}')"
              class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs sm:text-sm">
              Detail
            </button>

            ${
              (currentStatus === "expiring" || currentStatus === "expired")
                ? `<button onclick="extendMember('${m.MEMBER_ID ?? ""}')"
                     class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 text-xs sm:text-sm">
                     Perpanjang
                   </button>`
                : ""
            }

            <button onclick="toggleActive('${m.MEMBER_ID ?? ""}', ${m.MEMBER_IS_ACTIVE ?? 0})"
              class="px-3 py-1 ${btnColor} text-white rounded text-xs sm:text-sm">
              ${btnText}
            </button>

          </div>
        </td>
      </tr>
    `);
    // MOBILE CARD
tbodyMobile.insertAdjacentHTML("beforeend", `
  <div class="p-4 rounded-lg shadow bg-gray-50 dark:bg-gray-800">
    <div class="flex justify-between">
      <div>
        <p class="font-semibold">${m.MEMBER_NAME ?? "-"}</p>
        <p class="text-xs text-gray-500">No. Kartu: ${m.MEMBER_CARD_NO ?? "-"}</p>
        <p class="text-xs">Aktif s/d: ${m.MEMBER_ACTIVE_TO ? new Date(m.MEMBER_ACTIVE_TO).toLocaleDateString('id-ID') : "-"}</p>
      </div>
      <button onclick="showDetail('${m.MEMBER_ID}')"
        class="px-3 py-1 bg-blue-600 text-white rounded text-xs">
        Detail
      </button>
    </div>

    <div class="mt-3 flex gap-2">
      ${
        (currentStatus === "expiring" || currentStatus === "expired")
          ? `<button onclick="extendMember('${m.MEMBER_ID}')"
               class="flex-1 px-3 py-1 bg-yellow-600 text-white rounded text-xs">
               Perpanjang
             </button>`
          : ""
      }

      <button onclick="toggleActive('${m.MEMBER_ID}', ${m.MEMBER_IS_ACTIVE ?? 0})"
        class="flex-1 px-3 py-1 ${m.MEMBER_IS_ACTIVE == 1 ? "bg-red-600" : "bg-green-600"} 
        text-white rounded text-xs">
        ${m.MEMBER_IS_ACTIVE == 1 ? "Nonaktifkan" : "Aktifkan"}
      </button>
    </div>
  </div>
`);

  });
}


// === PAGINATION ===
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
      <button onclick="fetchMembers(${current_page - 1})"
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
      <button onclick="fetchMembers(1)"
        class="px-3 py-1 border rounded bg-white hover:bg-gray-100 shadow text-sm">
        1
      </button>
      <span class="px-2 text-gray-500">...</span>
    `);
  }

  // Loop nomor halaman
  for (let i = start; i <= end; i++) {
    container.insertAdjacentHTML("beforeend", `
      <button onclick="fetchMembers(${i})"
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
      <button onclick="fetchMembers(${last_page})"
        class="px-3 py-1 border rounded bg-white hover:bg-gray-100 shadow text-sm">
        ${last_page}
      </button>
    `);
  }

  // Tombol Next
  if (current_page < last_page) {
    container.insertAdjacentHTML("beforeend", `
      <button onclick="fetchMembers(${current_page + 1})"
        class="px-3 py-1 border rounded bg-white hover:bg-gray-100 shadow text-sm">
        Next →
      </button>
    `);
  }
}




// === TAMPILKAN DETAIL MEMBER ===
async function showDetail(id) {
  try {
    const res = await api.get(`${API_MEMBERS}/${id}`);
    const m = res.data?.data ?? res.data ?? {};

    const detail = {
      USER_EMAIL: m.USER_EMAIL ?? "",
      MEMBER_NAME: m.MEMBER_NAME ?? "",
      MEMBER_CARD_NO: m.MEMBER_CARD_NO ?? "",
      MEMBER_PLACE_OF_BIRTH: m.MEMBER_PLACE_OF_BIRTH ?? "",
      MEMBER_DATE_OF_BIRTH: m.MEMBER_DATE_OF_BIRTH ?? "",
      MEMBER_ADDRESS: m.MEMBER_ADDRESS ?? "",
      MEMBER_RT: m.MEMBER_RT ?? "",
      MEMBER_RW: m.MEMBER_RW ?? "",
      MEMBER_KECAMATAN: m.MEMBER_KECAMATAN ?? "",
      MEMBER_KOTA: m.MEMBER_KOTA ?? "",
      MEMBER_POST_CODE: m.MEMBER_POST_CODE ?? "",
      MEMBER_TELP: m.MEMBER_TELP ?? "",
      MEMBER_NPWP: m.MEMBER_NPWP ?? ""
    };

    let html = `
      <form id="editForm" class="grid grid-cols-1 gap-4 pb-6" enctype="multipart/form-data">
    `;

    for (const [key, value] of Object.entries(detail)) {
      const label = key
        .replace(/^MEMBER_/, "")
        .replace(/^USER_/, "")
        .replaceAll("_", " ")
        .toLowerCase()
        .replace(/\b\w/g, c => c.toUpperCase());

      const readonly = key === "MEMBER_CARD_NO" || key === "MEMBER_PLACE_OF_BIRTH" ? "readonly" : "";
      const safeValue = String(value ?? "")
        .replace(/"/g, "&quot;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");

      html += `
        <div class="flex flex-col">
          <label class="font-medium text-gray-700 dark:text-gray-300 mb-1">${label}</label>
          <input name="${key}" value="${safeValue}" ${readonly}
            class="border rounded-md px-2 py-1 focus:ring-2 focus:ring-green-400 outline-none
            text-gray-900 dark:text-gray-100 dark:bg-gray-700
            ${readonly ? 'bg-gray-100 dark:bg-gray-600 cursor-not-allowed' : ''}" />
          ${key === "USER_EMAIL" ? `<p id="emailInfo" class="text-xs mt-1"></p>` : ""}
        </div>
      `;
    }

    html += `</form>`;

    document.getElementById("detailContent").innerHTML = html;

    document.getElementById("detailFooter").innerHTML = `
      <div class="flex justify-end items-center p-4 border-t bg-white dark:bg-gray-800">
        <button type="submit" form="editForm"
          class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
          Simpan
        </button>
      </div>
    `;

    openModal();

   // ======================================================================
// 🔍 REALTIME CEK EMAIL DUPLICATE
// ======================================================================
const emailInput = document.querySelector('input[name="USER_EMAIL"]');
const emailInfo = document.getElementById("emailInfo");

if (emailInput) {
  let debounceTimeout;

  emailInput.addEventListener("input", () => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(async () => {
      const email = emailInput.value.trim();
      if (!email) {
        emailInfo.textContent = "";
        return;
      }

      try {
        const res = await api.post(API_CHECK, {
          email: String(email).trim(),        // 🔥 PENTING: pastikan selalu string
          MEMBER_ID: String(m.MEMBER_ID ?? "") // 🔥 supaya tidak error
        });

        if (res.data.exists) {
          emailInfo.textContent = "⚠️ Email sudah digunakan member lain!";
          emailInfo.className = "text-xs mt-1 text-red-500";
          emailInput.dataset.invalid = "1";
        } else {
          emailInfo.textContent = "✔ Email tersedia";
          emailInfo.className = "text-xs mt-1 text-green-500";
          delete emailInput.dataset.invalid;
        }
      } catch (err) {
        console.error(err);
        emailInfo.textContent = "⚠️ Gagal memeriksa email";
        emailInfo.className = "text-xs mt-1 text-red-500";
      }

    }, 500); // debounce 0.5s
  });
}


    // ======================================================================
    // SUBMIT FORM
    // ======================================================================
    const form = document.getElementById("editForm");
form.addEventListener("submit", async (e) => {
  e.preventDefault();

  // validasi email
  const emailInputCheck = document.querySelector('input[name="USER_EMAIL"]');
  if (emailInputCheck.dataset.invalid === "1") {
    showToast("Email sudah digunakan member lain!", "error");
    return;
  }

  // KONFIRMASI
  const confirm = await showConfirm("Simpan perubahan data member?");
  if (!confirm) return;

  const fd = new FormData(form);
  fd.append("MEMBER_ID", m.MEMBER_ID);
  fd.append("_method", "PUT");

  try {
    const res = await axios.post(API_EDIT, fd, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: "application/json",
        "Content-Type": "multipart/form-data",
      },
    });

    showToast("Profil berhasil diperbarui!");
    closeModal();
    fetchMembers();
  } catch (err) {
    console.error(err);
    showToast("Gagal memperbarui profil!", "error");
  }
});


  } catch (err) {
    console.error(err);
    showToast("Gagal ambil detail member", "error");
  }
}


// === AKTIF / NONAKTIFKAN MEMBER ===
async function toggleActive(id, status) {
  const confirm = await showConfirm(
    status == 1
      ? "Yakin ingin menonaktifkan member ini?"
      : "Yakin ingin mengaktifkan member ini?"
  );

  if (!confirm) return;

  try {
    await api.post(`${API_MEMBERS}/${id}/activation`, {
      MEMBER_IS_ACTIVE: status == 1 ? 0 : 1
    });
    showToast("Status berhasil diperbarui!");
    await fetchMembers();
  } catch (err) {
    console.error(err);
    showToast("Gagal update status", "error");
  }
}

async function extendMember(id) {
  const confirm = await showConfirm("Perpanjang masa aktif selama 2 tahun?");
  if (!confirm) return;

  try {
    const url = `${API_EXTEND}/${id}`;
    const res = await api.post(url);

    if (res.data.success) {
      showToast("Berhasil diperpanjang 2 tahun!");
      fetchMembers();
    } else {
      showToast("Gagal perpanjang!", "error");
    }
  } catch (err) {
    console.error(err);
    showToast("Terjadi kesalahan saat perpanjang!", "error");
  }
}



// === MODAL HANDLER ===
function openModal() {
  const modal = document.getElementById("detailModal");
  const box = document.getElementById("detailBox");
  const content = document.getElementById("detailContent");

  // Reset posisi scroll konten ke atas setiap kali modal dibuka
  if (content) content.scrollTop = 0;

  // Cegah scroll background
  document.body.style.overflow = "hidden";

  // Tampilkan modal
  modal.classList.remove("hidden");
  modal.classList.add("flex");

  // Delay kecil untuk animasi masuk
  setTimeout(() => {
    modal.classList.remove("opacity-0");
    box.classList.remove("opacity-0", "rotate-12", "scale-75");
    box.classList.add("rotate-0", "scale-100");
  }, 50);
}

function closeModal() {
  const modal = document.getElementById("detailModal");
  const box = document.getElementById("detailBox");
  const content = document.getElementById("detailContent");

  // Reset posisi scroll konten ke atas saat modal ditutup
  if (content) content.scrollTop = 0;

  modal.classList.add("opacity-0");
  box.classList.add("opacity-0", "rotate-12", "scale-75");
  box.classList.remove("rotate-0", "scale-100");

  setTimeout(() => {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    document.body.style.overflow = ""; // Aktifkan scroll background lagi
  }, 300);
}


  // === SEARCH & FILTER ===
  document.getElementById("searchName").addEventListener("input", e => {
  searchName = e.target.value;
  fetchMembers(1);
});


 document.getElementById("searchDate").addEventListener("change", e => {
  searchDate = e.target.value;
  fetchMembers(1);
});


  document.getElementById("btnClearSearch").addEventListener("click", () => {
  searchName = "";
  searchDate = "";
  document.getElementById("searchName").value = "";
  document.getElementById("searchDate").value = "";
  fetchMembers(1);   // ← FIX
});


  // === TOGGLE AKTIF/NONAKTIF ===
  document.getElementById("btnActive").addEventListener("click", () => {
  currentStatus = "active";
  updateFilterButtons();
  fetchMembers(1);
});
document.getElementById("btnInactive").addEventListener("click", () => {
  currentStatus = "inactive";
  updateFilterButtons();
  fetchMembers(1);
});
document.getElementById("btnExpiring")?.addEventListener("click", () => {
  currentStatus = "expiring";
  updateFilterButtons();
  fetchMembers(1);
});
document.getElementById("btnExpired").addEventListener("click", () => {
  currentStatus = "expired";
  updateFilterButtons();
  fetchMembers(1);
});


  // === INIT ===
  
document.addEventListener("DOMContentLoaded", () => {
  updateFilterButtons(); // <=== panggil dulu supaya tombol default hijau
  fetchMembers(1);       // lalu fetch data
});
</script>
@include('include.htmlend')