import api from "./api";

document.addEventListener("DOMContentLoaded", async () => {
    try {
        // Panggil API admin dashboard
        const response = await api.get("/admin/dashboard");
        const data = response.data;

        // Anggap backend kirim { active_member, inactive_member, total_member }
        document.querySelector("#active-member").innerText = data.active_member;
        document.querySelector("#inactive-member").innerText = data.inactive_member;
        document.querySelector("#total-member").innerText = data.total_member;

        // Progress bar aktif
        const activePercent = Math.round((data.active_member / data.total_member) * 100);
        document.querySelector("#active-progress").style.width = `${activePercent}%`;
        document.querySelector("#active-progress").innerText = `${activePercent}%`;

        // Progress bar tidak aktif
        const inactivePercent = Math.round((data.inactive_member / data.total_member) * 100);
        document.querySelector("#inactive-progress").style.width = `${inactivePercent}%`;
        document.querySelector("#inactive-progress").innerText = `${inactivePercent}%`;

    } catch (error) {
        console.error(error);
        if (error.response?.status === 401) {
            localStorage.removeItem("token");
            window.location.href = "/login";
        }
    }
});
