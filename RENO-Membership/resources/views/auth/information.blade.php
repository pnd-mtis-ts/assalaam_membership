@include('include.htmlstart')
@include('include.sidemember')

<div class="w-full overflow-y-hidden sm:ml-64 overflow-x-hidden">
    <div class="mt-20 mb-2 py-6 mx-4 card rounded-lg h-screen shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-start text-white">
            <div class="hidden sm:block absolute rounded-full top-1 -right-10">
                <img src="{{ asset('images/inf.png') }}" class="w-[500px] relative animate-fadeIn" alt="">
            </div>
            <img src="{{ asset('images/inf.png') }}" class="w-[350px] -mt-4 relative block sm:hidden animate-fadeIn" alt="">
        </div>

        <div class="text-white flex flex-col sm:mt-14 p-2 sm:p-6">
            <!-- Nama dari API -->
            <span id="user-nama-desktop" class="hidden sm:block font-bold text-5xl text-[#019A4C]">Terimakasih ...</span>
            <span id="user-nama-mobile" class="block sm:hidden font-bold text-3xl text-[#019A4C]">Terimakasih ...</span>

            <span class="hidden sm:block font-bold text-[40px] -mt-2 text-orange-400">
                Sudah mendaftar <br>
                <p class="-mt-4"> Member PAS </p>
            </span>
            <span class="block sm:hidden font-bold text-4xl -mt-1 text-orange-400">
                Sudah mendaftar <p class="-mt-2">Member PAS </p>
            </span>

            <p class="block sm:hidden ml-1 dark:text-gray-50 text-gray-800">
                Untuk mengaktifkan kartu member dan menikmati fungsi yang ada di web ini silahkan datang langsung ke
                ASSALAAM HYPERMARKET untuk menemui Customer Service dan melakukan pengaktifan kartu member.
            </p>
            <p class="hidden sm:block dark:text-gray-50 text-gray-800">Untuk mengaktifkan kartu member dan menikmati layanan</p>
            <p class="hidden sm:block dark:text-gray-50 text-gray-800">di web ini silahkan datang langsung ke ASSALAAM HYPERMARKET</p>
            <p class="hidden sm:block dark:text-gray-50 text-gray-800">untuk menemui Customer Service dan melakukan pengaktifan</p>
            <p class="hidden sm:block dark:text-gray-50 text-gray-800">kartu member.</p>

            <div class="ml-2 mt-2 sm:mt-0 sm:ml-4">
                <button onclick="inf.showModal()"
                    class="flex sm:mt-10 overflow-hidden ring-[3px] ring-white w-[8.5rem] hover:w-[9.8rem] items-center gap-2 cursor-pointer bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white px-8 py-2 rounded-full transition-all ease-in-out hover:scale-105 active:scale-100 shadow-lg">
                    Informasi
                    <svg class="size-6 mt-0.5" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Zm-7.518-.267A8.25 8.25 0 1 1 20.25 10.5M8.288 14.212A5.25 5.25 0 1 1 17.25 10.5"
                            stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Lokasi -->
    <dialog id="inf" class="modal">
        <div class="modal-box overflow-hidden">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Lokasi Assalaam Hypermarket</h3>
            <p class="text-gray-600 mb-2">Jl. Ahmad Yani No.123, Surakarta</p>
            <div class="hidden sm:block">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.1377673671195!2d110.75987100863468!3d-7.559954174620375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a1459d1b9f281%3A0xae2b9afbb1c52243!2sAssalaam%20Hypermarket!5e0!3m2!1sid!2sid!4v1735872589579!5m2!1sid!2sid"
                    width="470" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
            <div class="block sm:hidden">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.1377673671195!2d110.75987100863468!3d-7.559954174620375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a1459d1b9f281%3A0xae2b9afbb1c52243!2sAssalaam%20Hypermarket!5e0!3m2!1sid!2sid!4v1735872589579!5m2!1sid!2sid"
                    width="310" height="280" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </dialog>
</div>

@include('include.htmlend')

<script>
    // ambil nama user dari API
    async function loadUserName() {
        try {
            let res = await fetch("http://127.0.0.1:8001/api/auth/dashboardd", {
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token")
                }
            });
            let json = await res.json();
            let nama = json.user?.name || "User";

            document.getElementById("user-nama-desktop").innerText = "Terimakasih " + nama + ",";
            document.getElementById("user-nama-mobile").innerText = "Terimakasih " + nama + ",";
        } catch (err) {
            console.error("Gagal ambil nama:", err);
        }
    }

    loadUserName();
</script>
