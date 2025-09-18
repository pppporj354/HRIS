// Dashboard Charts Module
export class DashboardCharts {
    constructor() {
        this.charts = {};
        this.initCharts();
    }

    initCharts() {
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded');
            return;
        }

        // Initialize all dashboard charts
        this.initAttendanceTrends();
        this.initSalaryDistribution();
        this.initDepartmentStats();
        this.initMonthlyPayroll();
        this.initLeaveStatistics();
        this.initEmployeePerformance();
    }

    // Attendance Trends Chart
    initAttendanceTrends() {
        const ctx = document.getElementById('attendanceTrendsChart');
        if (!ctx) return;

        fetch('/api/dashboard/attendance-trends')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chartData = data.data;
                    
                    this.charts.attendanceTrends = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: chartData.map(item => item.month_name),
                            datasets: [
                                {
                                    label: 'Hadir',
                                    data: chartData.map(item => item.present),
                                    borderColor: 'rgb(75, 192, 192)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    tension: 0.4
                                },
                                {
                                    label: 'Tidak Hadir',
                                    data: chartData.map(item => item.absent),
                                    borderColor: 'rgb(255, 99, 132)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    tension: 0.4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Tren Kehadiran 6 Bulan Terakhir'
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                }
                            }
                        }
                    });
                }
            })
            .catch(error => console.error('Error loading attendance trends:', error));
    }

    // Salary Distribution Chart
    initSalaryDistribution() {
        const ctx = document.getElementById('salaryDistributionChart');
        if (!ctx) return;

        fetch('/api/dashboard/salary-distribution')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chartData = data.data;
                    
                    this.charts.salaryDistribution = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: chartData.map(item => item.range),
                            datasets: [{
                                data: chartData.map(item => item.count),
                                backgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF'
                                ],
                                hoverBackgroundColor: [
                                    '#FF6384CC',
                                    '#36A2EBCC',
                                    '#FFCE56CC',
                                    '#4BC0C0CC',
                                    '#9966FFCC'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Distribusi Gaji Karyawan'
                                },
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = Math.round((context.parsed * 100) / total);
                                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            })
            .catch(error => console.error('Error loading salary distribution:', error));
    }

    // Department Statistics Chart
    initDepartmentStats() {
        const ctx = document.getElementById('departmentStatsChart');
        if (!ctx) return;

        fetch('/api/dashboard/department-stats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chartData = data.data;
                    
                    this.charts.departmentStats = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: chartData.map(item => item.department),
                            datasets: [{
                                label: 'Jumlah Karyawan',
                                data: chartData.map(item => item.employee_count),
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Karyawan per Departemen'
                                },
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                }
                            }
                        }
                    });
                }
            })
            .catch(error => console.error('Error loading department stats:', error));
    }

    // Monthly Payroll Chart
    initMonthlyPayroll() {
        const ctx = document.getElementById('monthlyPayrollChart');
        if (!ctx) return;

        fetch('/api/dashboard/monthly-payroll')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chartData = data.data;
                    
                    this.charts.monthlyPayroll = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: chartData.map(item => item.month_name),
                            datasets: [
                                {
                                    label: 'Total Gaji (Juta Rupiah)',
                                    data: chartData.map(item => item.total_amount / 1000000),
                                    backgroundColor: 'rgba(255, 206, 86, 0.7)',
                                    borderColor: 'rgba(255, 206, 86, 1)',
                                    borderWidth: 1,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Jumlah Karyawan',
                                    data: chartData.map(item => item.employee_count),
                                    type: 'line',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    yAxisID: 'y1',
                                    tension: 0.4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Pengeluaran Gaji Bulanan'
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Total Gaji (Juta Rupiah)'
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah Karyawan'
                                    },
                                    grid: {
                                        drawOnChartArea: false,
                                    },
                                }
                            }
                        }
                    });
                }
            })
            .catch(error => console.error('Error loading monthly payroll:', error));
    }

    // Leave Statistics Chart
    initLeaveStatistics() {
        const ctx = document.getElementById('leaveStatisticsChart');
        if (!ctx) return;

        fetch('/api/dashboard/leave-statistics')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const monthlyData = data.data.monthly_trends;
                    
                    this.charts.leaveStatistics = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: monthlyData.map(item => item.month_name),
                            datasets: [
                                {
                                    label: 'Disetujui',
                                    data: monthlyData.map(item => item.approved),
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    tension: 0.4
                                },
                                {
                                    label: 'Pending',
                                    data: monthlyData.map(item => item.pending),
                                    borderColor: 'rgba(255, 206, 86, 1)',
                                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                    tension: 0.4
                                },
                                {
                                    label: 'Ditolak',
                                    data: monthlyData.map(item => item.rejected),
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    tension: 0.4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Statistik Pengajuan Cuti Bulanan'
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                }
                            }
                        }
                    });
                }
            })
            .catch(error => console.error('Error loading leave statistics:', error));
    }

    // Employee Performance Chart
    initEmployeePerformance() {
        const ctx = document.getElementById('employeePerformanceChart');
        if (!ctx) return;

        fetch('/api/dashboard/employee-performance')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chartData = data.data;
                    
                    this.charts.employeePerformance = new Chart(ctx, {
                        type: 'scatter',
                        data: {
                            datasets: [{
                                label: 'Performa Karyawan',
                                data: chartData.map(item => ({
                                    x: item.attendance_rate,
                                    y: item.average_salary / 1000000,
                                    label: item.nama
                                })),
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Performa Karyawan (Kehadiran vs Gaji)'
                                },
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        title: function(context) {
                                            return context[0].raw.label;
                                        },
                                        label: function(context) {
                                            return [
                                                `Tingkat Kehadiran: ${context.parsed.x}%`,
                                                `Rata-rata Gaji: Rp ${(context.parsed.y * 1000000).toLocaleString()}`
                                            ];
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tingkat Kehadiran (%)'
                                    },
                                    min: 0,
                                    max: 100,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Rata-rata Gaji (Juta Rupiah)'
                                    },
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                }
                            }
                        }
                    });
                }
            })
            .catch(error => console.error('Error loading employee performance:', error));
    }

    // Destroy all charts (useful for cleanup)
    destroyCharts() {
        Object.values(this.charts).forEach(chart => {
            if (chart) {
                chart.destroy();
            }
        });
        this.charts = {};
    }

    // Refresh specific chart
    refreshChart(chartName) {
        if (this.charts[chartName]) {
            this.charts[chartName].destroy();
        }
        
        // Re-initialize the specific chart
        const initMethod = `init${chartName.charAt(0).toUpperCase() + chartName.slice(1)}`;
        if (typeof this[initMethod] === 'function') {
            this[initMethod]();
        }
    }

    // Refresh all charts
    refreshAllCharts() {
        this.destroyCharts();
        this.initCharts();
    }
}

// Initialize dashboard charts when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.dashboard-charts')) {
        window.dashboardCharts = new DashboardCharts();
    }
});