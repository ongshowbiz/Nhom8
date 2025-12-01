// --- Mã cho Sidebar (từ header.php) ---
document.addEventListener('DOMContentLoaded', function() {

    // Lấy các phần tử
    const toggleBtn = document.getElementById("menu");
    const closeBtn = document.getElementById("closeBtn");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    // Kiểm tra xem các phần tử có tồn tại không
    if (toggleBtn && closeBtn && sidebar && overlay) {

        // Mở sidebar
        toggleBtn.addEventListener("click", () => {
          sidebar.classList.add("active");
          overlay.classList.add("show");
        });

        // Đóng sidebar
        closeBtn.addEventListener("click", closeSidebar);
        overlay.addEventListener("click", closeSidebar);

        function closeSidebar() {
          sidebar.classList.remove("active");
          overlay.classList.remove("show");
        }

    } else {
        // Báo lỗi trên console nếu không tìm thấy
        console.error("Lỗi: Không tìm thấy các phần tử của sidebar.");
    }
});