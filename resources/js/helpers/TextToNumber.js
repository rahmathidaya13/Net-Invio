export default function TextToNumber(value) {
    // timpa teks biasa menjadi angka
    let number = value.replace(/[^0-9]/g, "");
    if (number.length > 25) {
        number = value.slice(0, 25);
    }
    return number;
}
