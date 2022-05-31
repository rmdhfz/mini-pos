<div class="main-body">
    <div class="page-wrapper">
      <div class="page-body">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
              Periode: <?php echo date('d-M-Y'); ?>
            </li>
          </ol>
        </nav>
        <div class="row">
          <div class="col-md-4 col-xl-4">
            <div class="card comp-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <i class="fas fa-user bg-c-green" aria-hidden="true"></i>
                  </div>
                  <div class="col">
                    <a href="<?php echo base_url('user'); ?>">
                    	<h6><b>Total User</b></h6><hr>
                    </a>
                    <div id="total-user"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-xl-4">
            <div class="card comp-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <i class="fa fa-th-list bg-c-red" aria-hidden="true"></i>
                  </div>
                  <div class="col">
                    <a href="<?php echo base_url('supplier'); ?>">
                    	<h6><b>Total Supplier</b></h6>
                    </a>
                    <hr />
                    <div id="total-supplier"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-xl-4">
            <div class="card comp-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <i class="fab fa-product-hunt bg-c-blue" aria-hidden="true"></i>
                  </div>
                  <div class="col">
                    <a href="<?php echo base_url('produk'); ?>">
                    	<h6><b>Total Produk</b></h6>
                    </a>
                    <hr />
                    <div id="total-produk"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-xl-4">
            <div class="card comp-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <i class="fa fa-users bg-c-blue"></i>
                  </div>
                  <div class="col">
                    <a href="<?php echo base_url('pelanggan'); ?>">
                      <h6><b>Total Pelanggan</b></h6>
                    </a>
                    <hr />
                    <div id="total-pelanggan"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-xl-4">
            <div class="card comp-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <i class="fas fa-cart-arrow-down bg-c-green"></i>
                  </div>
                  <div class="col">
                    <a href="<?php echo base_url('pembelian'); ?>">
                      <h6><b>Total Pembelian</b></h6>
                    </a>
                    <hr />
                    <div id="total-pembelian"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-xl-4">
            <div class="card comp-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <i class="fas fa-chart-bar bg-c-yellow"></i>
                  </div>
                  <div class="col">
                    <a href="<?php echo base_url('penjualan'); ?>">
                      <h6><b>Total Penjualan</b></h6>
                    </a>
                    <hr />
                    <div id="total-penjualan"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  	$(document).ready(function() {
  		async function getTotalAsset()
  		{
  			await $.post('total/user').done((res, xhr, status) => {
  				$("#total-user").text(res.data.total);
  			})
  		}
  		async function getTotalEmployee()
  		{
  			await $.post('total/supplier').done((res, xhr, status) => {
  				$("#total-supplier").text(res.data.total);
  			})
  		}
  		async function getTotalAssigment()
  		{
  			await $.post('total/produk').done((res, xhr, status) => {
  				$("#total-produk").text(res.data.total);
  			})
  		}
  		getTotalAsset();
  		getTotalEmployee();
  		getTotalAssigment();
  	});
  </script>