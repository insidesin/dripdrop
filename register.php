<!-- Include page_header for every single page. -->
<?php include ('includes/page_header.php'); ?>
    
    <!-- Begin content -->
    <div id="main_content">
    	<div class="centre_container">
      
            <div class="right_content_box">
            	
                <!-- INCLUDE Registration form data -->
            	<h2>Registration form: </h2>
					<?php include ('includes/register_user_form.php'); //Include MySQL db connection info. ?>
					
            </div>
            
            <!-- INCLUDE Search form data -->
            <?php include('includes/search_db_form.php'); ?>
            
        </div>
    </div>
    
    <?php include('includes/page_footer.php');  ?>
