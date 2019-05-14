<?php
/**
 * A list of Job shortcodes for the AffectivaCareers plugin
 *
 * @package AffectivaCareers
 */

require __DIR__ . '/../classes/JobLoader.php';
require __DIR__ . '/../classes/JobRenderer.php';

/**
 * Renders a list of jobs
 *
 * @param array  $atts - List of shortcode attributes.
 * @param string $content - The content of the shortcode.
 */
function shortcode_cb_affectiva_jobs( $atts, $content ) {
	$data = (object) shortcode_atts(
		array(
			'xml_url' => 'https://app.jazz.co/feeds/export/jobs/Affectiva',
		),
		$atts
	);

	$job_loader = new AffectivaJobLoader( $data->xml_url );
	$jobs       = $job_loader->get_jobs();

	$job_renderer_location   = new AffectivaJobRenderer( $jobs, 'Openings by Location', 'location', 'career-list-location', false );
	$job_renderer_department = new AffectivaJobRenderer( $jobs, 'Openings by Team', 'department', 'career-list-team', true );

	$html_1 = $job_renderer_location->get_html();
	$html_2 = $job_renderer_department->get_html();

	$html = '';

	$html .= '<div class="careers-list">';
	$html .= '<a name="location" id="location"></a>';
	$html .= $html_1;
	$html .= $html_2;
	$html .= '</div>';

	return force_balance_tags( $html );
}

add_shortcode( 'affectiva_jobs', 'shortcode_cb_affectiva_jobs' );
