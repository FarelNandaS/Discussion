import ApexCharts from "apexcharts";

const chartElement = $("#post_traffic_chart");

if (chartElement.length > 0) {
    const labels = chartElement.data('labels')
    const values = chartElement.data('values');

    const isDarkMode = () => {
        return $('html').attr('data-theme') === 'dark' || $('html').hasClass('dark');
    }

    const chart = new ApexCharts(chartElement[0], {
        chart: {
            type: "area",
            height: 300,
            toolbar: { show: false },
            theme: {
                mode: isDarkMode() ? 'dark' : 'light'
            },
            background: 'transparent', 
            animations: {
                enabled: true,
                easing: "easeinout",
                speed: 800,
            },
        },
        series: [
            {
                name: "User Posts",
                data: values,
            },
        ],
        xaxis: {
            categories: labels,
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: { colors: "#9ca3af", fontSize: "12px" },
            },
        },
        yaxis: {
            labels: {
                style: { colors: "#9ca3af", fontSize: "12px" },
            },
        },
        stroke: {
            curve: "smooth",
            width: 3,
        },
        colors: ["oklch(37% 0.146 265.522)"],
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [20, 100],
            },
        },
        dataLabels: { enabled: false },
        grid: {
            borderColor: "#e5e7eb",
            strokeDashArray: 4,
        },
        markers: {
            size: 4,
            colors: ["oklch(37% 0.146 265.522)"],
            strokeColors: "#fff",
            strokeWidth: 2,
            hover: { size: 7 },
        },
        tooltip: {
            theme: isDarkMode() ? 'dark' : 'light',
            y: {
                formatter: function (val) {
                    return val + " Posts";
                },
            },
        },
    });

    chart.render();
}
