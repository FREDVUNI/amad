<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Subscriptions</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Subscribers</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
<?php echo $this->session->flashdata('message');?>
<div class="card">
   <div class="card-header">
      <a class="text-secondary btn-sm float-right" href="<?php echo base_url('admin/add/newsletter'); ?>">
      <i class="ti-plus"></i> SEND NEWSLETTERS
      </a>   
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table id="zero_config" class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Email</th>
                  <th>Date</th>
               </tr>
            </thead>
            <tbody>
               <?php  $i=1;  foreach ($subscribe as $row):?>
               <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row['email'];?></td>
                  <td><?php echo date("d-m-Y g:i A", strtotime($row['date_created']));?></td>
               </tr>
               <?php endforeach; ?>
            </tbody>
            <tfoot>
               <tr>
                  <th>#</th>
                  <th>Email</th>
                  <th>Date</th>
               </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>