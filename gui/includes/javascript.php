
<!-- PHP Session Objects to Javascript -->
<script>
function getSession() {
  var objSession = <?php echo json_encode($_SESSION);?>;
  return objSession;
}
</script>

<!-- Include Javascript Client Libs -->
<script src="vendor/v6-helper/AjaxHelper.js"></script>
<script src="vendor/v6-helper/UiHelper.js"></script>
<script src="vendor/tooltipster/dist/js/tooltipster.main.min.js"></script>
