<style>
    .table th, .table td{
        vertical-align: middle;
    }
</style>
<div class="card shadow mb-4">
    <div class="card-header py-3 row">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-image"></i>
            <span> BANNERS</span>
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="input-group mb-3 col-md-6">
                <div class="col-md-3">
                    <input type="text" class="form-control font-responsive" title="Banner time"
                           id="current-time" disabled>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control font-responsive" placeholder="Banner time (ms)"
                           id="banner-time">
                </div>
                <div>
                    <button class="btn btn-primary font-responsive" type="button" style="width: 100px;"
                            id="change-time-button">
                        <i class="fas fa-check"></i>
                        <span>CHANGE</span>
                    </button>
                </div>
            </div>
            <div class="col-md-6">

                <button id="add-banner" class="btn btn-success font-responsive" type="button"
                        style="float: right; margin-right: 15px;"
                        data-toggle="modal"
                        data-target="#banner-modal">
                    <i class="fas fa-plus"></i>
                    <span>ADD BANNER</span>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="banner-table" width="100%" cellspacing="0">
                <thead class="table-header">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Enable</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="banner-modal" tabindex="-1" role="dialog"
     aria-labelledby="employeeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font" id="banner-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Id</span>
                    </div>
                    <input type="text" class="form-control font-responsive" name="banner-id" disabled>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Image</span>
                    </div>
                    <div class="custom-file font-responsive">
                        <input type="file" class="custom-file-input" id="image-input" name="image">
                        <label class="custom-file-label" for="image-input">Choose image...</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Status</span>
                    </div>
                    <select class="form-control font-responsive" id="banner-status"
                            name="status">
                        <option value='1'>Enable</option>
                        <option value='0'>Disabled</option>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-success font-responsive"
                        id="save-banner">
                    <i class="fas fa-save"></i>
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="banner-delete-modal" tabindex="-1" role="dialog"
     aria-labelledby="bannerDeleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font">Delete banner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body font-responsive">
                <span>Do you want to delete this banner?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-danger font-responsive"
                        id="delete-banner">
                    <i class="fas fa-times"></i>
                    <span>Delete</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.getScript("/js/admin/manage-data/manage-banner.js");
</script>