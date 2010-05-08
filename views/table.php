<?php 
global $spEvents; 
$eventPosts = get_events();
$daysInMonth = date("t", $date);
$startOfWeek = get_option( 'start_of_week', 0 );
list( $year, $month ) = split( '-', $spEvents->date );
$date = mktime(12, 0, 0, $month, 1, $year); // 1st day of month as unix stamp
$monthView = events_by_month( $eventPosts, $spEvents->date );
$rawOffset = date("w", $date) - $startOfWeek;
$offset = ( $rawOffset < 0 ) ? $rawOffset + 7 : $rawOffset; // month begins on day x
$rows = 1;
$monthView = events_by_month( $eventPosts, $spEvents->date );
?>
<table class="tec-calendar" id="big">
	<thead>
			<tr>
				<?php
				for( $n = $startOfWeek; $n < count($spEvents->daysOfWeek) + $startOfWeek; $n++ ) {
					$dayOfWeek = ( $n >= 7 ) ? $n - 7 : $n;
					echo '<th id="tec-' . strtolower($spEvents->daysOfWeek[$dayOfWeek]) . '" abbr="' . $spEvents->daysOfWeek[$dayOfWeek] . '">' . $spEvents->daysOfWeekShort[$dayOfWeek] . '</th>';
				}
				?>
			</tr>
	</thead>

	<tbody>
		<tr>
		<?php
			// skip last month
			for( $i = 1; $i <= $offset; $i++ ){ 
				echo "<td class='tec-othermonth'></td>";
			}
			// output this month
			for( $day = 1; $day <= date("t", $date); $day++ ) {
			    if( ($day + $offset - 1) % 7 == 0 && $day != 1) {
			        echo "</tr>\n\t<tr>";
			        $rows++;
			    }
			
				// Var'ng up days, months and years
				$current_day = date_i18n( 'd' );
				$current_month = date_i18n( 'm' );
				$current_year = date_i18n( 'Y' );
				
				if ( $current_month == $month && $current_year == $year) {
					// Past, Present, Future class
					if ($current_day == $day ) {
						$ppf = ' tec-present';
					} elseif ($current_day > $day) {
						$ppf = ' tec-past';
					} elseif ($current_day < $day) {
						$ppf = ' tec-future';
					}
				} elseif ( $current_month > $month && $current_year == $year || $current_year > $year ) {
					$ppf = ' tec-past';
				} elseif ( $current_month < $month && $current_year == $year || $current_year < $year ) {
					$ppf = ' tec-future';
				} else { $ppf = false; }
				
			    echo "<td class='tec-thismonth" . $ppf . "'><div class='daynum'>" . $day . "</div>\n";
				echo display_day( $day, $monthView );
				echo "</td>";
			}
			// skip next month
			while( ($day + $offset) <= $rows * 7)
			{
			    echo "<td class='tec-othermonth'></td>";
			    $day++;
			}
		?>
		</tr>
	</tbody>
</table>
<?php
function display_day( $day, $monthView ) {
	global $post;
	$output = '';
	for( $i = 0; $i < count( $monthView[$day] ); $i++ ) {
		$post = $monthView[$day][$i];
		setup_postdata( $post );
		$eventId	= $post->ID.'-'.$day;
		$start		= the_event_start_date( $post->ID );
		$end		= the_event_end_date( $post->ID );
		$cost		= the_event_cost( $post->ID );
		$address	= the_event_address( $post->ID );
		$city		= the_event_city( $post->ID );
		$state		= the_event_state( $post->ID );
		$province	= the_event_province( $post->ID );
		$country	= the_event_country( $post->ID );
		?>
		<div id='event_<?php echo $eventId; ?>' class="tec-event 
		<?php
		foreach((get_the_category()) as $category) { 
		    echo 'cat_' . $category->cat_name . ' '; 
		} 
		?>
		">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<div id='tooltip_<?php echo $eventId; ?>' class="tec-tooltip" style="display:none;">
				<h5 class="tec-event-title"><?php the_title();?></h5>
				<div class="tec-event-body">
					<?php if ( !the_event_all_day($post->ID) ) : ?>
					<div class="tec-event-date">
						<?php if ( !empty( $start ) )	echo $start; ?>
						<?php if ( !empty( $end )  && $start !== $end )		echo " – " . $end . '<br />'; ?>
					</div>
					<?php endif; ?>
					<?php echo The_Events_Calendar::truncate(the_content(), 30); ?>

				</div>
				<span class="tec-arrow"></span>
			</div>
		</div>
		<?php
		if( $i < count( $monthView[$day] ) - 1 ) { 
			echo "<hr />";
		}
	}
}