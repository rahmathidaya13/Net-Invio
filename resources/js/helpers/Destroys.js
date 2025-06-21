export default function destroy(options) {
    const {
        selector,
        data,
        id,
        column,
        url
    } = options;
    $(document)
        .off("click", selector)
        .on("click", selector, function (e) {
            e.preventDefault();
            const getData = typeof data === 'function' ? data() : null;
            SweatAlert(
                `${url}/${getData[id]}`,
                getData[column],
                "delete"
            );
        });
}
