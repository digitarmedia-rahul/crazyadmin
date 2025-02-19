<?php

include_once "includes/constants.php";

if (isset($_GET['type'])) {
      date_default_timezone_set("Asia/Kolkata");
      $type = $_GET['type'];
      if ($type == 'user_assign_reports') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=user_assign_reports.csv');
            $rows[0] = array("Num Id", "IRPN Number", "Device ID", "IP", "IRPM Type", "Country", "Operator", "Date Time", "Date", "Lot", "Assign Table", "API Call");
            $i = 1;
            if (isset($_GET['filter_date_start'])) {
                  $fromDate = $_GET['filter_date_start'];
            } else {
                  $fromDate = date('Y-m-d');
            }

            if (isset($_GET['filter_date_end'])) {
                  $toDate = $_GET['filter_date_end'];
            } else {
                  $toDate = date('Y-m-d');
            }
            $sqlq = " DATE(date) BETWEEN DATE('" . $fromDate . "') AND DATE('" . $toDate . "')  ";

            $sql = $mysqli->query("SELECT * FROM `assign_number` WHERE $sqlq ");
            while ($obj = $sql->fetch_assoc()) {

                  $rows[$i] = array($obj['numid'], $obj['assign_num'], $obj['deviceid'], $obj['ip'], $obj['type'], $obj['country'], $obj['isp'], $obj['c_date'], $obj['date'], $obj['lot'], $obj['assign_type'], $obj['api_type']);
                  $i++;
            }
      } elseif ($type == 'device_reports') {

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=device reports.csv');
            $rows[0] = array("Sr No", "Device ID", "Token", "Allow Status", "Country", "Operator", "Total Assign", "Total Conv", "Push Status", "Status", "Date Added", "Push Response");
            $i = 1;
            if (isset($_GET['filter_date_start'])) {
                  $fromDate = $_GET['filter_date_start'];
            } else {
                  $fromDate = date('Y-m-d');
            }

            if (isset($_GET['filter_date_end'])) {
                  $toDate = $_GET['filter_date_end'];
            } else {
                  $toDate = date('Y-m-d');
            }
            $sqlq = " DATE(date_added) BETWEEN DATE('" . $fromDate . "') AND DATE('" . $toDate . "')  ";

            $sql = $mysqli->query("SELECT * FROM `deviceid` WHERE $sqlq ");
            while ($obj = $sql->fetch_assoc()) {

                  $rows[$i] = array($i, $obj['deviceId'], $obj['token_id'], $obj['allow_status'], $obj['country'], $obj['isp'], $obj['no_assgn'], $obj['send'], $obj['push_status'], $obj['status'], $obj['date_added'], $obj['push_response']);
                  $i++;
            }
      } elseif ($type == 'sms_reports') {
            header('Content-Type: text/csv; charset=utf-8');
            $file_name = "SMS Reports -(".date("d:m:Y H:i:s").").csv";
            header('Content-Disposition: attachment; filename='.$file_name);
            $rows[0] = array("Sr No", "Offer ID", "Category ID", "SMS ID", "Assign", "Click", "CR", "Date Added");
            $i = 1;
            if (isset($_GET['filter_date_start'])) {
                  $fromDate = $_GET['filter_date_start'];
            } else {
                  $fromDate = date('Y-m-d');
            }

            if (isset($_GET['filter_date_end'])) {
                  $toDate = $_GET['filter_date_end'];
            } else {
                  $toDate = date('Y-m-d');
            }
            $sqlq = " DATE(st.date_added) BETWEEN DATE('" . $fromDate . "') AND DATE('" . $toDate . "')  ";
            
            $sqlr = "SELECT st.*, sc.sms_cat, o.offer_name FROM `sms_transaction` as st join sms_cat as sc on sc.id=st.catid join offers as o on o.id=st.offerid  WHERE $sqlq ";
            if((!isset($_GET['bydate']) && !empty($_GET)) || (isset($_GET['bydate']) && ($_GET['bydate']==0 || $_GET['bydate']=="on"))){
                  $sqlr = "SELECT sc.sms_cat, o.offer_name, st.offerid, st.catid ,st.smsid, sum(st.assign) as assign, sum(st.click) as click FROM `sms_transaction` as st join sms_cat as sc on sc.id=st.catid join offers as o on o.id=st.offerid WHERE $sqlq group by offerid";
            }
            $sql = $mysqli->query($sqlr);
            while ($obj = $sql->fetch_assoc()) {

                  $rows[$i] = array($i, $obj['offer_name'], $obj['sms_cat'], $obj['smsid'], $obj['assign'], $obj['click'], round($obj['assign'] / $obj['click'], 2), $obj['date_added']);
                  $i++;
            }
      }
}



$file = fopen('php://output', 'w');
foreach ($rows as $fields) {
      fputcsv($file, $fields);
}
fclose($file);
