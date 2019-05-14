<?php
/**
 * Class for creating a job object
 *
 * @package      AffectivaCareers
 */

/**
 * Class for creating a job object
 */
class AffectivaJob {

	/**
	 * Id of the job
	 *
	 * @var string $id.
	 */
	public $id;

	/**
	 * Constructs an instance of Job
	 *
	 * @param object $job - the job object from XML.
	 */
	public function __construct( $job ) {
		$this->id          = $job->id;
		$this->title       = $job->title;
		$this->status      = $job->status;
		$this->department  = $job->department;
		$this->url         = $job->url;
		$this->description = $job->description;
		$this->location    = $this->get_location_string( (string) $job->city, (string) $job->state, (string) $job->country );
	}

	/**
	 * Get a City, State or City, Country string
	 *
	 * @param string $city - The city.
	 * @param string $state - The state.
	 * @param string $country - The country.
	 */
	private function get_location_string( $city, $state, $country ) {
		$location_separator = ', ';
		// For cases inside of US.
		if ( $state && ! empty( $state ) ) {
			return $city . $location_separator . $state;
		}

		if ( ! $city || empty( $city ) ) {
			return $country;
		}

		// For cases outside of US.
		return $city . $location_separator . $country;
	}
}
