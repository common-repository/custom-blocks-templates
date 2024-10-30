<?php

namespace Sirvelia\CBT\Countdown;


add_action( 'plugins_loaded', __NAMESPACE__ . '\register_countdown' );
/**
 * Register the countdown block.
 *
 * @since 1.3.0
 *
 * @return void
 */
function register_countdown() {

	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback
	register_block_type( 'custom-blocks-templates/countdown',
		array(
      'endDate' => array(
        'type' => 'string',
				'default' => ''
      ),
			'render_callback' => __NAMESPACE__ . '\render_countdown',
		)
 	);

}

/**
 * Server rendering for /custom-blocks-templates/countdown
 */
function render_countdown($attributes, $content) {
	$endDate = isset($attributes['endDate']) ? $attributes['endDate'] : '';
	$id = uniqid();
	ob_start();
  ?>
	<!-- Display the countdown timer in an element -->
	<p id="<?=$id?>" class="wp-block-custom-blocks-templates-countdown"></p>

	<script>
	// Set the date we're counting down to
		var countDownDate = new Date('<?= $endDate ?>').getTime();

		// Update the count down every 1 second
		var x = setInterval(function() {
		  var now = new Date().getTime();
		  var distance = countDownDate - now;
		  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

		  // Display the result
		  document.getElementById("<?= $id ?>").innerHTML = days + "d " + hours + "h "
		  + minutes + "m " + seconds + "s ";

		  // Finished Countdown
		  if (distance < 0) {
		    clearInterval(x);
		    document.getElementById("<?= $id ?>").innerHTML = "ZERO!";
		  }
		}, 1000);

	</script>
  <?php
	return ob_get_clean();
}
