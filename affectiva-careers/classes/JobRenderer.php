<?php
/**
 * Class for creating a AffectivaJobRenderer object
 *
 * @package      AffectivaCareers
 */

/**
 * Class for getting rendering a list of jobs by certain properties
 */
class AffectivaJobRenderer {
	/**
	 * Creates an instance of AffectivaJobRenderer
	 *
	 * @param array[AffectivaJob] $jobs - a list of jobs.
	 * @param string              $heading - the heading of the job listings.
	 * @param string              $grouping - the key to sort the jobs by.
	 * @param string              $group_class - the class to wrap around each job grouping list.
	 * @param bool                $show_location - whether or not to show the location in the job listing.
	 */
	public function __construct( $jobs, $heading, $grouping, $group_class, $show_location ) {
		$this->grouped_jobs  = $this->group_jobs( $jobs, $grouping );
		$this->jobs          = $jobs;
		$this->heading       = $heading;
		$this->grouping      = $grouping;
		$this->group_class   = $group_class;
		$this->show_location = boolval( $show_location );
	}

	/**
	 * Group the jobs by the grouping key.
	 *
	 * @param array[AffectivaJob] $jobs - list of jobs.
	 * @param string              $grouping - the key of the job to group by.
	 */
	private function group_jobs( $jobs, $grouping ) {
		$grouped_jobs = array();
		foreach ( $jobs as $job ) {
			$category = $job->$grouping;

			$grouped_jobs[ (string) $category ][] = $job;
		}

		ksort( $grouped_jobs );

		return $grouped_jobs;
	}

	/**
	 * Render a job list with heading.
	 */
	public function get_html() {
		$html = '';

		$html .= '<h2 class="careers-list__title">' . $this->heading . '</h2>';

		foreach ( $this->grouped_jobs as $key => $value ) {
			$html .= '<div clas="' . $this->group_class . '">';
			$html .= '<h3>' . $key . '</h3>';

			foreach ( $value as $job ) {
				$html .= '<div class="career-post-item">';
				$html .= '<a href="' . $job->url . '" class="career-link" target="_blank">' . $job->title . '</a>';

				if ( $this->show_location ) {
					$html .= '<span class="career-location">' . $job->location . '</span>';
				}

				$html .= '</div>';
			}

			$html .= '</div>';
		}

		return $html;
	}
}
