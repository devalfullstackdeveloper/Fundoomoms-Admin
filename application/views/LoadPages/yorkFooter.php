<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

</div>
<!-- END layout-wrapper -->

</div>
<!-- end container-fluid -->
<!-- JAVASCRIPT -->
<script src="<?= base_url() ?>app-assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/metisMenu.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/simplebar.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/waves.min.js"></script>
<!-- Select 2 -->
<!--<script src="<?= base_url() ?>app-assets/js/select2.min.js"></script>-->
<!-- Responsive Table js -->
<script src="<?= base_url() ?>app-assets/js/rwd-table.min.js"></script>
<!-- Required datatable js -->
<script src="<?= base_url() ?>app-assets/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url() ?>app-assets/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/jszip.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/pdfmake.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/vfs_fonts.js"></script>
<script src="<?= base_url() ?>app-assets/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?= base_url() ?>app-assets/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>app-assets/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?= base_url() ?>app-assets/js/datatables.init.js"></script>
<!-- Sweet Alerts js -->
<script src="<?= base_url() ?>app-assets/js/sweetalert2.min.js"></script>
<!-- Sweet alert init js-->
<script src="<?= base_url() ?>app-assets/js/sweet-alerts.init.js"></script>

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<!-- App js -->
<script src="<?= base_url() ?>app-assets/js/app.js"></script>
<script src="<?= base_url() ?>app-assets/js/script.js"></script>
<script src="<?= base_url() ?>app-assets/js/jquery.mask.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<!-- <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script> -->
<!-- <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script> -->
<script type="text/javascript" src="<?= base_url() ?>app-assets/js/ckeditor/ckeditor.js"></script>
<?php
	if(isset($cdnscript)){
		foreach ($cdnscript as $cdnkey => $cdnvalue) {
?>
<script src="<?= $cdnvalue; ?>"></script>	
<?php			
		}
	}
	if(isset($scriptname)){
?>
<script src="<?= base_url() ?>app-assets/js/paneljs/<?= $scriptname; ?>"></script>
<?php	
	}
?>

<div id="overlay">
	<div class="cv-spinner">
		<span class="spinner"></span>
	</div>
</div>
</body>

</html>