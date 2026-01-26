import ApexCharts from "apexcharts";

$(document).on("DOMContentLoaded", function () {
    const fisrtTheme = localStorage.getItem("theme") || "system";

    $(this)
        .find(`input[name="theme-radios"][value="${fisrtTheme}"]`)
        .prop("checked", true);
});

let checkTimeout = null;

$("#currentPassword").on("input", function () {
    const input = $(this).val();
    const feedback = $("#feedback");
    const csrf = $(this).data("csrf");

    feedback.removeClass("bg-success bg-error").addClass("hidden").text("");

    clearTimeout(checkTimeout);

    checkTimeout = setTimeout(() => {
        if (input == "") {
            feedback
                .removeClass("bg-success bg-error")
                .addClass("hidden")
                .text("")
                .attr("data-tip", "");
            return;
        }

        feedback
            .removeClass("hidden")
            .addClass("bg-primary")
            .text("⏳")
            .attr("data-tip", "Loading...");

        $.ajax({
            url: "/ajax/check-password",
            type: "POST",
            data: {
                _token: csrf,
                password: input,
            },
            success: function (response) {
                feedback.removeClass("hidden").addClass("flex");
                if (response.status == "success") {
                    if (response.valid) {
                        feedback
                            .removeClass("bg-primary")
                            .addClass("bg-success")
                            .text("✔")
                            .attr("data-tip", "password correct");
                    } else {
                        feedback
                            .removeClass("bg-primary")
                            .addClass("bg-error")
                            .text("❌")
                            .attr("data-tip", "password incorrect");
                    }
                } else if (response.status == "error") {
                    showAlert(response.message);
                }
            },
            error: function (xhr) {
                console.error(xhr.message);
            },
        });
    }, 500);
});

$('input[name="theme-radios"]').on("change", function () {
    const val = $(this).val();

    setTheme(val);
});

const chartElement = $("#trust_score_chart");

if (chartElement.length > 0) {
    const score = chartElement.data("score");

    const getThemeColors = () => {
        const isDark =
            $("html").attr("data-theme") === "dark" ||
            $("html").hasClass("dark");
        return {
            text: isDark
                ? "oklch(97% 0.001 106.424)"
                : "oklch(21% 0.034 264.665)",
        };
    };

    const themeColors = getThemeColors();

    const chart = new ApexCharts(chartElement[0], {
        series: [score],
        chart: {
            height: 350,
            type: "radialBar",
            animations: {
                enabled: true,
                easing: "easeinout",
                speed: 800,
            },
        },
        plotOptions: {
            radialBar: {
                // startAngle: -135, // Membuat chart tidak tertutup penuh (lebih elegan)
                // endAngle: 135,
                hollow: {
                    margin: 15,
                    size: "50%",
                    background: "transparent",
                },
                track: {
                    background: "#e5e7eb",
                    strokeWidth: "95%",
                    margin: 5,
                },
                dataLabels: {
                    name: {
                        show: true,
                        fontSize: "14px",
                        fontWeight: 600,
                        offsetY: -10,
                        color: themeColors.text,
                    },
                    value: {
                        show: true,
                        fontSize: "20px",
                        fontWeight: 800,
                        offsetY: 5,
                        color: themeColors.text,
                        formatter: function (val) {
                            return val + "/100";
                        },
                    },
                },
            },
        },
        fill: {
            colors: ["oklch(37% 0.146 265.522)"],
        },
        labels: ["Trust Score"],
    });

    chart.render();

    $('input[name="theme-radios"]').on('change', function () {
        setTimeout(() => {
            const newColors = getThemeColors();
            chart.updateOptions({
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {color: newColors.text},
                            value: {color: newColors.text}
                        }
                    }
                }
            })
        }, 100)
    })
}
