<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route = [
	'404_override' => "",
	// ------------------------------------------------------------------------
	'default_controller'	=>	'Frontend',
	'verify'				=>	'Frontend/login',
	'dashboard'				=>	'Backend',
	'logout'				=>	'Backend/logout',

	# monitoring
	'monitoring'			=>	'Backend/monitoring',
	'monitoring/list'		=>	'Backend/monitoringList',
	'monitoring/kick'		=>	'Backend/monitoringKick',
	# monitoring

	# backup
	'backup/database'		=>	'Backend/backupDatabase',
	'backup/aplikasi'		=>	'Backend/backupAplikasi',
	# backup

	# total
	'total/user'			=> 'Backend/totalUser',
	'total/supplier'		=> 'Backend/totalSupplier',
	'total/produk'			=> 'Backend/totalProduk',
	'total/pelanggan'		=> 'Backend/totalPelanggan',
	'total/pembelian'		=> 'Backend/totalPembelian',
	'total/penjualan'		=> 'Backend/totalPenjualan',
	# total

	# list
	'list/user'				=>	'Backend/listUser',
	'list/supplier'			=>	'Backend/listSupplier',
	'list/category'			=>	'Backend/listCategory',
	'list/product'			=>	'Backend/listProduct',
	'list/customer'			=>	'Backend/listCustomer',
	'list/purchase'			=>	'Backend/listPurchase',
	'list/sell'				=>	'Backend/listSell',
	# list

	# data
	'data/category'			=>	'Backend/dataCategory',
	'data/supplier'			=>	'Backend/dataSupplier',
	'data/product'			=>	'Backend/dataProduct',
	'data/customer'			=>	'Backend/dataCustomer',
	# data

	# user
	'user'					=> 'Backend/user',
	'user/add'				=> 'Backend/userAdd',
	'user/id'				=> 'Backend/userId',
	'user/update'			=> 'Backend/userUpdate',
	'user/delete'			=> 'Backend/userDelete',
	# user

	# supplier
	'supplier'					=> 'Backend/supplier',
	'supplier/add'				=> 'Backend/supplierAdd',
	'supplier/id'				=> 'Backend/supplierId',
	'supplier/update'			=> 'Backend/supplierUpdate',
	'supplier/delete'			=> 'Backend/supplierDelete',
	# supplier

	# category
	'kategori'					=> 'Backend/category',
	'category/add'				=> 'Backend/categoryAdd',
	'category/id'				=> 'Backend/categoryId',
	'category/update'			=> 'Backend/categoryUpdate',
	'category/delete'			=> 'Backend/categoryDelete',
	# category

	# product
	'produk'					=> 'Backend/product',
	'product/add'				=> 'Backend/productAdd',
	'product/id'				=> 'Backend/productId',
	'product/update'			=> 'Backend/productUpdate',
	'product/delete'			=> 'Backend/productDelete',
	# product

	# customer
	'pelanggan'					=> 'Backend/customer',
	'customer/add'				=> 'Backend/customerAdd',
	'customer/id'				=> 'Backend/customerId',
	'customer/update'			=> 'Backend/customerUpdate',
	'customer/delete'			=> 'Backend/customerDelete',
	# customer

	# purchase
	'pembelian'					=> 'Backend/purchase',	
	'purchase/add'				=> 'Backend/purchaseAdd',
	'purchase/id'				=> 'Backend/purchaseId',
	'purchase/update'			=> 'Backend/purchaseUpdate',
	'purchase/delete'			=> 'Backend/purchaseDelete',
	# purchase

	# sale
	'penjualan'					=> 'Backend/sell',
	'sell/add'					=> 'Backend/sellAdd',
	'sell/id'					=> 'Backend/sellId',
	'sell/update'				=> 'Backend/sellUpdate',
	'sell/delete'				=> 'Backend/sellDelete',
	# sale

	# report
	'laporan/pembelian'			=> 'Backend/laporanPembelian',
	'report/pembelian'			=> 'Backend/reportPembelian',
	# report
];