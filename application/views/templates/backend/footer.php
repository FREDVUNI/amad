        <script src="<?php echo base_url('assets/backend/');?>libs/jquery/jquery.min.js"></script>
            <footer class="footer mt-5">
                All Rights Reserved <a href="https://www.amad.com" target="_blank">AMAD</a>. &copy; <script>$(document.write(new Date().getFullYear()));</script>.
            </footer>
        </div>
    </div>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url('assets/backend/');?>libs/popper.js/umd/popper.min.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/perfect-scrollbar/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url('assets/backend/');?>js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo base_url('assets/backend/');?>js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo base_url('assets/backend/');?>js/custom.min.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/flot/excanvas.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/flot/jquery.flot.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/flot/jquery.flot.time.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/flot/jquery.flot.stack.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/flot/jquery.flot.crosshair.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>js/pages/chart/chart-page-init.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/DataTables/datatables.min.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url('assets/backend/');?>libs/quill/dist/quill.min.js"></script>
    
    <script>
        $('#zero_config').DataTable();
        var quill = new Quill('#editor', {
            theme: 'snow'
        });
        jQuery('.mydatepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        var editor_content = quill.container.innerHTML
    </script>
</body>

</html>