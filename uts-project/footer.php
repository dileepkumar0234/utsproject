<footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Design and Developed by aapthitech.com</b> </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://aapthitech.com">Aapthi Technologies</a>.</strong> All rights reserved.
</footer>
</div>
	<script src="js/formValidation.js"></script>

	<script src="js/bootstrap.js"></script>

    <script src="js/getrupee-main.js"></script>
    <script src="js/getrupee-jquery.dataTables.js"></script>
	<script src="js/getrupee-dataTables.js"></script>
	
    <script src="js/getrupee-app.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
	<script src="js/getrupee-tooltip.js"></script>
	<script src="js/commonfunctions.js"></script>
  </body>
</html>
<script type="text/javascript">
	$(function() {
		function reposition() {
			var modal = $(this),
			dialog = modal.find('.modal-dialog');
			modal.css('display', 'block');
			dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
		}
		$('.modal').on('show.bs.modal', reposition);
		$(window).on('resize', function() {
			$('.modal:visible').each(reposition);
		});
	});
	$('.main-footer').hide();
	$(function () {
		$("#example1").DataTable({
		  "paging": true,
		  "lengthChange": true,
		  "searching": true,
		  "ordering": true,
		  "info": true,
		  "autoWidth": true
		});
	});
</script>

	