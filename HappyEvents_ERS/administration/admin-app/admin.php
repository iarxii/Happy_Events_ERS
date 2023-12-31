<?php
session_start();

if(isset($_SESSION['admin_auth'])){
  if($_SESSION['admin_auth'] == false){
    header("Location: ../admin-index.php?return=noauth");
  }
}else{
  header("Location: ../admin-index.php?return=loginreq");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Administration (Confidential) | Happy Events Equipment Rentals</title>
    <!-- Required Meta Tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <link rel="stylesheet" href="../../styles/style.css" />

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Unica+One&display=swap" rel="stylesheet" />
  </head>
  <body>
    <!-- Edit Record Modal Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Edit-Record-Modal" id="toggle-edit-record-modal" hidden></button>

    <!-- Edit Record Modal -->
    <div class="modal fade" id="Edit-Record-Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-record-modal-label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollablez modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="edit-record-modal-label">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="initializeTables()"></button>
          </div>
          <div class="modal-body">
            <iframe src="" id="edit-form-viewer" frameborder="0" class="w-100" style="min-height: 60vh; border-radius: 25pxca"></iframe>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger rounded-pill" data-bs-dismiss="modal" onclick="initializeTables()">Close <i class="fas fa-ban"></i></button>
          </div>
        </div>
      </div>
    </div>
    <!-- ./ Edit Record Modal -->

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-whitez fs-5z sticky-topz" style="background: #e6f5e5 !important; color: #1c9941 !important; border-radius: 0 0 25px 25px !important">
      <div class="container">
        <div class="navbar-brand fw-bold d-block fs-3z" style="color: #1c9941 !important; overflow-x: hidden">
          <!--href="#"-->
          <!---->
          <img src="../../media/assets/Happy Events New Logo with BG.png" alt="logo" class="img-fluid shadow bg-success" style="height: 150px !important; border-radius: 25px; border: solid #1c9941 0px" />

          Happy Events Rentals&trade;<span class="sniglet-font">.ERS</span>&copy;
          <span class="text-warning fs-1 fw-bold"><i class="fas fa-spinner"></i></span>
        </div>

        <button class="navbar-toggler shadow rounded-pill p-4 my-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #1c9941 !important">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end fw-bold" id="navbarNav" style="font-size: 10px">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active text-center" aria-current="page" href="#" style="font-size: 10px">Admin Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-center" href="../../index.php" style="font-size: 10px">Home (Index)</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="#user-mgm-lbl" style="font-size: 10px">User Registration</a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-center" href="../../app/EquipmentCatalogue.php">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="../../about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="../../contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center border-danger px-3" onclick="adminSignOut()" style="cursor: pointer; font-size: 10px"><i class="fas fa-sign-out-alt text-danger"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- ./ Navigation Bar -->

    <!-- Main Content  style="margin-top: 250px"-->
    <div class="container-fluid pt-4">
      <h1 class="text-center" style="font-size: 70px">System Admin <i class="fas fa-user-shield"></i></h1>

      <hr class="text-success fs-1" />
      <hr class="text-success fs-1" />
      <hr class="text-success fs-1" />

      <h1 class="mt-4">Product Management <i class="fas fa-barcode"></i></h1>
      <button class="btn btn-success btn-lg p-3 mb-2 rounded-pill sniglet-font" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Add New Product +</button>

      <!-- Add New Product Offcanvas -->
      <div class="offcanvas offcanvas-start" tabindex="-1" data-bs-scroll="true" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel" style="background-color: #1c9941 !important; color: #fff !important; width: 600px !important">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title fs-1 sniglet-font-thick" id="offcanvasBottomLabel">Add New Product +</h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div class="shadow p-2 bg-white fs-5" style="border-radius: 25px">
            <!-- New Product Form -->
            <div id="admin-new-product-entry-form-container" style="background-color: #1c9941; color: #fff; border-radius: 25px" class="shadow p-4 my-4">
              <h1 class="mt-4 text-center">New Product Entry Form</h1>

              <form action="new-product.php" method="post" target_blank id="admin-new-product-entry-form" class="basic-form-style p-4 shadow fs-3">
                <div id="emailHelp" class="form-text text-center p-4 mb-4 shadow sniglet-font -thick text-danger bg-light" style="border-radius: 25px">Please take note that this form is only for the capturing of <strong>New Product Entry Data</strong>.</div>

                <div class="mb-3">
                  <label for="newProdInputPrevImg" class="form-label">Preview Image</label>
                  <input type="text" class="form-control rounded-pill" id="newProdInputPrevImg" name="newProdInputPrevImg" required value="default.png" readonlyZ />
                </div>
                <div class="mb-3">
                  <label for="newProdInputProdName" class="form-label">Product Name</label>
                  <input type="text" class="form-control rounded-pill" id="newProdInputProdName" name="newProdInputProdName" required />
                </div>
                <div class="mb-3">
                  <label for="newProdInputProdDescr" class="form-label">Product Description</label>
                  <textarea type="text" class="form-control rounded" id="newProdInputProdDescr" name="newProdInputProdDescr" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="newProdInputProdType" class="form-label">Product Type</label>
                  <input type="text" class="form-control rounded-pill" id="newProdInputProdType" name="newProdInputProdType" required />
                </div>
                <div class="mb-3">
                  <label for="newProdInputCategory" class="form-label">Category</label>
                  <select class="form-select" aria-label="Product Category" aria-placeholder="Please select a Category" placeholder="Please select a Category" id="newProdInputCategory" name="newProdInputCategory">
                    <option selected>Please select your Category</option>
                    <option value="test">Test</option>
                    <option value="test1">Category1</option>
                    <option value="test2">Category2</option>
                  </select>
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="newProdInputProdAvailability" name="newProdInputProdAvailability" />
                  <label class="form-check-label text-start" for="newProdInputProdAvailability" aria-checked="true" checked="checked" aria-required="true" required>Is the Product currently Available?</label>
                </div>
                <div class="mb-3">
                  <label for="newProdInputSellPrice" class="form-label">Selling Price</label>
                  <input type="number" class="form-control rounded-pill" id="newProdInputSellPrice" name="newProdInputSellPrice" required />
                </div>
                <div class="mb-3">
                  <label for="newProdInputRentPrice" class="form-label">Rental Price</label>
                  <input type="number" class="form-control rounded-pill" id="newProdInputRentPrice" name="newProdInputRentPrice" required />
                </div>
                <div class="mb-3">
                  <label for="newProdInputItemCode" class="form-label">Item Code</label>
                  <input type="text" class="form-control rounded-pill" id="newProdInputItemCode" name="newProdInputItemCode" />
                </div>
                <div class="mb-3">
                  <label for="newProdInputSize" class="form-label">Size</label>
                  <input type="text" class="form-control rounded-pill" id="newProdInputSize" name="newProdInputSize" />
                </div>
                <div class="mb-3">
                  <label for="newProdInputColor" class="form-label">Select a colour!</label>
                  <input type="color" class="form-control form-control-color rounded-pill" id="newProdInputColor" name="newProdInputColor" value="#1c9941" title="Select a Color" />
                </div>
                <div class="mb-3">
                  <label for="newProdInputBinNum" class="form-label">Bin Number</label>
                  <input type="text" class="form-control rounded-pill" id="newProdInputBinNum" name="newProdInputBinNum" />
                </div>
                <div class="mb-3">
                  <label for="newProdInputCreatedBy" class="form-label">Created By</label>
                  <input type="text" class="form-control rounded-pill" id="newProdInputCreatedBy" name="newProdInputCreatedBy" required value="1" readonlyZ />
                </div>

                <button type="submit" class="btn btn-outline-light btn-block rounded-pill sniglet-font">
                  <span class="fs-1 m-4">Add to Database <i class="fas fa-plus"></i></span>
                </button>
              </form>
            </div>
            <!-- ./ New Product  Form -->
          </div>
        </div>
      </div>
      <!-- ./ Add New Product Offcanvas -->

      <h5 class="mt-4" id="product-list-table-heading">Products List: <i class="fas fa-arrow-down"></i> (<a href="#client-list-table-heading">Next Table</a>)</h5>

      <div class="table-responsive border-success" style="border-radius: 25px; border-top: #1c9941 solid 5px">
        <table class="table table-hover table-bordered table-light text-success mb-4z sniglet-font shadow" id="product-list-table-container">
          <thead class="table-success">
            <tr>
              <th scope="col" colspan="2" class="bg-success text-white text-center"><i class="fas fa-ellipsis-h"></i></th>

              <th scope="col">#</th>
              <th scope="col">Preview Image</th>
              <th scope="col">Name</th>
              <th scope="col">Description</th>
              <th scope="col">Type</th>
              <th scope="col">Category</th>
              <th scope="col">Availability</th>
              <th scope="col">Sell Price</th>
              <th scope="col">Rent Price</th>
              <th scope="col">Item Code</th>
              <th scope="col">Size</th>
              <th scope="col">Colour</th>
              <th scope="col">Bin Number</th>
              <th scope="col">Creation Date</th>
              <th scope="col">Created By</th>
            </tr>
          </thead>
          <tbody id="product-list-table-body" class="text-dark"></tbody>
        </table>
      </div>

      <hr class="text-success fs-1" />
      <hr class="text-success fs-1" />
      <hr class="text-success fs-1" />

      <h1 class="mt-4" id="user-mgm-lbl">User Management <i class="fas fa-user-edit"></i></h1>
      <button class="btn btn-success btn-lg p-3 rounded-pill sniglet-font" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="font-size: 10px">Show/Hide Registration Forms</button>
      <div class="row my-2 collapse" id="collapseExample">
        <div class="col-sm -3">
          <!-- Client Registration Form -->
          <div id="admin-new-user-reg-form" style="background-color: #1c9941; color: #fff; border-radius: 25px" class="shadow p-4 my-4 bg-success">
            <h1 class="mt-4 text-center">New Client Registration Form</h1>

            <form action="../../client-registration.php" method="post" target_blank id="client-registration-form" class="basic-form-style p-4 shadow fs-3">
              <div id="emailHelp" class="form-text text-center p-4 mb-4 shadow sniglet-font -thick text-danger bg-light" style="border-radius: 25px">Please take note that this form is only for the Registration of <strong>Clients/Customers</strong> to create new user accounts to grant them access to the system.</div>
              <div class="mb-3">
                <label for="clientRegInputTitlee" class="form-label">Title</label>
                <select class="form-select" aria-label="Registration Form Title Selection" id="clientRegInputTitlee" name="clientRegInputTitlee" aria-placeholder="Please select your Title" placeholder="Please select your Title" required>
                  <option selected>Please select your Title</option>
                  <option value="mr">Mr.</option>
                  <option value="mrs">Mrs.</option>
                  <option value="ms">Ms.</option>
                  <option value="dr">Dr.</option>
                  <option value="sr">Sr.</option>
                  <option value="prof">Prof.</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="clientRegInputFName" class="form-label">First Name</label>
                <input type="text" class="form-control rounded-pill" id="clientRegInputFName" name="clientRegInputFName" required />
              </div>
              <div class="mb-3">
                <label for="clientRegInputLName" class="form-label">Last Name</label>
                <input type="text" class="form-control rounded-pill" id="clientRegInputLName" name="clientRegInputLName" required />
              </div>
              <div class="mb-3">
                <label for="clientRegInputContact" class="form-label">Contact Number</label>
                <input type="tel" class="form-control rounded-pill" id="clientRegInputContact" name="clientRegInputContact" required />
              </div>
              <div class="mb-3">
                <label for="clientRegInputEmail" class="form-label">Email address</label>
                <input type="email" class="form-control rounded-pill" id="clientRegInputEmail" name="clientRegInputEmail" required />
              </div>
              <div class="mb-3">
                <label for="clientRegInputTitlee" class="form-label">Gender</label>
                <select class="form-select" aria-label="Registration Form Gender Selection" aria-placeholder="Please select your Gender" placeholder="Please select your Gender">
                  <option selected>Please select your Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="mf-trans-male">Transgender (M -> F)</option>
                  <option value="fm-trans-female">Transgender (F -> M)</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="clientRegInputDOB" class="form-label">Date of birth</label>
                <input type="date" class="form-control rounded-pill" id="clientRegInputDOB" name="clientRegInputDOB" required />
              </div>
              <div class="mb-3">
                <label for="clientRegInputIDNum" class="form-label">SA ID Number</label>
                <input type="number" class="form-control rounded-pill" id="clientRegInputIDNum" name="clientRegInputIDNum" />
              </div>
              <div class="mb-3">
                <label for="clientRegInputResAddress" class="form-label">Residential address</label>
                <textarea type="email" class="form-control rounded" id="clientRegInputResAddress" name="clientRegInputResAddress" rows="5"></textarea>
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="promoCheck" name="promoCheck" />
                <label class="form-check-label text-start" for="promoCheck" aria-checked="true" checked="checked">Subscribe for promotional content?</label>
              </div>
              <button type="submit" class="btn btn-outline-light btn-block rounded-pill sniglet-font">
                <span class="fs-1 m-4">Register <i class="fas fa-paper-plane"></i></span>
              </button>
            </form>
          </div>
          <!-- ./Client Registration Form -->
        </div>
        <div class="col-sm">
          <!-- Administrator Registration Form -->
          <div id="admin-new-user-reg-form" style="background-color: #1c9941; color: #fff; border-radius: 25px" class="shadow p-4 my-4 bg-danger">
            <h1 class="mt-4 text-center">New Administrator Registration Form</h1>

            <form action="admin-registration.php" method="post" target_blank id="client-registration-form" class="basic-form-style p-4 shadow fs-3" id="homepage-client-registration-form">
              <div id="emailHelp" class="form-text text-center p-4 mb-4 shadow sniglet-font -thick text-danger bg-light" style="border-radius: 25px">Please take note that this form is only for the Registration of <strong>System Administrators</strong> to create new user accounts to grant them access to the system.</div>
              <div class="mb-3">
                <label for="newAdminInputTitlee" class="form-label">Title</label>
                <select class="form-select" aria-label="Registration Form Title Selection" id="newAdminInputTitlee" name="newAdminInputTitlee" aria-placeholder="Please select your Title" placeholder="Please select your Title" required>
                  <option selected>Please select your Title</option>
                  <option value="mr">Mr.</option>
                  <option value="mrs">Mrs.</option>
                  <option value="ms">Ms.</option>
                  <option value="dr">Dr.</option>
                  <option value="sr">Sr.</option>
                  <option value="prof">Prof.</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="newAdminInputFName" class="form-label">First Name</label>
                <input type="text" class="form-control rounded-pill" id="newAdminInputFName" name="newAdminInputFName" required />
              </div>
              <div class="mb-3">
                <label for="newAdminInputLName" class="form-label">Last Name</label>
                <input type="text" class="form-control rounded-pill" id="newAdminInputLName" name="newAdminInputLName" required />
              </div>
              <div class="mb-3">
                <label for="newAdminInputContact" class="form-label">Contact Number</label>
                <input type="tel" class="form-control rounded-pill" id="newAdminInputContact" name="newAdminInputContact" required />
              </div>
              <div class="mb-3">
                <label for="newAdminInputEmail" class="form-label">Email address</label>
                <input type="email" class="form-control rounded-pill" id="newAdminInputEmail" name="newAdminInputEmail" required />
              </div>
              <div class="mb-3">
                <label for="newAdminInputTitlee" class="form-label">Gender</label>
                <select class="form-select" aria-label="Registration Form Gender Selection" aria-placeholder="Please select your Gender" placeholder="Please select your Gender">
                  <option selected>Please select your Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="mf-trans-male">Transgender (M -> F)</option>
                  <option value="fm-trans-female">Transgender (F -> M)</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="newAdminInputDOB" class="form-label">Date of birth</label>
                <input type="date" class="form-control rounded-pill" id="newAdminInputDOB" name="newAdminInputDOB" required />
              </div>
              <div class="mb-3">
                <label for="newAdminInputIDNum" class="form-label">SA ID Number</label>
                <input type="number" class="form-control rounded-pill" id="newAdminInputIDNum" name="newAdminInputIDNum" />
              </div>
              <div class="mb-3">
                <label for="newAdminInputResAddress" class="form-label">Residential address</label>
                <textarea type="email" class="form-control rounded" id="newAdminInputResAddress" name="newAdminInputResAddress" rows="5"></textarea>
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="promoCheck" name="promoCheck" />
                <label class="form-check-label text-start" for="promoCheck" aria-checked="true" checked="checked">Subscribe for promotional content?</label>
              </div>
              <button type="submit" class="btn btn-outline-light btn-block rounded-pill sniglet-font">
                <span class="fs-1 m-4">Register <i class="fas fa-paper-plane"></i></span>
              </button>
            </form>
          </div>
          <!-- ./ Administrator Registration Form -->
        </div>
      </div>

      <h5 class="mt-4" id="client-list-table-heading">Client User Accounts List: <i class="fas fa-arrow-down"></i> (<a href="#system-admin-list-table-heading">Next Table</a>) <i class="fas fa-arrow-up"></i> (<a href="#product-list-table-heading">Prev Table</a>)</h5>

      <div class="table-responsive border-success" style="border-radius: 25px; border-top: #1c9941 solid 5px">
        <table class="table table-hover table-bordered table-light text-success mb-4z sniglet-font shadow" id="client-list-table-container">
          <thead class="table-success">
            <tr>
              <th scope="col" colspan="2" class="bg-success text-white text-center"><i class="fas fa-ellipsis-h"></i></th>

              <th scope="col">#</th>
              <th scope="col">Username</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Names</th>
              <th scope="col">Contact Number</th>
              <th scope="col">Email Address</th>
              <th scope="col">Date of Birth</th>
              <th scope="col">ID Number</th>
              <th scope="col">Residential Address</th>
              <th scope="col">User Type</th>
              <th scope="col">Registration Date</th>
            </tr>
          </thead>
          <tbody id="client-list-table-body" class="text-dark"></tbody>
        </table>
      </div>

      <h5 class="mt-4" id="system-admin-list-table-heading">System Administrators User Accounts List: <i class="fas fa-arrow-up"></i> (<a href="#client-list-table-heading">Prev Table</a>)</h5>

      <div class="table-responsive border-success" style="border-radius: 25px; border-top: #1c9941 solid 5px">
        <table class="table table-hover table-bordered table-light text-success mb-4z sniglet-font shadow" id="system-admin-list-table-container">
          <thead class="table-success">
            <tr>
              <th scope="col" colspan="2" class="bg-success text-white text-center"><i class="fas fa-ellipsis-h"></i></th>

              <th scope="col">#</th>
              <th scope="col">Username</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Names</th>
              <th scope="col">Contact Number</th>
              <th scope="col">Email Address</th>
              <th scope="col">Date of Birth</th>
              <th scope="col">ID Number</th>
              <th scope="col">Residential Address</th>
              <th scope="col">User Type</th>
              <th scope="col">Registration Date</th>
            </tr>
          </thead>
          <tbody id="system-admin-list-table-body" class="text-dark"></tbody>
        </table>
      </div>

      <hr class="text-success fs-1" />
      <hr class="text-success fs-1" />
      <hr class="text-success fs-1" />
    </div>
    <!-- ./ Main Content -->

    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide shadow py-4z" data-bs-ride="carousel" style="border-bottom: #1c9941 solid 10px; border-top: #1c9941 solid 10px; background-color: #1c9941">
      <!--<div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
      </div>-->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="../../media/general/carousal/slide1.png" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="../../media/general/carousal/slide2.png" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="../../media/general/carousal/slide3.png" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="../../media/general/carousal/slide4.png" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="../../media/general/carousal/slide5.png" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="../../media/general/carousal/slide6.png" class="d-block w-100" alt="..." />
        </div>
      </div>
      <!--<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>-->
    </div>
    <!-- ./ Carousel -->

    <!-- footer -->
    <div class="footer mb-0 pt-4 fixed-bottomz">
      <div class="container">
        <div class="row">
          <div class="col-md text-center pb-4">
            <img src="../../media/assets/Happy Events Rental Light Theme Full Logo.png" alt="logo" class="img-fluid shadow btn-success" style="border-radius: 25px" />

            <p class="mt-4"><strong class="unica-one-font">Happy Events Equipment Rentals</strong> is an Equipment Rental company which sells and primarily leases equipment for all types of events. Whatever you need, we got it.</p>
          </div>
          <div class="col-md text-start pb-4">
            <h2 class="text-start sniglet-font-thick">Navigation</h2>
            <ul class="list-group list-group-flush py-4" id="footer-navigation">
              <li class="list-group-item bg-transparent"><a href="../../index.php">Home</a></li>
              <li class="list-group-item bg-transparent"><a href="../../about.php">About</a></li>
              <li class="list-group-item bg-transparent"><a href="../../app/EquipmentCatalogue.php">Shop</a></li>
              <li class="list-group-item bg-transparent"><a data-bs-toggle="modal" data-bs-target="#clientSignInModal" style="cursor: pointer">Sign In</a></li>
              <li class="list-group-item bg-transparent"><a href="../../contact.php">Contact</a></li>
            </ul>

            <h2 class="text-start sniglet-font-thick">Important Links</h2>
            <ul class="list-group list-group-flush py-4" id="footer-navigation">
              <li class="list-group-item bg-transparent"><a href="https://sacoronavirus.co.za/">COVID-19</a></li>
              <li class="list-group-item bg-transparent"><a href="#">Privacy Policy</a></li>
              <li class="list-group-item bg-transparent"><a href="#">Return Policy</a></li>
              <li class="list-group-item bg-transparent"><a href="#">Terms of Use</a></li>
            </ul>
          </div>
          <div class="col-md pb-4">
            <h2 class="sniglet-font-thick">Sign up for our Newsletter</h2>
            <p>By signing up, you will be added to our mailing list for our Monthly Newsletters. This will also enter you automatically in our promotional prize draws as well as make you elidgible to receiving Monthly Checkout Discounts (if you are a registered client).</p>
            <form class="row g-3">
              <div class="col-auto">
                <label for="staticEmail2" class="visually-hidden">Email</label>
                <input type="email" class="form-control -plaintext text-center rounded-pill shadow" id="staticEmail2" placeholder="email@example.com" />
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-outline-light rounded-pill mb-3">Subscribe</button>
              </div>
            </form>
          </div>
        </div>

        <hr class="text-white" />

        <div class="w-100 text-center">
          <p class="py-4">Crafted by Thabang Mposula (8008999) &copy; 2021 | Systems Development 3 (HSYD300-1) SA1</p>
        </div>
      </div>
    </div>
    <!-- ./ footer -->

    <script>
      //******* Admin: Product List
      //We want to load the Products list using Ajax and PHP to compile a body of .product-card Div Elements for the product-card-grid-container Div Container Element.
      function loadProducts() {
        //Initialize Variables
        var productsTableBody = document.getElementById("product-list-table-body");

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
          productsTableBody.innerHTML = this.responseText;
        };
        xhttp.open("GET", "compile-admin-product-list.php?entry=pageinit", true);
        xhttp.send();
      }

      function loadClients() {
        //Initialize Variables
        var clientsTableBody = document.getElementById("client-list-table-body");

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
          clientsTableBody.innerHTML = this.responseText;
        };
        xhttp.open("GET", "compile-admin-clients-list.php?entry=pageinit", true);
        xhttp.send();
      }

      function loadAdmins() {
        //Initialize Variables
        var adminsTableBody = document.getElementById("system-admin-list-table-body");

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
          adminsTableBody.innerHTML = this.responseText;
        };
        xhttp.open("GET", "compile-admin-admins-list.php?entry=pageinit", true);
        xhttp.send();
      }

      function initializeTables() {
        loadProducts();
        loadClients();
        loadAdmins();
        //alert("Tables Refreshed");
      }

      //******* User sign out
      function adminSignOut() {
        window.location.href = "admin-sign-out.php";
      }

      //******* Admin: Delete Record from Product List
      //We want to remove the record of the id from the database and UI table
      function deleteProductRecord(prodid) {
        //Initialize Variables
        //var adminsTableBody = document.getElementById("system-admin-list-table-body");
        var returned;

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
          returned = this.responseText;

          if (returned == "success") {
            alert("Notice!\n\n\nThe selected record has been Deleted Successfully.");
            initializeTables();
          } else if (returned.startsWith("An Error has Occured")) {
            //Do something interesting with this error msg output at a l8r stage!?!?
            alert(returned);
          } else {
            alert(returned);
          }
        };
        xhttp.open("GET", "delete-product.php?id=" + prodid, true);
        xhttp.send();
      }

      //******* Admin: Delete Record from Client List
      //We want to remove the record of the id from the database and UI table
      function deleteClientRecord(clientid) {
        //Initialize Variables
        //var adminsTableBody = document.getElementById("system-admin-list-table-body");
        var returned;

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
          returned = this.responseText;

          if (returned == "success") {
            alert("Success Notice!\n\n\nThe selected record has been Deleted Successfully.");
          } else if (returned.startsWith("An Error has Occured")) {
            //Do something interesting with this error msg output at a l8r stage!?!?
            alert("Error Notice!\n\n\n" + returned);
          } else {
            alert("Notice!\n\n\n" + returned);
          }
        };
        xhttp.open("GET", "delete-client.php?id=" + clientid, true);
        xhttp.send();
      }

      //******* Admin: Delete Record from Admin List
      //We want to remove the record of the id from the database and UI table
      function deleteAdminRecord(employeeid) {
        //Initialize Variables
        //var adminsTableBody = document.getElementById("system-admin-list-table-body");
        var returned;

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
          returned = this.responseText;

          if (returned == "success") {
            alert("Notice!\n\n\nThe selected record has been Deleted Successfully.");
          } else if (returned.startsWith("An Error has Occured")) {
            //Do something interesting with this error msg output at a l8r stage!?!?
            alert(returned);
          } else {
            alert(returned);
          }
        };
        xhttp.open("GET", "delete-administrator.php?id=" + employeeid, true);
        xhttp.send();
      }

      //******* Admin: Launch the Record Update Modal - Product List Client List Admin List
      //We want to Launch the Record Update Modal when the edit buttons are clicked from Product, Client, Admin List
      function showModal(recordid, origin) {
        //initialize variable
        var modalToggleBtn = document.getElementById("toggle-edit-record-modal");
        var modalIFrameViewer = document.getElementById("edit-form-viewer");
        var editRecordModalLbl = document.getElementById("edit-record-modal-label");

        if (origin == "products") {
          //open the edit record modal and pass the url for edit-product.php?id=val in the #edit-form-viewer iframe
          modalToggleBtn.click();
          editRecordModalLbl.innerHTML = "<strong>Edit Product Record</strong> (" + origin + " id: " + recordid + ")";
          modalIFrameViewer.src = "edit-product.php?id=" + recordid;
        } else if (origin == "clients") {
          //open the edit record modal and pass the url for edit-client.php?id=val in the #edit-form-viewer iframe
          modalToggleBtn.click();
          editRecordModalLbl.innerHTML = "<strong>Edit Client Record</strong> (" + origin + " id: " + recordid + ")";
          modalIFrameViewer.src = "edit-client.php?id=" + recordid;
        } else if (origin == "admins") {
          //open the edit record modal and pass the url for edit-admin.php?id=val in the #edit-form-viewer iframe
          modalToggleBtn.click();
          editRecordModalLbl.innerHTML = "<strong>Edit Administrator Record</strong> (" + origin + " id: " + recordid + ")";
          modalIFrameViewer.src = "edit-admin.php?id=" + recordid;
        }
      }

      //On load: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
      document.addEventListener("load", initializeTables());
    </script>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
