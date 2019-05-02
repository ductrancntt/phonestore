<div class="card shadow mb-4">
    <div class="card-header py-3 row">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-user"></i>
            <span>ACCOUNTS</span>
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="input-group mb-3 col-md-6">
                <input type="text" class="form-control font-responsive" placeholder="Account Name"
                       id="account-search-input">
                <div class="input-group-append">
                    <button class="btn btn-primary font-responsive" type="button" style="width: 100px;"
                            id="search-account-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <button class="btn btn-outline-primary font-responsive" type="button" style="float: right;"
                        id="account-refresh-button">
                    <i class="fas fa-sync-alt"></i>
                    <span>REFRESH</span>
                </button>
                <button id="add-account" class="btn btn-success font-responsive" type="button"
                        style="float: right; margin-right: 15px;"
                        data-toggle="modal"
                        data-target="#account-modal">
                    <i class="fas fa-plus"></i>
                    <span>ADD ACCOUNT</span>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="account-table" width="100%" cellspacing="0">
                <thead class="table-header">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Type</th>
                    <th scope="col">Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="account-modal" tabindex="-1" role="dialog"
     aria-labelledby="accountModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font" id="account-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="account-field">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-title">Id</span>
                        </div>
                        <input type="text" class="form-control font-responsive" name="id" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-title">Username&nbsp;<span style="color: red">*</span></span>
                        </div>
                        <input type="text" class="form-control font-responsive" name="username">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-title">Password&nbsp;<span style="color: red">*</span></span>
                        </div>
                        <input type="password" class="form-control font-responsive" name="password">
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Name&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <input type="text" class="form-control font-responsive" name="account-name">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Phone</span>
                    </div>
                    <input type="text" class="form-control font-responsive" name="phone"
                           pattern="[0-9]{8,12}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Email</span>
                    </div>
                    <input type="text" class="form-control font-responsive" name="email">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Address</span>
                    </div>
                    <input type="text" class="form-control font-responsive" name="address">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Type</span>
                    </div>
                    <select class="form-control font-responsive" id="type-selector-account-tab"
                            name="is_admin">
                        <option value='1'>Admin</option>
                        <option value='0'>User</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Status</span>
                    </div>
                    <select class="form-control font-responsive" id="status-selector-account-tab"
                            name="status">
                        <option value='1'>Activated</option>
                        <option value='0'>Deactivated</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-success font-responsive" id="save-account">
                    <i class="fas fa-save"></i>
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="account-disable-modal" tabindex="-1" role="dialog"
     aria-labelledby="accountDisableModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font">Disable Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body font-responsive">
                <span>Do you want to disable this account?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-danger font-responsive" id="disable-account">
                    <i class="fas fa-times"></i>
                    <span>Disable</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="account-enable-modal" tabindex="-1" role="dialog"
     aria-labelledby="accountEnableModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font">Enable Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body font-responsive">
                <span>Do you want to enable this account?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-success font-responsive" id="enable-account">
                    <i class="fas fa-check"></i>
                    <span>Enable</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.getScript("/js/admin/manage-data/manage-accounts.js");
</script>