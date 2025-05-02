export default function HighlightText(value, target) {
    $(`tbody ${target}`).each(function () {
        let regex = new RegExp(value, "gi");
        let text = $(this).text();
        if (value) {
            $(this).html(
                text.replace(
                    regex,
                    "<span class='highlight'>" + value + "</span>"
                )
            );
        } else {
            $(this).html(text);
        }
    });
}
