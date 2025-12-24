<!-- 🔹 Script Login + Lupa Password -->
<<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = name + "=" + encodeURIComponent(value) + ";expires=" + d.toUTCString() + ";path=/";
}
function getCookie(name) {
    const cname = name + "=";
    const decoded = decodeURIComponent(document.cookie);
    for (let c of decoded.split(';')) {
        c = c.trim();
        if (c.indexOf(cname) === 0) return c.substring(cname.length);
    }
    return "";
}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const btnLogin = document.getElementById("btnLogin");
    const btnText = document.getElementById("btnText");
    const spinner = document.getElementById("spinner");
    const errorMsg = document.getElementById("errorMsg");
    const remember = document.getElementById("remember");
    const forgotBtn = document.getElementById("forgotBtn");
    const forgotModal = document.getElementById("forgotModal");
    const closeModal = document.getElementById("closeModal");
    const forgotForm = document.getElementById("forgotForm");
    const forgotEmail = document.getElementById("forgotEmail");
    const forgotMember = document.getElementById("forgotMember");
    const apiLogin = "{{ api_url('/api/auth/login') }}";
    const apiForgot   = "{{ api_url('/api/auth/forgot-password') }}";
     


    /* ===============================
       🧠 Remember Email (Cookie)
    =============================== */
    const savedEmail = getCookie("remember_email");
    if (savedEmail) {
        document.getElementById("email").value = savedEmail;
        remember.checked = true;
    }

    /* ===============================
       🔐 Handle Login
    =============================== */
    async function handleLogin(email, password) {
        try {
            const res = await axios.post(apiLogin, { email, password });
            const data = res.data;

            if (data.access_token && data.user) {
    
                if (data.user.role === "admin") {
                    localStorage.setItem("jwt_token_admin", data.access_token);
                    localStorage.setItem("user_admin", JSON.stringify(data.user));
                    window.location.href = "/dashboard";
                } else if (data.user.role === "cs") {
                    localStorage.setItem("jwt_token_cs", data.access_token);
                    localStorage.setItem("user_cs", JSON.stringify(data.user));
                    window.location.href = "/dashboardCS";
                } else {
                    localStorage.setItem("jwt_token_user", data.access_token);
                    localStorage.setItem("user_user", JSON.stringify(data.user));
                    window.location.href = "/new-dashboard";
                }

                // Simpan / hapus cookie email
                remember.checked
                    ? setCookie("remember_email", email, 30)
                    : setCookie("remember_email", "", -1);
            } else {
                errorMsg.textContent = data.message || "Login gagal, periksa email/password.";
                errorMsg.classList.remove("hidden");
            }
        } catch (err) {
            errorMsg.textContent = err.response?.data?.message || "Terjadi kesalahan server.";
            errorMsg.classList.remove("hidden");
        } finally {
            btnLogin.disabled = false;
            btnText.textContent = "Masuk";
            spinner.classList.add("hidden");
        }
    }

    /* ===============================
       📧 Lupa Password
    =============================== */
    async function handleForgotPassword(email, member_id) {
        try {
            const res = await axios.post(apiForgot, { email, member_id });
            const data = res.data;
            if (data.success) {
                forgotEmail.value = "";
                forgotMember.value = "";
                forgotModal.classList.add("hidden");
                alert("✅ Password baru telah dikirim ke email Anda.");
            } else {
                alert("⚠️ " + (data.message || "Email atau nomor member tidak cocok."));
            }
        } catch (err) {
            alert("❌ " + (err.response?.data?.message || "Terjadi kesalahan saat reset password."));
        }
    }

    /* ===============================
       🧾 Event Listener
    =============================== */
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        errorMsg.classList.add("hidden");

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        btnLogin.disabled = true;
        btnText.textContent = "Loading...";
        spinner.classList.remove("hidden");

        handleLogin(email, password);
    });

    forgotBtn.addEventListener("click", () => forgotModal.classList.remove("hidden"));
    closeModal.addEventListener("click", () => forgotModal.classList.add("hidden"));
    forgotForm.addEventListener("submit", (e) => {
        e.preventDefault();
        handleForgotPassword(forgotEmail.value, forgotMember.value);
    });
      document.getElementById('togglePassword').addEventListener('click', () => {
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.innerHTML = isHidden
      ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.658-3.11m3.153-2.38A9.98 9.98 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.98 9.98 0 01-4.133 4.487M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`
      : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><circle cx="12" cy="12" r="3"/>`;
});

document.getElementById('toggleConfirmPassword').addEventListener('click', () => {
    const input = document.getElementById('confirmPassword');
    const icon = document.getElementById('eyeConfirmIcon');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.innerHTML = isHidden
      ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.658-3.11m3.153-2.38A9.98 9.98 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.98 9.98 0 01-4.133 4.487M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`
      : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><circle cx="12" cy="12" r="3"/>`;
});
});
</script>
