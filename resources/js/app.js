// import bootstrap javascript from file bootstrap.js
import "./bootstrap";

//import popper
import * as Popper from "@popperjs/core";
window.Popper = Popper;

// import datatables component
import "datatables.net-bs5";
import "datatables.net-buttons-bs5";

// make sure folder assets inside resource can be accessed through vite
import.meta.glob(["../assets/**"]);

// Dashboard interactions
document.addEventListener("DOMContentLoaded", function () {
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
});
