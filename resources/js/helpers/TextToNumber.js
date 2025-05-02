export default function TextToNumber(value) {
    // Hilangkan semua karakter selain angka, koma, dan titik
    let cleanedValue = value.replace(/[^0-9.,]/g, "");

    // Ganti koma dengan titik (untuk desimal) dan titik dengan kosong (untuk ribuan)
    cleanedValue = cleanedValue.replace(/\./g, ""); //remove titik ribuan
    cleanedValue = cleanedValue.replace(/,/g, "."); //replace koma desimal

    // Konversi ke number
    return parseFloat(cleanedValue) || 0; // Menggunakan || 0 untuk menangani input kosong
}
