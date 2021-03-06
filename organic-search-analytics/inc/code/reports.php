<?php
	/**
	 *  PHP class for report functions
	 *
	 *  Copyright 2015 PromInc Productions. All Rights Reserved.
	 *
	 *  Licensed under the Apache License, Version 2.0 (the "License");
	 *  you may not use this file except in compliance with the License.
	 *  You may obtain a copy of the License at
	 *
	 *     http://www.apache.org/licenses/LICENSE-2.0
	 *
	 *  Unless required by applicable law or agreed to in writing, software
	 *  distributed under the License is distributed on an "AS IS" BASIS,
	 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 *  See the License for the specific language governing permissions and
	 *  limitations under the License.
	 *
	 *  @author: Brian Prom <prombrian@gmail.com>
	 *  @link:   http://promincproductions.com/blog/brian/
	 */

	class Reports
	{

		/**
		 *  Import array of Bing Search Keywords to database
		 *
		 *  @param $domain     String   Domain name for record
		 *  @param $searchKeywords     Object   Search Keywords Results
		 *
		 *  @returns   Int   Count of records imported
		 */
		public function getSavedReportCategories() {
			$query = "SELECT id, name, description FROM ".MySQL::DB_TABLE_SAVED_REPORT_CATEGORIES;
			if( $reportCategories = $GLOBALS['db']->query($query) ) {
				/* Put categories into an array */
				$categories = array();
				foreach( $reportCategories as $category ) {
					$categories[ $category['id'] ] = array(
						'name' => $category['name'],
						'description' => $category['description']
					);
				}

				return $categories;
			} else {
				return array( 0, 'Uncategorized' );
			}
			
		}


		/**
		 *  Save Report settings to database
		 *
		 *  @param $domain     String   Domain name for record
		 *  @param $name     String   Name of the report
		 *  @param $category     Integer or String   Integer - category ID, String - name of a new category
		 *  @param $params     Array or Object   Parameters that make up the report
		 *
		 *  @returns   bool
		 */
		public function saveReport($domain, $name, $category, $params) {
			/* Handle category */
			if( gettype( $category ) === "string" ) {
				/* New Category */
				$category = self::saveReportCategory("", $category, "", true);
			} elseif(gettype( $category ) === "integer" ) {
				/* Existing Category */
			}

			/* Prepare paramters */
			if( gettype( $params ) === "object" ) {
				$params = get_object_vars( $params );
			}
			$params = serialize($params);

			/* Prepare request */
			$valueString = "NULL, '{$domain}', '{$name}', '{$category}', '{$params}'";

			/* Send Query */
			$saveReport = MySQL::qryDBinsert( MySQL::DB_TABLE_SAVED_REPORTS, $valueString );
			// var_dump( $GLOBALS['db'] );

			/* Return query request status */
			return $saveReport;
		}


		/**
		 *  Save Report Category to database
		 *
		 *  @param $id     Integer   ID of the report category
		 *  @param $name     String   Name of the report category
		 *  @param $new     Bool   Default: false.  If false, overwrite existing category.  If true, create new category.
		 *
		 *  @returns   Integer, Bool(True)   New Categories return integer.  Existing categories return true(bool).
		 */
		public function saveReportCategory($id = NULL, $name, $description, $new = false) {
			if( $new ) {
				/* Format values */
				$valueString = "NULL, '{$name}', '{$description}'";
				/* Send Query */
				$mysqli = MySQL::qryDBinsert( MySQL::DB_TABLE_SAVED_REPORT_CATEGORIES, $valueString, true );
				/* Return new category ID */
				return $mysqli->insert_id;
			} else {
				/* Format values */
				$matchParams = array( 'id' => $id );
				$updateParams = array( 'name' => $name, 'description' => $description );
				/* Send Query */
				$mysqli = MySQL::qryDBupdate( MySQL::DB_TABLE_SAVED_REPORT_CATEGORIES, $matchParams, $updateParams );
				/* Return true */
				return true;
			}
		}


		/**
		 *  Get Saved Report by Id
		 *
		 *  @returns   array
		 */
		public function getSavedReport($id) {
			if( $id ) {
				$query = "SELECT paramaters FROM ".MySQL::DB_TABLE_SAVED_REPORTS." WHERE id = '".$id."'";

				if( $reportParams = $GLOBALS['db']->query($query) ) {
					/* Get result from DB object */
					$parameters = $reportParams->fetch_row();
					/* Unserialize data */
					$parameters = unserialize( $parameters[0] );
					/* Return array */
					return $parameters;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}


		/**
		 *  Get Save Reports by category
		 *
		 *  @returns   array
		 */
		public function getSavedReportsByCategory() {
			/* Declare return array */
			$return = array();

			/* Get Categories */
			$reportCategories = self::getSavedReportCategories();
			/* Add categories to return array */
			$return['categories'] = $reportCategories;

			/* Loop through categories */
			foreach( $reportCategories as $id => $data ) {
				/* Get reports by category */
				$query = "SELECT id, domain, name FROM ".MySQL::DB_TABLE_SAVED_REPORTS." WHERE category = ".$id;

				if( $reports = $GLOBALS['db']->query($query) ) {
					foreach( $reports as $report ) {
						/* Add report to return array listed under category */
						$return['categories'][$id]['reports'][] = $report;
					}
				}
			}
			/* Return values */
			return $return;
		}

	}
?>