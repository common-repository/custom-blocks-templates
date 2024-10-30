<?php

namespace Sirvelia\CBT\CsvTables;


add_action( 'plugins_loaded', __NAMESPACE__ . '\register_csv_tables' );
/**
 * Register the private block.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_csv_tables() {

	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback
	register_block_type( 'custom-blocks-templates/csv-tables',
		array(
			'attributes' => array(
        'fileURL' => array(
          'type' => 'string',
          'default' => ''
        ),
        'fileID' => array(
          'type' => 'number',
          'default' => -1
        ),
        'delimiter' => array(
          'type' => 'string',
          'default' => ','
        ),
        'blockAlignment' => array(
          'type' => 'string'
        ),
      ),
			'render_callback' => __NAMESPACE__ . '\render_csv_tables',
		)
 	);

}

/**
 * Server rendering for /custom-blocks-templates/private-blocks
 */
function render_csv_tables($attributes, $content) {
	$file_id = $attributes['fileID'];
	$delimiter = $attributes['delimiter'];
	ob_start(); ?>

  <?php if(!$delimiter) $delimiter = ',';
	if($file_id && $file_id != -1):
		$file_path = get_attached_file( $file_id );
		if($file_path):
			$rows = array_map(
				function($v) use ($delimiter)  { return str_getcsv($v, $delimiter); },
				file($file_path)
			);

			ob_start();
			if( !wp_script_is('datatables-js') ) wp_enqueue_script( 'datatables-js' );
			if( !wp_style_is('datatables-css') ) wp_enqueue_style( 'datatables-css' );

			$header = array_shift($rows); ?>
			<script>
				(function( $ ) {
					'use strict';

					$(document).ready( function () {
							$('.simple_csv_table').DataTable();
					} );

				})( jQuery );
			</script>
			<table class="simple_csv_table">
				<thead>
      		<tr>
						<?php foreach($header as $th): ?>
							<th><?= esc_html( $th ) ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($rows as $row): ?>
						<tr>
							<?php foreach($row as $column): ?>
								<td><?= esc_html( $column ) ?></td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php return ob_get_clean();
		endif; ?>
		<p><?php _e( 'CSV table not found', 'simple-csv-tables' ); ?></p>;
	<?php endif; ?>

	<?php echo $content;
	return ob_get_clean();
}
