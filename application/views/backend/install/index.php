<?php
  //This is an install index file
  $school_name = $this->db->get_where('settings',array('type'=>'system_name'))->row()->description;
  $skin_colour =   $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<title>Install | <?=$school_name;?></title>


	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.0.min.js"></script>

	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="shortcut icon" href="assets/images/favicon.png">

</head>
<body class="page-body <?php if ($skin_colour != '') echo 'skin-' . $skin_colour;?>"  data-url="http://neon.dev">

  <div class="page-container horizontal-menu">

    <div class="main-content">

      <div id="page_content" class="row">

        <?php include $page_name.'.php';?>

      </div>
    </div>
  </div>
<?php if ($this->session->flashdata('flash_message') != ""):?>

<script type="text/javascript">
toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
</script>

<?php endif;?>
    <?=include __DIR__.'/../modal.php';?>

  	<!-- Bottom Scripts -->
  	<script src="assets/js/gsap/main-gsap.js"></script>
  	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
  	<script src="assets/js/bootstrap.js"></script>
  	<script src="assets/js/joinable.js"></script>
  	<script src="assets/js/resizeable.js"></script>
  	<script src="assets/js/neon-api.js"></script>
  	<script src="assets/js/jquery.validate.min.js"></script>
  	<script src="assets/js/neon-login.js"></script>
  	<script src="assets/js/neon-custom.js"></script>
  	<script src="assets/js/neon-demo.js"></script>

  </body>
  </html>
