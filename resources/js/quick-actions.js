// Dashboard Quick Actions Module
export class DashboardQuickActions {
    constructor() {
        this.initRealTimeUpdates();
        this.bindExportFunctions();
    }

    // Initialize real-time dashboard updates
    initRealTimeUpdates() {
        if (document.querySelector(".quick-action-card")) {
            this.updatePendingApprovals();
            this.updateSystemStatus();

            // Update every 2 minutes
            setInterval(() => {
                this.updatePendingApprovals();
                this.updateSystemStatus();
            }, 120000);
        }
    }

    // Update pending approvals count
    async updatePendingApprovals() {
        try {
            const response = await fetch("/api/dashboard/pending-approvals");
            const data = await response.json();

            if (data.success) {
                // Update leave requests count
                const leaveCountElement =
                    document.getElementById("pendingLeaveCount");
                if (leaveCountElement) {
                    leaveCountElement.textContent =
                        data.data.leave_requests.count;

                    // Update badge color based on count
                    const badge = leaveCountElement.closest(".badge");
                    if (badge) {
                        badge.classList.remove(
                            "bg-warning",
                            "bg-danger",
                            "bg-success"
                        );
                        if (data.data.leave_requests.count > 10) {
                            badge.classList.add("bg-danger");
                        } else if (data.data.leave_requests.count > 5) {
                            badge.classList.add("bg-warning");
                        } else {
                            badge.classList.add("bg-success");
                        }
                    }
                }

                // Update payroll count
                const payrollCountElement = document.getElementById(
                    "pendingPayrollCount"
                );
                if (payrollCountElement) {
                    payrollCountElement.textContent =
                        data.data.payroll_pending.count;
                }
            }
        } catch (error) {
            console.error("Error updating pending approvals:", error);
        }
    }

    // Update system status cards
    async updateSystemStatus() {
        try {
            // Update attendance rate
            const response = await fetch("/api/dashboard/employee-performance");
            const data = await response.json();

            if (data.success && data.data.length > 0) {
                const avgAttendanceRate =
                    data.data.reduce(
                        (sum, emp) => sum + emp.attendance_rate,
                        0
                    ) / data.data.length;

                const attendanceElement =
                    document.getElementById("avgAttendanceRate");
                if (attendanceElement) {
                    attendanceElement.textContent =
                        Math.round(avgAttendanceRate) + "%";

                    // Update color based on performance
                    attendanceElement.classList.remove(
                        "text-success",
                        "text-warning",
                        "text-danger"
                    );
                    if (avgAttendanceRate >= 95) {
                        attendanceElement.classList.add("text-success");
                    } else if (avgAttendanceRate >= 85) {
                        attendanceElement.classList.add("text-warning");
                    } else {
                        attendanceElement.classList.add("text-danger");
                    }
                }
            }

            // Update monthly leave requests
            const leaveResponse = await fetch(
                "/api/dashboard/leave-statistics"
            );
            const leaveData = await leaveResponse.json();

            if (leaveData.success) {
                const currentMonth = new Date().getMonth() + 1;
                const monthlyData = leaveData.data.monthly_trends.find(
                    (item) => item.month == currentMonth
                );

                if (monthlyData) {
                    const monthlyLeaveElement = document.getElementById(
                        "monthlyLeaveRequests"
                    );
                    if (monthlyLeaveElement) {
                        monthlyLeaveElement.textContent =
                            monthlyData.total_requests;
                    }
                }
            }

            // Update monthly payroll amount
            const payrollResponse = await fetch(
                "/api/dashboard/monthly-payroll"
            );
            const payrollData = await payrollResponse.json();

            if (payrollData.success) {
                const currentMonth = new Date().getMonth() + 1;
                const monthlyPayroll = payrollData.data.find(
                    (item) => item.month == currentMonth
                );

                if (monthlyPayroll) {
                    const payrollElement = document.getElementById(
                        "monthlyPayrollAmount"
                    );
                    if (payrollElement) {
                        const amount = new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0,
                        }).format(monthlyPayroll.total_amount);
                        payrollElement.textContent = amount;
                    }
                }
            }
        } catch (error) {
            console.error("Error updating system status:", error);
        }
    }

    // Bind export functions to global scope
    bindExportFunctions() {
        window.exportReport = this.exportReport.bind(this);
        window.quickAction = this.quickAction.bind(this);
    }

    // Export report function
    async exportReport(type) {
        const loadingToast = this.showLoadingToast(
            `Mengexport laporan ${type}...`
        );

        try {
            let url = "";
            let filename = "";

            switch (type) {
                case "attendance":
                    url = "/export/absensi";
                    filename = `laporan-absensi-${
                        new Date().toISOString().split("T")[0]
                    }.xlsx`;
                    break;
                case "payroll":
                    url = "/export/penggajian";
                    filename = `laporan-penggajian-${
                        new Date().toISOString().split("T")[0]
                    }.xlsx`;
                    break;
                case "employees":
                    url = "/export/karyawan";
                    filename = `data-karyawan-${
                        new Date().toISOString().split("T")[0]
                    }.xlsx`;
                    break;
                case "leave":
                    url = "/export/cuti";
                    filename = `laporan-cuti-${
                        new Date().toISOString().split("T")[0]
                    }.xlsx`;
                    break;
                default:
                    throw new Error("Unknown report type");
            }

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error("Export failed");
            }

            const blob = await response.blob();
            const downloadUrl = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = downloadUrl;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(downloadUrl);
            document.body.removeChild(a);

            this.hideLoadingToast(loadingToast);
            this.showSuccessToast(`Laporan ${type} berhasil didownload!`);
        } catch (error) {
            this.hideLoadingToast(loadingToast);
            this.showErrorToast(
                `Gagal mengexport laporan ${type}. Silakan coba lagi.`
            );
            console.error("Export error:", error);
        }
    }

    // Quick action function for future use
    quickAction(action, data = null) {
        switch (action) {
            case "approve-leave":
                this.approveLeaveRequest(data);
                break;
            case "process-payroll":
                this.processPayroll(data);
                break;
            case "refresh-data":
                this.refreshDashboardData();
                break;
            default:
                console.warn("Unknown quick action:", action);
        }
    }

    // Refresh all dashboard data
    refreshDashboardData() {
        this.updatePendingApprovals();
        this.updateSystemStatus();

        // Refresh charts if available
        if (window.dashboardCharts) {
            window.dashboardCharts.refreshAllCharts();
        }

        this.showSuccessToast("Data dashboard berhasil diperbarui!");
    }

    // Toast notification helpers
    showLoadingToast(message) {
        return this.createToast("info", message, 0); // 0 = no auto hide
    }

    showSuccessToast(message) {
        return this.createToast("success", message, 5000);
    }

    showErrorToast(message) {
        return this.createToast("danger", message, 7000);
    }

    hideLoadingToast(toastElement) {
        if (toastElement && toastElement.parentNode) {
            toastElement.remove();
        }
    }

    createToast(type, message, autoHide = 5000) {
        const toast = document.createElement("div");
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            border: none;
            border-radius: 12px;
        `;

        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-${this.getToastIcon(type)} me-2"></i>
                <div>${message}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        `;

        document.body.appendChild(toast);

        if (autoHide > 0) {
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, autoHide);
        }

        return toast;
    }

    getToastIcon(type) {
        switch (type) {
            case "success":
                return "check-circle";
            case "danger":
                return "exclamation-triangle";
            case "warning":
                return "exclamation-circle";
            case "info":
                return "info-circle";
            default:
                return "info-circle";
        }
    }
}

// Initialize quick actions when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector(".quick-action-card")) {
        window.dashboardQuickActions = new DashboardQuickActions();
    }
});
