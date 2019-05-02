<div class="card shadow mb-4">
    <div class="card-header py-3 row">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-user"></i>
            <span>INVOICES</span>
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="input-group mb-3 col-md-6">
                <input type="text" class="form-control font-responsive" placeholder="Invoice Id"
                       id="invoice-search-input">
                <div class="input-group-append">
                    <button class="btn btn-primary font-responsive" type="button" style="width: 100px;"
                            id="search-invoice-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
<!--            <div class="col-md-6">-->
<!--                    <div class="input-group">-->
<!--                        <input type="text" id="date-range-picker" class="form-control font-responsive" placeholder="Date Range" style="text-align: center;">-->
<!--                        <div class="input-group-append">-->
<!--                            <button class="btn btn-primary font-responsive" type="button" style="width: 100px;" id="analyze-button">-->
<!--                                <i class="fas fa-chart-line"></i>-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--            </div>-->
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="invoice-table" width="100%" cellspacing="0">
                <thead class="table-header">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">User</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Ship Address</th>
                    <th scope="col">Status</th>
                    <th scope="col">Total Money</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="invoice-update-modal" tabindex="-1" role="dialog"
     aria-labelledby="invoiceUpdateModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font">Update Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body font-responsive">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Status</span>
                    </div>
                    <select class="form-control font-responsive"
                            id="invoice-status">
                        <option value='1'>Delivering</option>
                        <option value='2'>Delivered</option>
                        <option value='3'>Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-success font-responsive" id="update-invoice-btn">
                    <i class="fas fa-check"></i>
                    <span>Confirm</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="invoice-cancel-modal" tabindex="-1" role="dialog"
     aria-labelledby="invoiceDisableModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font">Cancel Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body font-responsive">
                <span>Do you want to cancel this invoice?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-danger font-responsive" id="disable-invoice">
                    <i class="fas fa-times"></i>
                    <span>Confirm</span>
                </button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $.getScript("/js/admin/manage-data/manage-invoices.js");
</script>