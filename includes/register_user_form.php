<?php 
$wholesale_items = array("plastic_kombucha_tap", "chrome_plastic_tap", "stainless_steel_tap", 
						
						"gravity_doulton", "slimline_doulton", "black_berky", "ultracarb", "berkyPF-4", "berkyPF-2", 
						
						"original_durand_system", "flouride_reduction_system", "deluxe_twin_filter_system", 
						"one_of_a_kind_system", "ceramic_storage_container", 
						
						"berkefeld_doulton", "berkefeld_black_berky", "fairey_countertop_system",  
						
						"kombucha_jar", "fermentation_crock"
						
						);
$wholesale_item_prices = array(6, 7, 18, 	//Taps
						
								1, 1, 1, 1, 1, 1, 	//Filters
								
								1, 1, 1, 1, 1,  //Durand systems
								
								1, 1, 1, 	//Stainless steel systems
								
								1, 1		//Other systems
								
								);
$wholesale_item_postage = array(true, true, true, 	//Taps
						
								false, false, false, false, false, false,   	//Filters
								
								false, false, false, false, false,   //Durand systems
								
								false, false, false, 	//Stainless steel systems
								
								false, false, 		//Other systems
								
								);
$wholesale_items = array("plastic_kombucha_tap", "chrome_plastic_tap", "stainless_steel_tap", 
						
						"gravity_doulton", "slimline_doulton", "black_berky", "ultracarb", "berkyPF-4", "berkyPF-2", 
						
						"original_durand_system", "flouride_reduction_system", "deluxe_twin_filter_system", 
						"one_of_a_kind_system", "ceramic_storage_container", 
						
						"berkefeld_doulton", "berkefeld_black_berky", "fairey_countertop_system",  
						
						"kombucha_jar", "fermentation_crock"
						
						);
?>

<script type="text/javascript">
	window.onload = function() {
		
		<?php 
		foreach ($wholesale_items as $item) { ?>
			document.getElementById("<?php echo $item; ?>_button").onclick = function() {
				resetOrderBoxes();
				document.getElementById("<?php echo $item; ?>_order").style.display = 'inherit';
				//Generate contact box below product info.
				generateContactForm('<?php echo $item; ?>');
			};
		<?php
		}
		?>
	  
	};
</script>

<!-- WHOLESALE ITEM LISTINGS -->
<table class="wholesale_display">
    <tr>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[0]; ?>_button">
        <img src="../images/new/kombucha/thumbnails/KombuchaTap.jpg" width="160" alt="Plastic tap"></a> <h3>Plastic Kombucha</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[1]; ?>_button">
        <img src="../images/tap.jpg" width="160" alt="Chrome-plated plastic tap"></a> <h3>Chrome-plated plastic</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[2]; ?>_button">
        <img src="../images/new/steeltap.png" width="160" alt="Steel tap"></a> <h3>Stainless steel</h3></td>
    </tr>
</table>
<table class="wholesale_display">
    <tr>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[3]; ?>_button">
        <img src="../images/new/elements/thumbnails/RoyalDoultonFilter.jpg" height="160" alt="Gravity Doulton"></a> <h3>Gravity Doulton</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[4]; ?>_button">
        <img src="../images/new/elements/thumbnails/DoultonSlimline.jpg" height="160" alt="Slimline Doulton"></a> <h3>Slimline Doulton</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[5]; ?>_button">
        <img src="../images/new/elements/thumbnails/BlackBerkeyElement.jpg" height="160" alt="Black Berkefeld Element"></a> <h3>Black Berky</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[6]; ?>_button">
        <img src="../images/UltraCarb.jpg" height="160" alt="Ultracarb Element"></a> <h3>Ultracarb</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[7]; ?>_button">
        <img src="../fluorideimages/berkeypf4element2.jpg" height="160" alt="BerkyPF-4"></a> <h3>BerkyPF-4</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[8]; ?>_button">
        <img src="../images/new/elements/thumbnails/BerkyPF2DUAL.jpg" height="160" alt="BerkyPF-2"></a> <h3>BerkyPF-2</h3></td>
    </tr>
</table>
<table class="wholesale_display">
    <tr>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[9]; ?>_button">
        <img src="../images/new/filterlist/thumbnails/OatmealStone.jpg" height="250" alt="Original durand filter"></a> <h3>Original Durand</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[10]; ?>_button">
        <img src="../images/new/fluoride/thumbnails/WhiteStone.jpg" height="250" alt="Fluoride filter system"></a> <h3>Fluoride Reduction</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[11]; ?>_button">
        <img src="../specialimages/TF-bluegreen.jpg" height="250" alt="Deluxe Twin filter system"></a> <h3>Deluxe Twin Filter</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[12]; ?>_button">
        <img src="../specialimages/LE-bluecarvedurn.jpg" height="250" alt="One of a Kind filter system"></a> <h3>One of a Kind</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[13]; ?>_button">
        <img src="../images/new/filterlist/thumbnails/WhiteOcean.jpg" height="250" alt="Ceramic Storage container"></a> <h3>Storage Containers</h3></td>
    </tr>
</table>
<table class="wholesale_display">
    <tr>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[14]; ?>_button">
        <img src="../images/new/stainless/thumbnails/Berkefield.jpg" height="250" alt="Berkefeld Doulton">
        <img src="../images/new/elements/thumbnails/DoultonSlimline.jpg" height="120" alt="Doulton">
        <img src="../images/new/elements/thumbnails/DoultonSlimline.jpg" height="120" alt="Doulton">
        </a> <h3>Berkefeld</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[15]; ?>_button">
        <img src="../images/new/stainless/thumbnails/Berkefield.jpg" height="250" alt="Berkefeld Black">
        <img src="../images/new/elements/thumbnails/BlackBerkeyElement.jpg" height="120" alt="Black">
        <img src="../images/new/elements/thumbnails/BlackBerkeyElement.jpg" height="120" alt="Black">
        </a> <h3>Black Berky</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[16]; ?>_button">
        <img src="../images/new/stainless/thumbnails/Fairey.jpg" height="250" alt="Fairey Countertop"></a> <h3>Fairey Countertop</h3></td>
    </tr>
</table>
<table class="wholesale_display">
    <tr>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[17]; ?>_button">
        <img src="../images/new/kombucha/thumbnails/KombuchaWhite.jpg" height="250" alt="Kombucha Jar"></a> <h3>Kombucha Jar</h3></td>
        <td> <a href="#Order_Form" id="<?php echo $wholesale_items[18]; ?>_button">
        <img src="../images/new/fermentation/thumbnails/FermentationCrockWhite.jpg" height="250" alt="Fermentation Crock"></a> <h3>Fermentation Crock</h3></td>
    </tr>
</table>
			
<!-- BEGIN ORDER FORMS -->
<a name="Order_Form"></a>

<?php 
for($i = 0; $i < sizeof($wholesale_items); $i++) {
	wholesaleItemListing($wholesale_items[$i], $wholesale_item_prices[$i], $wholesale_item_postage[$i], $wholesale_images[$i]);
}
?>

<?php 

function wholesaleItemListing($name, $price, $postage, $image_path) {
?>
			<div class="wholesale_item" id="<?php echo $name; ?>_order">
            	<form autocomplete="off" enctype="text/plain" 
                onsubmit="return orderWholesaleProduct(true, '<?php echo ucwords(str_replace('_', ' ', $name)); ?>', '<?php echo $name; ?>', <?php echo $price; ?>)" 
                onchange="orderWholesaleProduct(false, '<?php echo ucwords(str_replace('_', ' ', $name)); ?>', '<?php echo $name; ?>', <?php echo $price; ?>)">
				<table class="product_display">
					<tr>
						<td><img src="../images/new/kombucha/thumbnails/KombuchaTap.jpg" width="160" alt="<?php echo $name; ?>"></td>
                        <td><h4><?php echo ucwords(str_replace('_', ' ', $name)); ?></h4>		
                       		 <p>$<?php echo $price; ?></p>		
								<?php if($postage) { ?><p>Including postage and handling.</p><?php } ?> </td>
                        <td><h4>Item Quantity: </h4><input type="number" id="<?php echo $name; ?>_amount" value="0">
                        	<?php if(!$postage) { ?>
								<h4>Ship to: </h4>
                                <select class="drop_down" id="<?php echo $name; ?>_location">
                                    <option>S.E. QLD.</option>
                                    <option>Qld & NSW.</option>
                                    <option>ACT & Vic.</option> 
                                    <option>SA</option> 
                                    <option>Tas, WA, NT</option> 
                                </select>
                                <?php } ?>
                        	</td>
					</tr>
                    <tr>
                    	<td colspan="3" class="order_contact_form" id="<?php echo $name; ?>_contact"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><h2 id="<?php echo $name; ?>_system_price">Total cost: $</h2></td>
                        <td><input class="submit_button_large" type="submit" value="SUBMIT ORDER" /></td>
                    </tr>
				</table>
                </form>
			</div>
<?php 
}
?>