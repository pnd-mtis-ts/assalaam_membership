@include('include.htmlstart')
@include('include.sideadmin')

<div class="w-full sm:ml-64">
  <div class="mt-24 p-3 sm:p-6 flex flex-col min-h-screen w-full gap-6">

    <!-- HEADER -->
    <div
      class="flex justify-between items-center rounded-xl
             bg-gradient-to-tr from-[oklch(97% 0 0)] to-[#22AA62]
             text-white shadow-md -mt-6 p-6">
      <span class="text-lg sm:text-xl font-semibold text-zinc-950">
        Daftar Admin & CS
      </span>
    </div>

    <!-- FILTER ROLE -->
    <div class="flex justify-center gap-3 mb-4">
      <button onclick="setRole('all')" id="btnAll"
        class="px-4 py-2 rounded-lg font-semibold shadow bg-green-600 text-white">
        Semua
      </button>
      <button onclick="setRole('admin')" id="btnAdmin"
        class="px-4 py-2 rounded-lg font-semibold shadow bg-gray-300 text-gray-800">
        Admin
      </button>
      <button onclick="setRole('cs')" id="btnCs"
        class="px-4 py-2 rounded-lg font-semibold shadow bg-gray-300 text-gray-800">
        CS
      </button>
    </div>

    <!-- SEARCH -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
      <input id="search"
        type="text"
        placeholder="Cari nama / email..."
        class="px-4 py-2 border rounded-lg w-full sm:w-64
               focus:ring-2 focus:ring-green-400 outline-none">

      <button onclick="loadUsers(1)"
        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
        Cari
      </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-2 md:p-0">
      <table class="w-full table-auto hidden md:table">
        <thead class="bg-green-100">
          <tr>
            <th class="py-3 px-4 text-left">Nama</th>
            <th class="py-3 px-4 text-left">Email</th>
            <th class="py-3 px-4 text-left">Role</th>
            <th class="py-3 px-4 text-left">Dibuat</th>
          </tr>
        </thead>
        <tbody id="tableDesktop"></tbody>
      </table>

      <!-- MOBILE CARD -->
      <div id="tableMobile" class="flex flex-col gap-4 md:hidden"></div>

      <!-- PAGINATION -->
      <div id="pagination"
        class="flex justify-center items-center gap-2 mt-6 mb-4">
      </div>
    </div>

  </div>
</div>
<!-- GLOBAL LOADING -->
<div
  id="cssLoader"
  class="fixed inset-0 bg-black/40 hidden
         items-center justify-center z-[9999]">

  <div class="w-14 h-14
              border-4 border-gray-300
              border-t-green-500
              rounded-full animate-spin">
  </div>
</div>


@include('include.htmlend')


<script>
const API_URL = "{{ api_url('/api/admin/users-admin-cs') }}";
const TOKEN   = localStorage.getItem('jwt_token_admin');

let currentRole = 'all';
const loadingEl = document.getElementById('cssLoader');


/* =====================
   LOADING HANDLER
===================== */
function showLoading() {
  if (!loadingEl) return;
  loadingEl.classList.remove('hidden');
  loadingEl.classList.add('flex');
}

function hideLoading() {
  if (!loadingEl) return;
  setTimeout(() => {
    loadingEl.classList.add('hidden');
    loadingEl.classList.remove('flex');
  }, 200);
}

/* =====================
   LOAD DATA
===================== */
async function loadUsers(page = 1) {
  showLoading();

  try {
    const searchEl = document.getElementById('search');
    const q = searchEl ? searchEl.value : '';

    const url = `${API_URL}?page=${page}&role=${currentRole}&q=${encodeURIComponent(q)}`;

    const res = await fetch(url, {
      headers: {
        Authorization: `Bearer ${TOKEN}`,
        Accept: 'application/json'
      }
    });

    if (res.status === 401 || res.status === 403) {
      alert('Akses ditolak / Token expired');
      return;
    }

    const json = await res.json();

    renderDesktop(json.data || [], page);
    renderMobile(json.data || []);
    renderPagination(json.pagination || {});

  } catch (err) {
    console.error(err);
    alert('Gagal memuat data');
  } finally {
    setTimeout(hideLoading, 300);
  }
}
function formatDate(dateStr) {
  if (!dateStr) return '-';
  const d = new Date(dateStr);
  return d.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
}


/* =====================
   DESKTOP TABLE
===================== */
function renderDesktop(data) {
  const tbody = document.getElementById('tableDesktop');
  if (!tbody) return;

  tbody.innerHTML = '';

  if (!data.length) {
    tbody.innerHTML = `
      <tr>
        <td colspan="4" class="text-center py-6 text-gray-500">
          Data tidak ditemukan
        </td>
      </tr>`;
    return;
  }

  data.forEach(u => {
    const badge =
      u.role === 'admin'
        ? 'bg-red-100 text-red-700'
        : 'bg-blue-100 text-blue-700';

    tbody.innerHTML += `
      <tr class="border-b hover:bg-gray-50 transition">
        <td class="px-4 py-3 font-medium">${u.name}</td>
        <td class="px-4 py-3">${u.email}</td>
        <td class="px-4 py-3">
          <span class="px-3 py-1 rounded-full text-xs font-semibold ${badge}">
            ${u.role.toUpperCase()}
          </span>
        </td>
        <td class="px-4 py-3 text-sm text-gray-500">
          ${formatDate(u.created_at)}
        </td>
      </tr>`;
  });
}

/* =====================
   MOBILE CARD
===================== */
function renderMobile(data) {
  const container = document.getElementById('tableMobile');
  if (!container) return;

  container.innerHTML = '';

  if (!data.length) {
    container.innerHTML = `
      <div class="text-center text-gray-500 py-6">
        Data tidak ditemukan
      </div>`;
    return;
  }

  data.forEach(u => {
    const badge =
      u.role === 'admin'
        ? 'bg-red-100 text-red-700'
        : 'bg-blue-100 text-blue-700';

    container.innerHTML += `
      <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-2">
        <div class="flex justify-between items-center">
          <span class="font-semibold">${u.name}</span>
          <span class="px-2 py-1 text-xs rounded-full ${badge}">
            ${u.role.toUpperCase()}
          </span>
        </div>
        <div class="text-sm text-gray-600">${u.email}</div>
        <div class="text-xs text-gray-400">${formatDate(u.created_at)}</div>
      </div>`;
  });
}

/* =====================
   PAGINATION
===================== */
function renderPagination(p) {
  const el = document.getElementById('pagination');
  if (!el || !p.last_page) return;

  el.innerHTML = '';

  for (let i = 1; i <= p.last_page; i++) {
    el.innerHTML += `
      <button onclick="loadUsers(${i})"
        class="px-3 py-1 rounded-lg border text-sm transition
        ${i === p.current_page
          ? 'bg-green-600 text-white'
          : 'bg-white hover:bg-gray-100'}">
        ${i}
      </button>`;
  }
}

/* =====================
   ROLE FILTER
===================== */
function setRole(role) {
  currentRole = role;

  const buttons = {
    all: 'btnAll',
    admin: 'btnAdmin',
    cs: 'btnCs'
  };

  Object.values(buttons).forEach(id => {
    const btn = document.getElementById(id);
    if (!btn) return;
    btn.classList.remove('bg-green-600', 'text-white');
    btn.classList.add('bg-gray-300', 'text-gray-800');
  });

  const activeBtn = document.getElementById(buttons[role]);
  if (activeBtn) {
    activeBtn.classList.remove('bg-gray-300', 'text-gray-800');
    activeBtn.classList.add('bg-green-600', 'text-white');
  }

  loadUsers(1);
}

/* =====================
   INIT
===================== */
document.addEventListener('DOMContentLoaded', () => {
  loadUsers();
});

</script>
