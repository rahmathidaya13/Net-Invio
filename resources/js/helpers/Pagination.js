import HighlightText from "./HighlightText";
export default function paginations(options) {
    const {
        selector,
        getKeyword,       // function: () => $("#keyword").val()
        getLimit,         // function: () => $("#limit").val()
        getSortOrder,
        tableId,
        highlightText
    } = options;
    $(document)
        .off("click", selector)
        .on("click", selector, function (e) {
            e.preventDefault();
            let urls = $(this).attr("href");
            const keyword = typeof getKeyword === "function" ? getKeyword() : "";
            const limit = typeof getLimit === "function" ? getLimit() : 10;
            const sortOrder = typeof getSortOrder === "function" ? getSortOrder() : "desc";

            if (!urls) return; // Jika tidak ada URL, hentikan
            urls = new URL(urls, window.location.origin);
            urls.searchParams.set("limit", limit);
            urls.searchParams.set("keyword", keyword);
            urls.searchParams.set("sort_order", sortOrder);
            $.ajax({
                type: "GET",
                url: urls.toString(),
                dataType: "json", // Pastikan menerima JSON
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
