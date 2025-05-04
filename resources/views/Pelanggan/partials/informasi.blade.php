<div id="informasi" class="flex-row flex-lg-column align-items-center order-1 order-lg-1 mb-lg-0 mb-2">
    Menampilkan <b>{{ $pelanggan->firstItem() ?? 0 }}</b> sampai <b>{{ $pelanggan->lastItem() ?? 0 }}</b>
    dari
    <b>{{ $pelanggan->total() ?? 0 }}</b> item
</div>
