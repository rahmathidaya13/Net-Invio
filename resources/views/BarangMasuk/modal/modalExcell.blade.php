<!-- Modal -->
<div class="modal fade" id="modalExcell" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Print Excell with</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <x-form url="/receiving/export">
                    <div class="row g-0 mb-3">
                        <div class="col">
                            <x-form-label value="Tanggal Awal" for="tanggal_awal" />
                            <div class="input-group">
                                <x-form-input type="date" name="tanggal_awal" value="{{ old('tanggal_awal') }}" />
                                <span class="input-group-text rounded-0"><i class="fas fa-sort"></i></span>
                            </div>
                        </div>
                        <div class="col">
                            <x-form-label value="Tanggal Akhir" for="tanggal_akhir" />
                            <div class="input-group">
                                <x-form-input type="date" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}" />
                                <x-base-button disabled type="submit" icon="fas fa-print" id="print_excell" />
                            </div>
                        </div>
                    </div>
                </x-form>
                <x-link icon="fas fa-print" url="/receiving/export" label="Print All" class="btn btn-sm btn-primary" />
            </div>
        </div>
    </div>
</div>
