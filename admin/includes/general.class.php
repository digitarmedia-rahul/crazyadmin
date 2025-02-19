<?php 

class General {



	var $mysqli;

	function set_connection($mysqli) {

        $this->db =& $mysqli;

    }

	

	function GetUserDetails($aid,$email)
	{
	$sql = "SELECT * FROM `co_admin` WHERE admin_id = '$aid' AND admin_email = '$email'";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}

	}

	function GetNumCat()
	{
	$sql = "SELECT * FROM `apk_numcat` ORDER by catid DESC";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while($row = $query->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}

	}


	function GetCatList()
	{
	$sql = "SELECT * FROM `offer_category` ORDER by cat_id DESC";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while($row = $query->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}

	}
	

	function GetCampList()
	{
	$sql = "SELECT * FROM `campaigns` ORDER by offer_id DESC";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while($row = $query->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}

	}

	function GetPublishers()
	{
	$sql = "SELECT * FROM `publisher`";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while($row = $query->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}

	}

	function ManageAffiliate()
	{
	$sql = "select `publisher`.pub_id,`publisher`.pub_company, `manage_affiliates`.status from publisher LEFT JOIN manage_affiliates ON `publisher`.pub_id = `manage_affiliates`.pub_id where pub_status = 'active'";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while($row = $query->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}

	}
	
	function GetPublisherbyId($id)
	{
	$sql = "SELECT * FROM `publisher` WHERE pub_id = '$id'";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}

	}
	function GetAdvbyId($id)
	{
	$sql = "SELECT * FROM `advertiser` WHERE adv_id = '$id'";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}

	}
	function GetCampaignbyId($cid)
	{
	$sql = "SELECT * FROM `campaigns` WHERE offer_id = '$cid'";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}

	}

	function GetEventbyId($cid)
	{
	$sql = "SELECT * FROM `manage_event` WHERE campaign_id = '$cid' ORDER by manage_event_id ASC";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while($row = $query->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}

	}


	function GetLogs()
	{
	$sql = "SELECT * FROM `wp_logs`";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while($row = $query->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}

	}

	
	
	function GetUsers()
	{
	$sql = "SELECT * FROM `wp_users`";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while($row = $query->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}

	}

	function listAuthor()
	{
	$sql = "SELECT * FROM `wp_users`";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			while($row = $query->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}

	}

	function GetSMSCat($catid)
	{
	$sql = "SELECT * FROM `sms_cat` WHERE id = '$catid'";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row['sms_cat'];
		}

	}

	function GetSMSContent($catid)
	{
	$sql = "SELECT * FROM `sms_txt` WHERE id = '$catid'";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row['sms_txt'];
		}

	}

	function GetOfferName($offrid)
	{
	$sql = "SELECT * FROM `offers` WHERE id = '$offrid'";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}

	}

	function GetDeviceContactlist($deviceid)
	{
	$sql = "select deviceid, count(deviceid) as contact_count from contact_list where deviceid='$deviceid'";
	$query = $this->db->query($sql);
		if ($query->num_rows == 0) {
			return 0;
		} else {
			$row = $query->fetch_assoc();
			return $row;
		}

	}
}

?>