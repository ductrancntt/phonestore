<div class="card shadow mb-4">
    <div class="card-header py-3 row">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-mobile-alt"></i>
            <span> PRODUCTS</span>
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="input-group mb-3 col-md-6">
                <input type="text" class="form-control font-responsive" placeholder="Product Name"
                       id="product-search-input">
                <div class="input-group-append">
                    <button class="btn btn-primary font-responsive" type="button" style="width: 100px;"
                            id="search-product-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">

                <button class="btn btn-outline-primary font-responsive" type="button" style="float: right;" id="product-refresh-button">
                    <i class="fas fa-sync-alt"></i>
                    <span>REFRESH</span>
                </button>
                <button id="add-product" class="btn btn-success font-responsive" type="button"
                        style="float: right; margin-right: 15px;"
                        data-toggle="modal"
                        data-target="#product-modal">
                    <i class="fas fa-plus"></i>
                    <span>ADD PRODUCT</span>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="product-table" width="100%" cellspacing="0">
                <thead class="table-header">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Screen Size</th>
                    <th scope="col">Memory</th>
                    <th scope="col">Chipset</th>
                    <th scope="col">Image</th>
                    <th scope="col">Manufacturer</th>
                    <th scope="col">Quantity</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="product-modal" tabindex="-1" role="dialog"
     aria-labelledby="productModalTitle" aria-hidden="true">
    <div style="min-width: 405px" class="modal-dialog modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font" id="product-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">ID</span>
                    </div>
                    <input type="text" class="form-control font-responsive" name="id" disabled>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Product Name&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <input type="text" class="form-control font-responsive" name="product-name">
                </div>
                <div class="input-group mb-3">
                    <div class="text-center"><h6>Description&nbsp;<span style="color: red">*</span></h6></div>
                    <textarea title="Description" class="form-control font-responsive" name="product-description" id="product-description"  rows="3"
                              style="resize: none;"></textarea>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Manufacturer&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <select class="form-control font-responsive" id="manufacturer-selector">
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Price&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <input type="number" min="100000" class="form-control font-responsive" name="price">
                    <div class='input-group-append'><span
                            class='input-group-text font-responsive'>₫</span></div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Quantity&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <input type="number" min="1" class="form-control font-responsive" name="quantity">
                    <div class='input-group-append'><span
                            class='input-group-text font-responsive'>pcs</span></div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Screen Size&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <input type="number" step="0.01" min="0" class="form-control font-responsive"
                           name="screen-size">
                    <div class='input-group-append'><span
                            class='input-group-text font-responsive'>inch</span></div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Memory&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <input type="text" class="form-control font-responsive" name="memory">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Chipset&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <input type="text" class="form-control font-responsive" name="chipset">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-success font-responsive" id="save-product">
                    <i class="fas fa-save"></i>
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="product-delete-modal" tabindex="-1" role="dialog"
     aria-labelledby="productDeleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-font">Delete Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body font-responsive">
                <span>Do you want to delete this product?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary font-responsive"
                        data-dismiss="modal">
                    <i class="fas fa-ban"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-danger font-responsive" id="delete-product">
                    <i class="fas fa-times"></i>
                    <span>Delete</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.getScript("/js/admin/manage-data/manage-products.js");
</script>