<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Events & Parties</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Events & Parties</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
<div class="col-md-12"><?php echo $this->session->flashdata('message');?></div>
<!--?php echo form_open_multipart('admin/add/events-and-parties');?-->
<form action="<?php echo base_url('admin/add/events-and-parties');?>" enctype="multipart/form-data" id="validatevent" novalidate="novalidate" method="POST">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-12 form-group">
                  <label>Event <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?php if(form_error('event')): echo "is-invalid"; endif;?>" name="event" id="event" placeholder="Enter Event Or Party" value="<?php echo set_value('event');?>" autofocus>
                  <span class="text-danger"><?php echo form_error('event');?></span>
               </div>
               <div class="col-md-12 form-group">
                  <div class="row">
                     <div class="col-md-6 form-group">
                        <label>Location <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control <?php if(form_error('location')): echo "is-invalid"; endif;?>" name="location" id="location" placeholder="Enter Location of Event Or Party" value="<?php echo set_value('location');?>">
                        <span class="text-danger"><?php echo form_error('location');?></span>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Image <span class="text-danger">*</span> </label>
                        <div class="custom-file">
                           <input id="userfile" type="file" class="custom-file-input <?php if(form_error('userfile')): echo "is-invalid"; endif;?>" name="userfile">
                           <label for="userfile" class="custom-file-label text-dark">Upload Image</label>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 form-group">
                        <label>Start Time <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control <?php if(form_error('timefrom')): echo "is-invalid"; endif;?>" name="timefrom" id="timefrom" placeholder="Enter start Time (like 8:00 AM)" value="<?php echo set_value('timefrom');?>">
                        <span class="text-danger"><?php echo form_error('timefrom');?></span>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>End Time <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control <?php if(form_error('timeto')): echo "is-invalid"; endif;?>" name="timeto" id="timeto" placeholder="Enter End Time (like 11:00 PM)" value="<?php echo set_value('timeto');?>">
                        <span class="text-danger"><?php echo form_error('timeto');?></span>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 form-group">
                        <label>Date <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control <?php if(form_error('date')): echo "is-invalid"; endif;?>" name="date" id="date" placeholder="Enter Date of Event Or Party" value="<?php echo set_value('date');?>">
                        <span class="text-danger"><?php echo form_error('date');?></span>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Access <span class="text-danger">*</span> </label>
                        <select name="access" id="access" class="form-control input-event-access <?php if(form_error('access')): echo "is-invalid"; endif;?>">
                           <option value="<?php echo set_value('access');?>">
                              <?php 
                                 if(set_value('access') == "public"){echo "Public";
                                 }elseif(set_value('access') == "private"){
                                     echo "Private";
                                 }else{
                                     echo "Choose Access Type";
                                 }
                                 ?>
                           </option>
                           <option value="public">Public</option>
                           <option value="private">Private</option>
                        </select>
                        <span class="text-danger"><?php echo form_error('access');?></span>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 form-group">
                        <label>URL <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control <?php if(form_error('url')): echo "is-invalid"; endif;?>" name="url" id="url" placeholder="Enter URL" value="<?php echo set_value('url');?>">
                        <span class="text-danger"><?php echo form_error('url');?></span>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Rsvp or Ticket URL <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control <?php if(form_error('rsvp_ticket_url')): echo "is-invalid"; endif;?>" name="rsvp_ticket_url" id="rsvp_ticket_url" placeholder="Enter URL" value="<?php echo set_value('rsvp_ticket_url');?>">
                        <span class="text-danger"><?php echo form_error('rsvp_ticket_url');?></span>
                     </div>
                  </div>
               </div>
               <div class="form-group col-md-12">
                  <button type="submit" class="btn btn-danger waves-effect waves-light col-md-2">Save changes</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
<script src="<?php echo base_url('assets/backend/');?>libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url('assets/backend/js/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/additional-methods.min.js');?>"></script>
<script>
   $('#validatevent').validate({
       rules: {
       event: {
           required: true,
       },
       location: {
           required: true,
       },
       userfile: {
           required: true,
           accept:"image/*"
       },
       timefrom: {
           required: true,
       },
       timeto: {
           required: true,
       },
       date: {
           required: true,
       },
       access: {
           required: true,
       },
       url: {
           required: true,
       },
       rsvp_ticket_url: {
           required: true,
       },
       },
       messages: {
       event: {
           required: "Please enter an event",
       },
       location: {
           required: "Please choose a location",
       },
       userfile: {
           required: "Please provide an image",
           accept:"Please choose a valid image"
       },
       timefrom: {
           required: "Please enter starting time",
       },
       timeto: {
           required: "Please enter end time",
       },
       date: {
           required: "Please enter event date",
       },
       access: {
           required: "Please enter event access",
       },
       url: {
           required: "Please enter url",
       },
       rsvp_ticket_url: {
           required: "Please enter url for RSVP or Ticket",
       },
       },
       errorElement: 'span',
       errorPlacement: function (error, element) {
       error.addClass('invalid-feedback');
       element.closest('.form-group').append(error);
       },
       highlight: function (element, errorClass, validClass) {
       $(element).addClass('is-invalid');
       },
       unhighlight: function (element, errorClass, validClass) {
       $(element).removeClass('is-invalid');
       }
   });
</script>