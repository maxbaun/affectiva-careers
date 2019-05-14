<?php
/**
 * Class for creating a jobloader object
 *
 * @package      AffectivaCareers
 */

require 'Job.php';

/**
 * Class for getting the jobs from an XML file
 */
class AffectivaJobLoader {
	/**
	 * Creates an instance of AffectivaJobLoader
	 *
	 * @param string $xml_url - The url that the XML is loaded from.
	 */
	public function __construct( $xml_url ) {
		$this->url = $xml_url;
	}

	/**
	 * Gets a list of jobs from the xml
	 *
	 * @return array[AffectivaJob];
	 */
	public function get_jobs() {
		if ( empty( $this->url ) ) {
			return array();
		}

		$data = simplexml_load_file( $this->url );

		$jobs = array();
		foreach ( $data->job as $job ) {
			$jobs[] = new AffectivaJob( (object) $job );
		}

		return $jobs;
	}
}
