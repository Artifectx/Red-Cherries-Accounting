<?php

/**
 *  Red Cherries Accounting is a web based accounting software solution 
 *  for Small and Medium Enterprices (SME) to manage financial information. 
 *  Copyright (C) 2020  Artifectx Solutions (Pvt) Ltd
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

class Journal_entry_bulk_upload_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function addJournalEntryBulkUpload($data) {
		$this->db->limit(1);
		$this->db->insert('acm_bookkeeping_journal_entry_bulk_uploads', $data);
		return $this->db->insert_id();
	}

	public function addJournalEntryBulkUploadEntry($data) {
		$this->db->limit(1);
		$this->db->insert('acm_bookkeeping_journal_entry_bulk_upload_entries', $data);
		return true;
	}
    
    public function editJournalEntryBulkUpload($bulkUploadId, $data) {
        $this->db->where('bulk_upload_id', $bulkUploadId);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_journal_entry_bulk_uploads', $data);
	}
    
    public function deleteJournalEntryBulkUpload($id, $status) {
		$this->db->where('bulk_upload_id', $id);
        $this->db->set('last_action_status', $status);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_journal_entry_bulk_uploads');
		return true;
	}
    
    public function getJournalEntryBulkUploadById($id) {
		$this->db->where('bulk_upload_id', $id);
        $this->db->where('acm_bookkeeping_journal_entry_bulk_uploads.last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_journal_entry_bulk_uploads');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllJournalEntryBulkUploads($fromDate, $toDate) {
        
		$this->db->where('date >=', $fromDate);
		$this->db->where('date <=', $toDate);
		$this->db->where('acm_bookkeeping_journal_entry_bulk_uploads.last_action_status !=','deleted');
        
		$query = $this->db->get('acm_bookkeeping_journal_entry_bulk_uploads');
        
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllJournalEntryBulkUploadEntries($bulkUploadId) {
        
		$this->db->where('bulk_upload_id', $bulkUploadId);
		$this->db->where('acm_bookkeeping_journal_entry_bulk_upload_entries.last_action_status !=','deleted');
        
		$query = $this->db->get('acm_bookkeeping_journal_entry_bulk_upload_entries');
        
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
