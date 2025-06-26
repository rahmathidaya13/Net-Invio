<!-- Modal -->
<div class="modal fade" id="modalImports" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Import File</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <x-form url="/pelanggan/import">
                    <div class="row g-0 mb-3">
                        <div class="col">
                            <div id="drop-zone" class="border border-primary p-5 text-center">
                                <x-form-label for="file_import" class="d-flex justify-content-center mb-3"
                                    style="cursor: pointer">
                                    <img src="{{ asset('assets/icon/no-image.svg') }}"
                                        class="img-fluid border shadow-sm" id="preview" alt="">
                                </x-form-label>
                                <div class="input-group">
                                    <input accept=".xls,.xlsx,.csv" type="file" class="form-control d-none"
                                        name="file_import" id="file_import" value="{{ old('file_import') }}">
                                </div>
                                <small class="text-muted" id="name-file">Import file Excel di sini atau klik untuk
                                    memilih</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid">
                        <x-base-button label="Upload" />
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</div>
