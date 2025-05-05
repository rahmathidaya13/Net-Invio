<div id="informasi" class="flex-row flex-lg-column align-items-center order-1 order-lg-1 mb-lg-0 mb-2">
    Menampilkan <b>{{ $barang_masuk->firstItem() ?? 0 }}</b> sampai <b>{{ $barang_masuk->lastItem() ?? 0 }}</b>
    dari
    <b>{{ $barang_masuk->total() ?? 0 }}</b> item
</div>
