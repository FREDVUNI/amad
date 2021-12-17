<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title">Dashboard</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="row">
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
         <div class="card card-hover">
            <div class="box bg-cyan text-center">
               <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
               <h6><a href="<?php echo base_url("admin/index");?>" class="text-white">Dashboard</a></h6>
            </div>
         </div>
      </div>
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
         <div class="card card-hover">
            <div class="box bg-success text-center">
               <h1 class="font-light text-white"><i class="mdi mdi-file-document"></i></h1>
               <h6><a href="<?php echo base_url("admin/sales-offers");?>" class="text-white">Sales Promotions</a></h6>
            </div>
         </div>
      </div>
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
         <div class="card card-hover">
            <div class="box bg-danger text-center">
               <h1 class="font-light text-white"><i class="mdi mdi-calendar-clock"></i></h1>
               <h6><a href="<?php echo base_url("admin/events-and-parties");?>" class="text-white">Events & Parties</a></h6>
            </div>
         </div>
      </div>
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
         <div class="card card-hover">
            <div class="box bg-info text-center">
               <h1 class="font-light text-white"><i class="mdi mdi-tag-multiple"></i></h1>
               <h6><a href="<?php echo base_url("admin/categories");?>" class="text-white">Categories</a></h6>
            </div>
         </div>
      </div>
      <!-- Column -->
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
         <div class="card card-hover">
            <div class="box bg-success text-center">
               <h1 class="font-light text-white"><i class="mdi mdi-arrow-compress-all"></i></h1>
               <h6><a href="<?php echo base_url("admin/services");?>" class="text-white">Services</a></h6>
            </div>
         </div>
      </div>
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
         <div class="card card-hover">
            <div class="box bg-info text-center">
               <h1 class="font-light text-white"><i class="mdi mdi-apps"></i></h1>
               <h6><a href="<?php echo base_url("admin/brands");?>" class="text-white">Brands</a></h6>
            </div>
         </div>
      </div>
      <!-- Column -->
   </div>
   <!-- ============================================================== -->
   <!-- Sales chart -->
   <!-- ============================================================== -->
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">
               <div class="d-md-flex align-items-center">
                  <div>
                     <h4 class="card-title">Site Analysis</h4>
                     <h5 class="card-subtitle">Overview</h5>
                  </div>
               </div>
               <div class="row">
                  <!-- column -->
                  <div class="col-lg-9">
                     <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-line-chart"></div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="row">
                        <div class="col-6">
                           <div class="bg-dark p-10 text-white text-center">
                              <h5 class="m-b-0 m-t-5"><?php echo $amenities;?></h5>
                              <small class="font-light">Amenities</small>
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="bg-dark p-10 text-white text-center">
                              <h5 class="m-b-0 m-t-5"><?php echo $categories;?></h5>
                              <small class="font-light">Categories</small>
                           </div>
                        </div>
                        <div class="col-6 m-t-15">
                           <div class="bg-dark p-10 text-white text-center">
                              <h5 class="m-b-0 m-t-5"><?php echo $services;?></h5>
                              <small class="font-light">Services</small>
                           </div>
                        </div>
                        <div class="col-6 m-t-15">
                           <div class="bg-dark p-10 text-white text-center">
                              <h5 class="m-b-0 m-t-5"><?php echo $brands;?></h5>
                              <small class="font-light">Brands</small>
                           </div>
                        </div>
                        <div class="col-6 m-t-15">
                           <div class="bg-dark p-10 text-white text-center">
                              <h5 class="m-b-0 m-t-5"><?php echo $events;?></h5>
                              <small class="font-light">Events</small>
                           </div>
                        </div>
                        <div class="col-6 m-t-15">
                           <div class="bg-dark p-10 text-white text-center">
                              <h5 class="m-b-0 m-t-5"><?php echo $partners;?></h5>
                              <small class="font-light">Partners</small>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- column -->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>