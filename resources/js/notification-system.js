// Enhanced Notification System Module
export class NotificationSystem {
    constructor() {
        this.refreshInterval = null;
        this.initNotificationSystem();
        this.bindEventHandlers();
        this.startPeriodicRefresh();
    }

    initNotificationSystem() {
        // Load initial notification count and recent notifications
        this.updateNotificationCount();
        this.loadRecentNotifications();
    }

    bindEventHandlers() {
        // Mark all as read button
        const markAllReadBtn = document.getElementById("markAllReadBtn");
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener("click", (e) => {
                e.preventDefault();
                this.markAllAsRead();
            });
        }

        // Refresh notifications when dropdown is opened
        const notificationDropdown = document.getElementById(
            "notificationDropdown"
        );
        if (notificationDropdown) {
            notificationDropdown.addEventListener("shown.bs.dropdown", () => {
                this.loadRecentNotifications();
            });
        }
    }

    async updateNotificationCount() {
        try {
            const response = await fetch("/getNotifikasiCount");
            const data = await response.json();

            const badges = document.querySelectorAll(".badge-notifikasi");
            const counts = document.querySelectorAll(".notification-count");
            const indicators = document.querySelectorAll(".penanda-notifikasi");

            if (data.count > 0) {
                badges.forEach((badge) => {
                    badge.classList.remove("d-none");
                });
                counts.forEach((count) => {
                    count.textContent = data.count > 99 ? "99+" : data.count;
                });
                indicators.forEach((indicator) => {
                    indicator.classList.remove("d-none");
                });
            } else {
                badges.forEach((badge) => {
                    badge.classList.add("d-none");
                });
                indicators.forEach((indicator) => {
                    indicator.classList.add("d-none");
                });
            }
        } catch (error) {
            console.error("Error updating notification count:", error);
        }
    }

    async loadRecentNotifications() {
        const listContainer = document.getElementById("notificationList");
        if (!listContainer) return;

        try {
            const response = await fetch("/api/notifications/recent");
            const data = await response.json();

            if (data.success) {
                this.renderNotifications(data.data);
                this.updateNotificationBadge(data.unread_count);
            } else {
                this.showNotificationError();
            }
        } catch (error) {
            console.error("Error loading recent notifications:", error);
            this.showNotificationError();
        }
    }

    renderNotifications(notifications) {
        const listContainer = document.getElementById("notificationList");

        if (notifications.length === 0) {
            listContainer.innerHTML = `
                <div class="text-center py-4">
                    <i class="bi bi-bell-slash text-muted" style="font-size: 2rem;"></i>
                    <p class="small text-muted mt-2 mb-0">Tidak ada notifikasi</p>
                </div>
            `;
            return;
        }

        const notificationItems = notifications
            .map((notification) => {
                const isUnread = !notification.is_read;
                const timeAgo = notification.time;

                return `
                <div class="notification-item ${
                    isUnread ? "unread" : ""
                }" data-id="${notification.id}">
                    <div class="d-flex align-items-start p-3 border-bottom">
                        <div class="notification-indicator ${
                            isUnread ? "active" : ""
                        }"></div>
                        <div class="notification-content flex-grow-1">
                            <p class="notification-message mb-1">${
                                notification.message
                            }</p>
                            <small class="notification-time text-muted">${timeAgo}</small>
                        </div>
                        ${
                            isUnread
                                ? `
                            <button class="btn btn-sm btn-link p-1 mark-read-btn" data-id="${notification.id}" title="Tandai dibaca">
                                <i class="bi bi-check2"></i>
                            </button>
                        `
                                : ""
                        }
                    </div>
                </div>
            `;
            })
            .join("");

        listContainer.innerHTML = notificationItems;

        // Bind click handlers for mark as read buttons
        this.bindMarkAsReadHandlers();
    }

    bindMarkAsReadHandlers() {
        const markReadBtns = document.querySelectorAll(".mark-read-btn");
        markReadBtns.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.stopPropagation();
                const notificationId = btn.getAttribute("data-id");
                this.markAsRead(notificationId);
            });
        });
    }

    async markAsRead(notificationId) {
        try {
            const response = await fetch(
                `/api/notifications/${notificationId}/mark-read`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN":
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute("content") || "",
                    },
                }
            );

            const data = await response.json();

            if (data.success) {
                // Update the notification item visually
                const notificationItem = document.querySelector(
                    `[data-id="${notificationId}"]`
                );
                if (notificationItem) {
                    notificationItem.classList.remove("unread");
                    const indicator = notificationItem.querySelector(
                        ".notification-indicator"
                    );
                    const markBtn =
                        notificationItem.querySelector(".mark-read-btn");

                    if (indicator) indicator.classList.remove("active");
                    if (markBtn) markBtn.remove();
                }

                // Update notification count
                this.updateNotificationCount();
            }
        } catch (error) {
            console.error("Error marking notification as read:", error);
        }
    }

    async markAllAsRead() {
        try {
            const response = await fetch("/api/notifications/mark-all-read", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "",
                },
            });

            const data = await response.json();

            if (data.success) {
                // Reload notifications
                this.loadRecentNotifications();
                this.updateNotificationCount();

                // Show success message
                this.showToast(
                    "success",
                    "Semua notifikasi telah ditandai sebagai dibaca"
                );
            }
        } catch (error) {
            console.error("Error marking all notifications as read:", error);
            this.showToast("danger", "Gagal menandai semua notifikasi");
        }
    }

    updateNotificationBadge(unreadCount) {
        const badges = document.querySelectorAll(".badge-notifikasi");
        const counts = document.querySelectorAll(".notification-count");
        const indicators = document.querySelectorAll(".penanda-notifikasi");

        if (unreadCount > 0) {
            badges.forEach((badge) => badge.classList.remove("d-none"));
            counts.forEach((count) => {
                count.textContent = unreadCount > 99 ? "99+" : unreadCount;
            });
            indicators.forEach((indicator) =>
                indicator.classList.remove("d-none")
            );
        } else {
            badges.forEach((badge) => badge.classList.add("d-none"));
            indicators.forEach((indicator) =>
                indicator.classList.add("d-none")
            );
        }
    }

    showNotificationError() {
        const listContainer = document.getElementById("notificationList");
        if (listContainer) {
            listContainer.innerHTML = `
                <div class="text-center py-4">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                    <p class="small text-muted mt-2 mb-0">Gagal memuat notifikasi</p>
                    <button class="btn btn-sm btn-outline-primary mt-2" onclick="window.notificationSystem.loadRecentNotifications()">
                        <i class="bi bi-arrow-clockwise me-1"></i> Coba Lagi
                    </button>
                </div>
            `;
        }
    }

    startPeriodicRefresh() {
        // Refresh notifications every 30 seconds
        this.refreshInterval = setInterval(() => {
            this.updateNotificationCount();

            // Only refresh the dropdown if it's open
            const dropdown = document.getElementById("notificationDropdown");
            if (dropdown && dropdown.getAttribute("aria-expanded") === "true") {
                this.loadRecentNotifications();
            }
        }, 30000);
    }

    stopPeriodicRefresh() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
            this.refreshInterval = null;
        }
    }

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

        const iconMap = {
            success: "check-circle",
            danger: "exclamation-triangle",
            warning: "exclamation-circle",
            info: "info-circle",
        };

        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-${iconMap[type] || "info-circle"} me-2"></i>
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

    // Public method to refresh notifications (can be called from other modules)
    refresh() {
        this.updateNotificationCount();
        this.loadRecentNotifications();
    }

    // Cleanup method
    destroy() {
        this.stopPeriodicRefresh();
    }
}

// Initialize notification system when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    window.notificationSystem = new NotificationSystem();
});
