$(document).on('DOMContentLoaded', function () {
    const fisrtTheme = localStorage.getItem('theme') || 'system';

    $(this).find(`input[name="theme-radios"][value="${fisrtTheme}"]`).prop('checked', true);
})

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
                .data('tip', '');
            return;
        }

        feedback
            .removeClass("hidden")
            .addClass("bg-primary")
            .attr("title", "Checking...")
            .text("⏳")
            .data('tip', 'Loading...');

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
                            .attr("title", "Correct")
                            .text("✔")
                            .data('tip', 'password correct');
                    } else {
                        feedback
                            .removeClass("bg-primary")
                            .addClass("bg-error")
                            .attr("title", "Incorrect")
                            .text("❌")
                            .data('tip', 'password incorrect    ');
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

$('input[name="theme-radios"]').on('change', function () {
    const val = $(this).val();

    setTheme(val);
})