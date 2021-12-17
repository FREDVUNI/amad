<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Users</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Admins</li>
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
      <a class="text-secondary btn-sm float-right" href="<?php echo base_url('admin/register'); ?>">
      <i class="ti-plus"></i> ADD NEW USER
      </a>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table id="zero_config" class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>Image</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Join Date</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($userinfo as $row):?>
               <tr>
                  <td class="py-1">
                     <img src="<?php echo base_url('assets/backend/images/uploads/admins/').$row['image'];?>"  alt="image" class="profile-pic rounded-circle" width="35px" height="35px">
                  </td>
                  <td><?php echo $row['username'];?></td>
                  <td><?php echo $row['email'];?></td>
                  <td>
                     <?php 
                        if($row['role_id'] == 1){
                            echo "Administrator";
                        }elseif($row['role_id'] == 2){
                            echo "member";
                        }else{
                            echo "No Role";
                        }
                        ?>
                  </td>
                  <td><?php echo date("d-m-Y g:i A", strtotime($row['date_created']));?></td>
               </tr>
               <?php endforeach;?>
            </tbody>
            <tfoot>
               <tr>
                  <th>Image</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Join Date</th>
               </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>