@include('include.htmlstart')
@include('include.sideadmin')

<div class="w-full sm:ml-64 mt-16 p-4">
  <main class="max-w-md mx-auto bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg transition-transform transform hover:scale-105 duration-300">

    <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200 text-center">
      Update Minimal Poin Reminder
    </h2>

    <!-- INFO MINIMAL POIN SAAT INI -->
    <div id="infoPoin" class="mb-4 p-4 bg-green-50 border border-green-300 text-green-800 rounded-lg text-center font-semibold">
      Memuat minimal poin...
    </div>

    <label for="minimalPoin" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">
      Minimal Poin Baru:
    </label>

    <input type="number" id="minimalPoin"
      class="w-full p-3 border rounded-lg mb-4 focus:ring-2 focus:ring-green-400 focus:border-transparent transition duration-300"
      placeholder="Masukkan minimal poin baru" min="0">

    <button id="updateBtn"
      class="w-full bg-green-500 hover:bg-green-600 active:bg-green-700 text-white font-semibold py-3 rounded-lg shadow-md transform hover:scale-105 transition duration-200">
      Update
    </button>

  </main>
</div>

<!-- Popup Notification -->
<div id="popup"
  class="fixed top-5 left-1/2 -translate-x-1/2 bg-green-500 text-white font-semibold px-6 py-3 rounded-xl shadow-lg opacity-0 pointer-events-none transform -translate-y-10 transition-all duration-500 z-50">
  Minimal poin berhasil diupdate!
</div>

<script>
  const token = localStorage.getItem("jwt_token_admin");

  const updateBtn = document.getElementById('updateBtn');
  const minimalPoinInput = document.getElementById('minimalPoin');
  const popup = document.getElementById('popup');
  const infoPoin = document.getElementById('infoPoin');

  const apiUpdate = "{{ api_url('/api/minimal-poin/update') }}";
  const apiGet = "{{ api_url('/api/minimal-poin') }}";

  // =======================
  // LOAD NILAI MINIMAL POIN SAAT INI
  // =======================
  async function loadMinimalPoin() {
    try {
      const response = await fetch(apiGet, {
        headers: { "Authorization": "Bearer " + token }
      });

      const data = await response.json();

      if (response.ok) {
        infoPoin.textContent = `Minimal Poin Saat Ini: ${data.minimal_poin}`;
      } else {
        infoPoin.textContent = "Gagal memuat nilai minimal poin.";
        infoPoin.classList.replace("bg-green-50", "bg-red-50");
        infoPoin.classList.replace("text-green-800", "text-red-800");
        infoPoin.classList.replace("border-green-300", "border-red-300");
      }

    } catch (error) {
      infoPoin.textContent = "Error saat memuat minimal poin.";
      infoPoin.classList.replace("bg-green-50", "bg-red-50");
      infoPoin.classList.replace("text-green-800", "text-red-800");
      infoPoin.classList.replace("border-green-300", "border-red-300");
    }
  }

  loadMinimalPoin(); // Panggil saat halaman dibuka

  // =======================
  // POPUP
  // =======================
  function showPopup(message, success = true) {
    popup.textContent = message;
    popup.classList.remove('opacity-0', '-translate-y-10');
    popup.classList.add('opacity-100', 'translate-y-0');
    popup.style.backgroundColor = success ? '#16a34a' : '#dc2626';

    setTimeout(() => {
      popup.classList.remove('opacity-100', 'translate-y-0');
      popup.classList.add('opacity-0', '-translate-y-10');
    }, 3000);
  }

  // =======================
  // UPDATE NILAI
  // =======================
  updateBtn.addEventListener('click', async () => {
    const minimalPoin = parseInt(minimalPoinInput.value);

    if (isNaN(minimalPoin) || minimalPoin < 0) {
      showPopup('Masukkan nilai minimal poin yang valid.', false);
      return;
    }

    try {
      updateBtn.disabled = true;
      updateBtn.textContent = 'Updating...';

      const response = await fetch(apiUpdate, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({ minimal_poin: minimalPoin })
      });

      const data = await response.json();

      if (response.ok) {
        showPopup('Minimal poin berhasil diupdate!', true);
        loadMinimalPoin(); // refresh info poin
      } else {
        showPopup('Gagal update: ' + (data.message || 'Terjadi kesalahan.'), false);
      }

    } catch (error) {
      showPopup('Error: ' + error.message, false);

    } finally {
      updateBtn.disabled = false;
      updateBtn.textContent = 'Update';
    }
  });
</script>

@include('include.htmlend')
