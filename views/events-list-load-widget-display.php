<?php /**
 * This is the template for the output of the events list widget. 
 * All the items are turned on and off through the widget admin.
 * There is currently no default styling, which is highly needed.
 * @return string
 */
// let's make time
$start_time		= strtotime(get_post_meta( $post->ID, '_EventStartDate', true ));
$EventPage		= get_post_meta( $post->ID, '_EventPage', true );
$EventVenue		= get_post_meta( $post->ID, '_EventVenue', true );
$EventCity		= get_post_meta( $post->ID, '_EventCity', true );
$EventCountry	= get_post_meta( $post->ID, '_EventCountry', true );
$EventState		= get_post_meta( $post->ID, '_EventState', true );
$EventProvince	= get_post_meta( $post->ID, '_EventProvince', true );
?>

<?php
    /* Display link to all events */
    echo '<div class="dig-in"><a href="' . $event_url . '">' . __('View All Events', $this->pluginDomain ) . '</a></div>';
?>

<li class="<?php echo $alt_text ?>">
	<div class="when">
		<span class="month"><?php echo date_i18n('M', $start_time); ?></span>
		<span class="date"><?php echo date_i18n('j', $start_time); ?></span>
	</div>
	<div class="event"><?php echo $post->post_title ?></div>
	<div class="loc"><?php
		$space = false;
		$output = '';
		if ($page == true && $EventPage != '') {
			$space = true;
			$_page &= get_post($EventPage);
			if($_page) {
			    $output .= $_page->post_name . ', ';
			}
		}
		if ($venue == true && $EventVenue != '') {
			$space = true;
			$output .= $EventVenue . ', ';
		}
		if ($city == true && $EventCity != '') {
			$space = true;
			$output .= $EventCity . ', ';
		}
		if ($state == true || $province == true){
			if ( $EventCountry == "United States" &&  $EventState != '') {
				$space = true;
				$output .= $EventState;
			} elseif  ( $EventProvince != '' ) {
				$space = true;
				$output .= $EventProvince;
			}
		} else {
			$output = rtrim( $output, ', ' );
		}
		if ( $space ) {
			$output .=  '<br />';
		}
		if ($country == true && $EventCountry != '') {
			$output .= $EventCountry; 
		}
		echo $output;
	?>
	</div>
	<a class="more-link" href="<?php echo get_permalink($post->ID) ?>"><?php _e('More Info', $this->pluginDomain); ?></a>
</li>
<?php $alt_text = ( empty( $alt_text ) ) ? 'alt' : '';
