<?php
class Donations_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('svm_dsm_donation_donations', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	
	public function addDonationDataToHistory($data) {
		$this->db->insert('svm_dsm_donation_donations_history', $data);
		$this->db->limit(1);
	}

	public function edit($id, $data) {
		$this->db->where('donation_id', $id);
		$this->db->update('svm_dsm_donation_donations', $data);
		$this->db->limit(1);
	}

	public function delete($id, $status,$user_id) {
		$this->db->where('donation_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('svm_dsm_donation_donations');
		$this->db->limit(1);
		return true;
	}

	public function getAll($order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->join('svm_dsm_admin_programs', 'svm_dsm_admin_programs.program_id = svm_dsm_donation_donations.program_id','left');
		$this->db->where('svm_dsm_donation_donations.last_action_status !=','deleted');
		$query = $this->db->get('svm_dsm_donation_donations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getDonationsByProgram($order_field, $order_type, $programId) {
		$this->db->order_by($order_field, $order_type);
		$this->db->where('program_id', $programId);
		$this->db->where('svm_dsm_donation_donations.last_action_status !=','deleted');
		$query = $this->db->get('svm_dsm_donation_donations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getById($id) {
		$this->db->join('svm_dsm_admin_programs', 'svm_dsm_admin_programs.program_id = svm_dsm_donation_donations.program_id','left');
		$this->db->where('donation_id', $id);
		$this->db->where('svm_dsm_donation_donations.last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('svm_dsm_donation_donations');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function addDonationJournalEntry($data) {
		$this->db->insert('svm_dsm_donation_donation_journal_entries', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function getDonationJournalEntries($donationId) {
		$this->db->where('donation_id', $donationId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('svm_dsm_donation_donation_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllDonationsDetailForDateRangeProgramAndLocation($fromDate, $toDate, $programId, $locationId) {

		$condition = "SELECT Donor.people_name AS donor_name, Program.program_name, Location.location_name, Donations.reference_no, "
					."Donations.date, Donations.amount "
					."FROM `svm_dsm_donation_donations` AS Donations "
					."LEFT JOIN svm_dsm_admin_programs AS Program ON Donations.program_id = Program.program_id "
					."LEFT JOIN ogm_admin_people AS Donor ON Donations.donor_id = Donor.people_id "
					."LEFT JOIN ogm_admin_locations AS Location ON Program.location_id = Location.location_id "
					."WHERE Donations.last_action_status != 'deleted'";

		if ($fromDate != '' && $toDate != '') {
			$condition .= " AND Donations.date >= '" . $fromDate . "' AND "
						  ."Donations.date <= '" . $toDate . "'";

			if ($programId != '0') {
				$condition .=" AND Program.program_id = '" . $programId . "'";

				if ($locationId != '0') {
					$condition .=" AND Location.location_id = '" . $locationId ."'";
				}
			} else if ($locationId != '0') {
				$condition .=" AND Location.location_id = '" . $locationId ."'";
			}
		} else if ($programId != '0') {
			$condition .=" AND Program.program_id = '" . $programId . "'";

			if ($locationId != '0') {
				$condition .=" AND Location.location_id = '" . $locationId ."'";
			}
		} else if ($locationId != '0') {
			$condition .=" AND Location.location_id = '" . $locationId ."'";
		}
		
	//echo $condition;die;
		$query = $this->db->query($condition);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
}
