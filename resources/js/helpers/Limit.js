import HighlightText from './HighlightText'
export default function Limit(options) {
    const {
        inputSelector,
        getKeyword,
        getSortOrder,
        tableId,
        url,
        highlightText
    } = options;
    $(document)
        .off("change", inputSelector)
        .on("change", inputSelector, function (e) {
            e.preventDefault();
            // ambil keyword
            let keyword = typeof getKeyword === 'function' ? getKeyword() : "";
            // ambil token CSRF-TOKEN
            let token = $('meta[name="csrf-token"]').attr("content");
            // ambil nilai page dari pagination
            let urlPageParameter = new URLSearchParams(
                window.location.search
            ).get("page");
            // buat limit
            let setLimit = parseInt($(this).val());
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
                        keyword,
                        highlightText
                    );
                },
            });
        });
}
