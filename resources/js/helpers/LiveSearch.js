import HighlightText from './HighlightText'
export default function liveSearch(options) {

    const {
        inputSelector,
        getLimit,
        getSortOrder,
        tableId,
        url,
        highlightText
    } = options;

    $(document)
        .off("input", inputSelector)
        .on("input", inputSelector, function (e) {
            e.preventDefault();
            // ambil keyword
            let keyword = $(this).val();
            if (keyword.length > 0) {
                $("#text-result").removeClass("d-none").addClass("d-block");
                $("#results").text(` "${keyword}" `);
            } else {
                $("#text-result").removeClass("d-block").addClass("d-none");
                $("#results").text("");
            }
            // ambil token CSRF-TOKEN
            let token = $('meta[name="csrf-token"]').attr("content");

            // ambil nilai page dari pagination
            let urlPageParameter = new URLSearchParams(
                window.location.search
            ).get("page");

            // buat limit
            let setLimit = typeof getLimit === 'function' ? getLimit() : 10;
            let setOrder = typeof getSortOrder === 'function' ? getSortOrder() : "desc";
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    keyword: keyword,
                    _token: token,
                    limit: setLimit,
                    sort_order: setOrder,
                    page: urlPageParameter,
                },
                dataType: "json",
                success: function (data) {
                    $(tableId).html(data.table);
                    $(".pagination-wrapper").html(data.pagination);
                    $("#informasi").html(
                        `Menampilkan <b>${data.info.firstItem ?? 0
                        }</b> sampai <b>${data.info.lastItem ?? 0
                        }</b> dari <b>${data.info.total ?? 0}</b> item`
                    );
                    HighlightText(
                        keyword, highlightText,
                    );
                },
            });
        });

}
