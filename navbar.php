<nav class="navbar navbar-light bg-light justify-content-between border-bottom shadow-sm fixed-top nav-padding">
    <div class="container-fluid">
        <a class="navbar-brand" href="./home.php">
            <img src="./image/logo-2.png" width="35" height="35" class="d-inline-block align-center logo-responsive">
            <span class="shop-brand">Phone Shop</span>
        </a>
        <div class="flex-grow-1 d-flex">
            <div class="form-inline flex-nowrap bg-light mx-0 mx-lg-auto rounded p-1">
                <div class="input-group">
                    <input id="search-product" name="productName" type="text" class="form-control search-nav search-nav-width" placeholder="Search" aria-label="Search" aria-describedby="search">
                    <div class="input-group-append">
                        <button class="btn btn-primary search-nav" type="button" id="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php
            if (isset($_SESSION['signedIn']) && $_SESSION['signedIn']):
        ?>
                    <div class='nav-item'>
                        <a class='nav-link wish-list-link' href='/customer/wish-list'>
                            <i class='fa fa-heart'></i>
                            <span>WISH LIST</span>
                            <span class='badge badge-pill badge-danger' id='number-wish-list'></span>
                        </a>
                    </div>
                    <div class='nav-item'>
                        <a class='nav-link admin-link' href='/customer/cart'>
                            <i class='fas fa-shopping-cart'></i>
                            <span>CART</span>
                            <span class='badge badge-pill badge-success' id='number-cart'></span>
                        </a>
                    </div>
        <?php
            endif;
        ?>

        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle account-link" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle"></i>
                <span>ACCOUNT</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="font-size: 0.85rem" aria-labelledby="navbarDropdown">
            <?php
                if (!isset($_SESSION['signedIn']) || !$_SESSION['signedIn']):
            ?>
                <a class="dropdown-item" href="./signin.php">
                    <i class="fas fa-sign-in-alt" style="width: 15px"></i>
                    <span>Sign In</span>
                </a>
            <?php
                else:
            ?>
                <div>
                    <a class="dropdown-item" href="./changepassword.php">
                        <i class="fas fa-key" style="width: 15px"></i>
                        <span> Change Password</span>
                    </a>
                    <a class="dropdown-item" href="/customer/invoices">
                        <i class="fas fa-file-invoice-dollar" style="width: 15px"></i>
                        <span> Purchase History</span>
                    </a>
                    <a class="dropdown-item" href="/user/setting">
                        <i class="fas fa-cog" style="width: 15px"></i>
                        <span> Setting</span>
                    </a>
                    <a class="dropdown-item" href="./service/doSignOut.php">
                        <i class="fas fa-sign-out-alt" style="width: 15px"></i>
                        <span> Sign Out</span>
                    </a>
                </div>
            <?php
                endif;
            ?>
            </div>
        </div>
    </div>
</nav>