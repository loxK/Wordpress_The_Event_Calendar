<li class="<?php echo $alt_text ?>">
	<div class="when">
		<span class="month"><?php echo date_i18n('M', $start_time); ?></span>
		<span class="date"><?php echo date_i18n('j', $start_time); ?></span>
	</div>
	<div class="event"><a href="<?php echo get_permalink($post->ID) ?>" ><?php echo $post->post_title ?></a> <?php if($EventPage!='') echo ' - <em>' . $EventPage->post_title .'</em>' ?></div>
	<div class="loc"><?php
		$space = false;
		$output = '';
		if ($EventVenue != '') {
			$space = true;
			$output .= $EventVenue . ', ';
		}
		if ($EventCity != '') {
			$space = true;
			$output .= $EventCity . ', ';
		}
		
		if ( $EventCountry == "United States" &&  $EventState != '') {
		    $space = true;
			$output .= $EventState;
		} elseif  ( $EventProvince != '' ) {
			$space = true;
			$output .= $EventProvince;
		} else {
			$output = rtrim( $output, ', ' );
		}
		if ( $space ) {
			$output .=  '<br />';
		}
		if ($EventCountry != '') {
			$output .= $EventCountry; 
		}
		echo $output;
		
	?>
	</div>

</li>


<?php $alt_text = ( empty( $alt_text ) ) ? 'alt' : '';
