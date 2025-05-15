<!-- Modal -->
<div class="modal fade" id="modalPDF" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Print PDF with</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <x-form url="/retur/pdf">
                    <div class="row g-0 mb-3">
                        <div class="col">
                            <x-form-label value="Tanggal Awal" for="tanggal_awal_pdf" />
                            <div class="input-group">
                                <x-form-input type="date" name="tanggal_awal_pdf"
                                    value="{{ old('tanggal_awal_pdf') }}" />
                                <span class="input-group-text rounded-0"><i class="fas fa-sort"></i></span>
                            </div>
                        </div>
                        <div class="col">
                            <x-form-label value="Tanggal Akhir" for="tanggal_akhir_pdf" />
                            <div class="input-group">
                                <x-form-input type="date" name="tanggal_akhir_pdf"
                                    value="{{ old('tanggal_akhir_pdf') }}" />
                                <x-base-button disabled type="submit" icon="fas fa-print" id="print_pdf" />
                            </div>
                        </div>
                    </div>
                </x-form>
                <x-link icon="fas fa-print" url="/retur/pdf" label="Print All" class="btn btn-sm btn-primary" />
            </div>
        </div>
    </div>
</div>
