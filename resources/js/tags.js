var page = 1;
var loading = false;
var hasMore = true;

const container = $("#tagContainer");
const statusEl = $("#load_more_status");
const loadingEl = $("#loading_spinner");

$(window).scroll(function () {
    if (
        $(window).scrollTop() + $(window).height() >=
        $(window).height() + 100
    ) {
        if (!loading && hasMore) {
            loadMoreComment()
        }
    }
});

function loadMoreComment() {
    loading = true;
    page++;

    loadingEl.removeClass("hidden");

    $.ajax({
        url: "?page=" + page,
        type: "get",
        success: function (response) {
            if (response.trim().length == 0) {
                hasMore = false;
                statusEl.html(
                    '<span class="text-xs opacity-30">All tags loaded.</span>',
                );
                return;
            }

            loadingEl.addClass("hidden");
            container.append(response);

            loading = false;
        },
        error: function (xhr) {
            console.log("Server error...");
            loading = false;
        },
    });
}
