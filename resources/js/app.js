// import bootstrap javascript from file bootstrap.js
import "./bootstrap";

//import popper
import * as Popper from "@popperjs/core";
window.Popper = Popper;

// import datatables component
import "datatables.net-bs5";
import "datatables.net-buttons-bs5";

// import Chart.js
import {
    Chart,
    CategoryScale,
    LinearScale,
    BarElement,
    LineElement,
    PointElement,
    ArcElement,
    Title,
    Tooltip,
    Legend,
} from 'chart.js';

// Register Chart.js components
Chart.register(
    CategoryScale,
    LinearScale,
    BarElement,
    LineElement,
    PointElement,
    ArcElement,
    Title,
    Tooltip,
    Legend
);

// Make Chart available globally
window.Chart = Chart;

// make sure folder assets inside resource can be accessed through vite
import.meta.glob(["../assets/**"]);

// Dashboard interactions
document.addEventListener("DOMContentLoaded", function () {
    // Mobile sidebar functionality
    const sidebarToggle = document.getElementById("sidebar-toggle");
    const sidebar = document.querySelector(".sidebar");

    if (sidebarToggle && sidebar) {
        // Create overlay for mobile
        const overlay = document.createElement("div");
        overlay.className = "sidebar-overlay";
        document.body.appendChild(overlay);

        sidebarToggle.addEventListener("click", function () {
            sidebar.classList.toggle("show");
            overlay.classList.toggle("show");
            document.body.classList.toggle("sidebar-open");
        });

        // Close sidebar when clicking overlay
        overlay.addEventListener("click", function () {
            sidebar.classList.remove("show");
            overlay.classList.remove("show");
            document.body.classList.remove("sidebar-open");
        });

        // Close sidebar when clicking navigation links on mobile
        if (window.innerWidth <= 767) {
            const navLinks = sidebar.querySelectorAll(".nav-link");
            navLinks.forEach((link) => {
                link.addEventListener("click", function () {
                    sidebar.classList.remove("show");
                    overlay.classList.remove("show");
                    document.body.classList.remove("sidebar-open");
                });
            });
        }
    }

    // Add hover effect to activity feed items
    const activityItems = document.querySelectorAll(".activity-feed-item");
    if (activityItems) {
        activityItems.forEach((item) => {
            item.addEventListener("mouseenter", function () {
                this.querySelector(".activity-feed-content").style.boxShadow =
                    "0 4px 12px rgba(0,0,0,0.08)";
            });
            item.addEventListener("mouseleave", function () {
                this.querySelector(".activity-feed-content").style.boxShadow =
                    "0 1px 3px rgba(0,0,0,0.05)";
            });
        });
    }

    // Initialize tooltips if Bootstrap 5 is available
    if (typeof bootstrap !== "undefined" && bootstrap.Tooltip) {
        const tooltips = document.querySelectorAll(
            '[data-bs-toggle="tooltip"]'
        );
        tooltips.forEach((tooltip) => {
            new bootstrap.Tooltip(tooltip);
        });
    }

    // Touch-friendly enhancements for mobile devices
    if ("ontouchstart" in window) {
        // Add touch class to body for CSS targeting
        document.body.classList.add("touch-device");

        // Improve button tap targets
        const buttons = document.querySelectorAll(
            ".btn, .nav-link, .dropdown-item"
        );
        buttons.forEach((button) => {
            button.addEventListener("touchstart", function () {
                this.classList.add("touching");
            });

            button.addEventListener("touchend", function () {
                setTimeout(() => {
                    this.classList.remove("touching");
                }, 150);
            });
        });
    }

    // Initialize dashboard charts if on dashboard page
    if (document.querySelector('.dashboard-charts')) {
        import('./dashboard-charts.js').catch(error => {
            console.error('Error loading dashboard charts:', error);
        });
    }

    // Initialize quick actions if on dashboard page
    if (document.querySelector('.quick-action-card')) {
        import('./quick-actions.js').catch(error => {
            console.error('Error loading quick actions:', error);
        });
    }

    // Initialize employee dashboard if on dashboard page
    if (document.querySelector('.employee-widget-card')) {
        import('./employee-dashboard.js').catch(error => {
            console.error('Error loading employee dashboard:', error);
        });
    }
});
