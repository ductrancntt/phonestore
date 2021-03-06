<style>
    .table th, .table td{
        vertical-align: middle;
    }
</style>
<div class="card shadow mb-4">
    <div class="card-header py-3 row">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-industry"></i>
            <span> MANUFACTURERS</span>
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="input-group mb-3 col-md-6">
                <input type="text" class="form-control font-responsive" placeholder="Manufacturer Name"
                       id="manufacturer-search-input">
                <div class="input-group-append">
                    <button class="btn btn-primary font-responsive" type="button" style="width: 100px;"
                            id="search-manufacturer-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <button class="btn btn-outline-primary font-responsive" type="button" style="float: right;"
                        id="manufacturer-refresh-button">
                    <i class="fas fa-sync-alt"></i>
                    <span>REFRESH</span>
                </button>
                <button id="add-manufacturer" class="btn btn-success font-responsive" type="button"
                        style="float: right; margin-right: 15px;"
                        data-toggle="modal"
                        data-target="#manufacturer-modal">
                    <i class="fas fa-plus"></i>
                    <span>ADD MANUFACTURER</span>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="manufacturer-table" width="100%" cellspacing="0">
                <thead class="table-header">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Manufacturer</th>
                        <th scope="col">Logo</th>
                        <th scope="col">Address</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="manufacturer-modal" tabindex="-1" role="dialog"
     aria-labelledby="employeeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font" id="manufacturer-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Id</span>
                    </div>
                    <input type="text" class="form-control font-responsive"
                           name="manufacturer-id" disabled>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Manufacturer&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <input type="text" class="form-control font-responsive"
                           name="manufacturer-name">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Address&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <textarea class="form-control font-responsive" name="manufacturer-address"
                              rows="3"
                              style="resize: none"></textarea>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Logo</span>
                    </div>
                    <div class="custom-file font-responsive">
                        <input type="file" class="custom-file-input" id="image-input" name="image">
                        <label class="custom-file-label" for="image-input">Choose image...</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-success font-responsive"
                        id="save-manufacturer">
                    <i class="fas fa-save"></i>
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="manufacturer-delete-modal" tabindex="-1" role="dialog"
     aria-labelledby="manufacturerDeleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font">Delete Manufacturer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body font-responsive">
                <span>Do you want to delete this manufacturer?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-danger font-responsive"
                        id="delete-manufacturer">
                    <i class="fas fa-times"></i>
                    <span>Delete</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.getScript("/js/admin/manage-data/manage-manufacturers.js");
</script>