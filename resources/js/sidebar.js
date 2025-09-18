$(document).ready(function () {
    $("#sidebarMenu").on("show.bs.collapse", function () {
        $("body").addClass("sidebar-open");
    });

    $("#sidebarMenu").on("hide.bs.collapse", function () {
        $("body").removeClass("sidebar-open");
    });

    function cekJumlahNotifikasi() {
        $.ajax({
            url: "/getNotifikasiCount", // Url endpoint untuk mendapatkan jumlah notifikasi untuk user yang login
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.count > 0) {
                    // Update badge atau tampilan notifikasi di frontend
                    $(".badge-notifikasi").text(response.count);
                    $(".penanda-notifikasi").removeClass("d-none");
                } else {
                    // Update badge atau tampilan notifikasi di frontend
                    $(".badge-notifikasi").text("");
                    $(".penanda-notifikasi").addClass("d-none");
                }
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(
                    "Terjadi kesalahan saat mengambil data notifikasi."
                );
            },
        });
    }

    cekJumlahNotifikasi();

    // Panggil fungsi cekJumlahNotifikasi setiap 5 detik
    setInterval(cekJumlahNotifikasi, 5000); // Setiap 5 detik
});
