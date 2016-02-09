<?php
/**
 * Open Source Social Network
 *
 * @package   (Informatikon.com).ossn
 * @author    OSSN Core Team <info@opensource-socialnetwork.org>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
class OptionTrips extends OssnDatabase {
	   	/**
		 * Recupera de la bdd les lat i long dels viatges de l'usari
		 *
		 * @params $from: User 1 guid
		 *         $to User 2 guid
		 *
		 * @return bool
		 */
		public function getMapTrips() {
			
			if(empty($this->entity_guid)) {
						return false;
				}
				$params           = array();
				$params['from']   = 'ossn_trips t';
				$params['params'] = array(
						't.title',
						't.description',
						't.latitude',
						't.longitude'
						
				);
				$params['wheres'] = array(
						"e.guid ='{$this->entity_guid}'"
				);
				
				$data = $this->select($params);
				if($data) {
						$entity = arrayObject($data, get_class($this));
						return $entity;
				}	
				 			
		}
		
}
