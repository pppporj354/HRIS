// Employee Dashboard Features Module
export class EmployeeDashboard {
    constructor() {
        this.initCountdownTimer();
        this.initCircleProgress();
        this.initPersonalCharts();
    }

    // Initialize payroll countdown timer
    initCountdownTimer() {
        const countdownElement = document.getElementById("payrollCountdown");
        if (!countdownElement) return;

        // Calculate next payroll date (25th of current/next month)
        const now = new Date();
        const currentDay = now.getDate();

        let nextPayroll;
        if (currentDay <= 25) {
            nextPayroll = new Date(now.getFullYear(), now.getMonth(), 25);
        } else {
            nextPayroll = new Date(now.getFullYear(), now.getMonth() + 1, 25);
        }

        this.updateCountdown(countdownElement, nextPayroll);

        // Update every hour
        setInterval(() => {
            this.updateCountdown(countdownElement, nextPayroll);
        }, 3600000);
    }

    updateCountdown(element, targetDate) {
        const now = new Date().getTime();
        const distance = targetDate.getTime() - now;

        if (distance < 0) {
            element.innerHTML = "Hari pembayaran!";
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );

        if (days > 0) {
            element.innerHTML = `${days} hari ${hours} jam`;
        } else {
            element.innerHTML = `${hours} jam`;
        }
    }

    // Initialize circular progress indicators
    initCircleProgress() {
        const circles = document.querySelectorAll(
            ".circle-progress[data-percentage]"
        );

        circles.forEach((circle) => {
            const percentage = circle.getAttribute("data-percentage");
            const degrees = (percentage / 100) * 360;

            circle.style.setProperty("--percentage", degrees + "deg");

            // Animate the circle
            setTimeout(() => {
                circle.style.transition = "background 1s ease-in-out";
            }, 100);
        });
    }

    // Initialize personal charts for employee
    initPersonalCharts() {
        this.initPersonalAttendanceChart();
        this.initPersonalLeaveChart();
    }

    // Personal Attendance Chart
    async initPersonalAttendanceChart() {
        const ctx = document.getElementById("personalAttendanceChart");
        if (!ctx || typeof Chart === "undefined") return;

        try {
            // Fetch personal attendance data
            const response = await fetch("/api/dashboard/personal-attendance");
            const data = await response.json();

            if (data.success) {
                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: data.data.map((item) => item.month_name),
                        datasets: [
                            {
                                label: "Hari Hadir",
                                data: data.data.map(
                                    (item) => item.present_days
                                ),
                                borderColor: "#10b981",
                                backgroundColor: "rgba(16, 185, 129, 0.1)",
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: "#10b981",
                                pointBorderColor: "#ffffff",
                                pointBorderWidth: 2,
                                pointRadius: 6,
                                pointHoverRadius: 8,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                backgroundColor: "rgba(17, 24, 39, 0.9)",
                                titleColor: "white",
                                bodyColor: "white",
                                borderColor: "#10b981",
                                borderWidth: 1,
                                callbacks: {
                                    label: function (context) {
                                        return `Hadir: ${context.parsed.y} hari`;
                                    },
                                },
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 31,
                                grid: {
                                    color: "rgba(0, 0, 0, 0.1)",
                                },
                                ticks: {
                                    color: "#6b7280",
                                },
                            },
                            x: {
                                grid: {
                                    display: false,
                                },
                                ticks: {
                                    color: "#6b7280",
                                },
                            },
                        },
                        elements: {
                            point: {
                                hoverBackgroundColor: "#059669",
                            },
                        },
                    },
                });
            }
        } catch (error) {
            console.error("Error loading personal attendance chart:", error);
        }
    }

    // Personal Leave Chart
    async initPersonalLeaveChart() {
        const ctx = document.getElementById("personalLeaveChart");
        if (!ctx || typeof Chart === "undefined") return;

        try {
            // Fetch personal leave data
            const response = await fetch("/api/dashboard/personal-leave");
            const data = await response.json();

            if (data.success && data.data) {
                const leaveData = data.data;

                new Chart(ctx, {
                    type: "doughnut",
                    data: {
                        labels: ["Disetujui", "Pending", "Ditolak"],
                        datasets: [
                            {
                                data: [
                                    leaveData.approved || 0,
                                    leaveData.pending || 0,
                                    leaveData.rejected || 0,
                                ],
                                backgroundColor: [
                                    "#10b981",
                                    "#f59e0b",
                                    "#ef4444",
                                ],
                                borderWidth: 0,
                                hoverBorderWidth: 4,
                                hoverBorderColor: "#ffffff",
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: "60%",
                        plugins: {
                            legend: {
                                position: "bottom",
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12,
                                        weight: 500,
                                    },
                                },
                            },
                            tooltip: {
                                backgroundColor: "rgba(17, 24, 39, 0.9)",
                                titleColor: "white",
                                bodyColor: "white",
                                callbacks: {
                                    label: function (context) {
                                        const total =
                                            context.dataset.data.reduce(
                                                (a, b) => a + b,
                                                0
                                            );
                                        const percentage =
                                            total > 0
                                                ? Math.round(
                                                      (context.parsed * 100) /
                                                          total
                                                  )
                                                : 0;
                                        return `${context.label}: ${context.parsed} (${percentage}%)`;
                                    },
                                },
                            },
                        },
                    },
                });
            }
        } catch (error) {
            console.error("Error loading personal leave chart:", error);
        }
    }

    // Refresh personal dashboard data
    refreshPersonalData() {
        // Reload personal charts
        this.initPersonalCharts();

        // Show success message
        this.showToast("success", "Data personal berhasil diperbarui!");
    }

    // Toast notification helper
    showToast(type, message) {
        const toast = document.createElement("div");
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        `;

        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle me-2"></i>
                <div>${message}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 5000);
    }
}

// Initialize employee dashboard when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector(".employee-widget-card")) {
        window.employeeDashboard = new EmployeeDashboard();
    }
});
