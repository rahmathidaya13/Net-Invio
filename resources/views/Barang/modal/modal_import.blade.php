<!-- Modal -->
<div class="modal fade" id="modalImports" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Import File</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <x-form url="/barang/import">
                    <div class="row g-0 mb-3">
                        <div class="col">
                            <x-form-label value="Import" for="file_import" />
                            <div class="input-group">
                                <input type="file" class="form-control" name="file_import" id="file_import"
                                    value="{{ old('file_import') }}">
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
