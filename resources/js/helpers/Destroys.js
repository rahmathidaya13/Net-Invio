export default function destroy(options) {
    const { selector, id, column, url } = options;
    $(document)
        .off("click", selector)
        .on("click", selector, function (e) {
            e.preventDefault();
            const getData = $(this).data("data");
            SweatAlert(`${url}/${getData[id]}`, getData[column], "delete");
        });
}
