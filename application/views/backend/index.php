<?php
	$this->session->set_userdata('page_type',$page_view);
	$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
	$system_title       =	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
	$text_align         =	$this->db->get_where('settings' , array('type'=>'text_align'))->row()->description;
	$account_type       =	 $this->session->userdata('login_type');
	$skin_colour        =   $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description;
	$active_sms_service =   $this->db->get_where('settings' , array('type'=>'active_sms_service'))->row()->description;
	$sidebar_collapsed 	=  $this->db->get_where('settings' , array('type'=>'sidebar-collapsed'))->row()->description=='yes'?'sidebar-collapsed':"";
	?>
<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>

	<title><?php echo $page_title;?> | <?php echo $system_title;?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="FPS School Manager Pro - FreePhpSoftwares" />
	<meta name="author" content="FreePhpSoftwares" />


	<?php include 'includes_top.php';?>
	

</head>
<body class="page-body <?php if ($skin_colour != '') echo 'skin-' . $skin_colour;?>" >
	<!-- <div class="page-container <?=$sidebar_collapsed;?> <?php if ($text_align == 'right-to-left') echo 'right-sidebar';?>" > -->
	<div class="page-container horizontal-menu">	
		<?php include 'navigation_'.$account_type.'.php';?>
		<div class="main-content">
			
			<?php //include 'header.php';?>
			
			<?php //include 'lower_header.php'?>
			<div id="page_content" class="row">  
				<div class="col-xs-12">
					
			
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-6 pull-right;">	
					           <!-- <h3 style="">
					           	<i class="entypo-right-circled"></i>
									<?php echo $page_title;?>
					           </h3> -->
				           </div>
				           
				            <div class="col-xs-6 pull-right;">
				            	<div class="btn-group pull-right">
									<button class="btn btn-default" title="<?=get_phrase('back');?>" onclick="javascript:go_back();"><i class="fa fa-backward"></i></button>
									<button class="btn btn-default" title="<?=get_phrase('forward');?>" onclick="javascript:go_forward();"><i class="fa fa-forward"></i></button>
								</div>
									  								  		
								
						 	</div> 		
						</div>
					</div>
			
			
					<?php 
							if(file_exists(APPPATH."/views/backend/".$page_view.'/'.$account_type.'/'.$page_name.'.php')){
								include $page_view.'/'.$account_type.'/'.$page_name.'.php';
							}else{
								include $page_view.'/'.$page_name.'.php';
							}
							
					?>
				</div>
			</div>
			<?php include 'footer.php';?>

		</div>
		<?php //include 'chat.php';?>
	
	</div>
    <?php include 'modal.php';?>
    <?php include 'includes_bottom.php';?>
    <?php include 'privileges.php';?>

</body>
</html>
