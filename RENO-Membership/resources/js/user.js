import api from "./api";

document.addEventListener("DOMContentLoaded", async () => {
    try {
        const response = await api.get("/user");
        const user = response.data;

        // Isi data user ke navbar
        document.querySelectorAll(".user-name").forEach(el => el.innerText = user.name);
        document.querySelectorAll(".user-email").forEach(el => el.innerText = user.email);

        const photo = user.profile_photo ?? "/images/generalUser.png";
        document.querySelectorAll(".user-photo").forEach(el => el.src = photo);

        // Tampilkan menu sesuai role
        if (user.role === "admin") {
            document.querySelectorAll(".menu-admin").forEach(el => el.classList.remove("hidden"));
        }
        if (user.role === "member") {
            document.querySelectorAll(".menu-member").forEach(el => el.classList.remove("hidden"));
        }
    } catch (error) {
        console.error(error);
        localStorage.removeItem("token");
        window.location.href = "/login";
    }
});
