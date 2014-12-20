<!-- Include page_header for every single page. -->
<?php include ('includes/page_header.php'); ?>
    
    <!-- Begin content -->
    <div id="main_content">
    	<div class="centre_container">
            
            <!-- INCLUDE Search results based on form data -->
            <div class="right_content_box">
            	<?php include('includes/search_db.php'); ?>
            </div>
            
            <!-- INCLUDE Search form data -->
            <?php include('includes/search_db_form.php'); ?>
            
        </div>
    </div>
    
    <?php include('includes/page_footer.php');  ?>

