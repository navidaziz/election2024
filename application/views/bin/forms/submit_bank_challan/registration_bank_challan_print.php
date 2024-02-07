<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>PSRA Registration Bank Challan</title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <style type="text/css">
    body {
      background: rgb(204, 204, 204);
      font-family: 'Source Sans Pro', 'Regular' !important;

    }

    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
      width: 21cm;
      /* height: 29.7cm;  */
      height: auto;
    }

    @media print {
      page[size="A4"] {
        width: 90%;
        margin: 0 auto;
        margin-top: 30px;
        /* height: 29.7cm;  */
        height: auto;
      }
    }

    page[size="A4"][layout="landscape"] {
      width: 29.7cm;
      height: 21cm;
    }

    page[size="A3"] {
      width: 29.7cm;
      height: 42cm;
    }

    page[size="A3"][layout="landscape"] {
      width: 42cm;
      height: 29.7cm;
    }

    page[size="A5"] {
      width: 14.8cm;
      height: 21cm;
    }

    page[size="A5"][layout="landscape"] {
      width: 21cm;
      height: 14.8cm;
    }

    @media print {

      body,
      page {
        margin: 0;
        box-shadow: 0;
        color: black;
      }

    }


    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      padding: 3px;
      line-height: 1;
      vertical-align: top;

    }

    .table_reg>tbody>tr>td,
    .table_reg>tbody>tr>th,
    .table_reg>tfoot>tr>td,
    .table_reg>tfoot>tr>th,
    .table_reg>thead>tr>td,
    .table_reg>thead>tr>th {
      padding: 3px;
      line-height: 1.42857143;
      vertical-align: top;
      border-top: 1px solid #ddd;
      text-align: center;
    }
  </style>
  </style>
</head>

<body>
  <page size='A4'>
    <div style="padding: 10px;" style="width: 100%;">
      <table style="width: 100%;">
        <tr>
          <th><img style="width: 100px;" src="<?php echo base_url(); ?>assets/logo.png" class="img-responsive img" /></th>
          <th>
            <h3 style="text-align: center;">Public School Regulatory Authority Khyber Pakhtunkhwa</h4>
              <h4 style="text-align: center;"><?php echo $title;  ?> Challan Form For Session <?php echo $session_detail->sessionYearTitle; ?>
              </h4>


          </th>
        </tr>
      </table>
      <hr />
      <h5 style="text-align: center;">The Bank of Khyber, Civil Secretariat Branch Peshawar (0015) A/C No.
        <b> PLS. 2000883401</b> On Account of: <b>Managing Director Private Schools Regulatory Authority</b>
      </h5>
      <div style="margin: 10px;">
        <table style="width: 100%;">
          <tr>
            <th>Date: _______________</th>
            <th>Receipt No: <span style="text-decoration: underline; ">
                <strong><?php echo $school->schools_id + $school->district_id; ?><strong></span></th>
            <th style="text-align: right;">Reference no:___________________<br />
              (for bank use only)</th>
          </tr>
        </table>
        <div style="border: 1px solid #ddd; border-radius: 10px; margin-top: 5px; margin-bottom: 10px;  padding: 10px;">
          <table class="table">
            <tr>
              <td style="text-align: left;">School ID: <span style="text-decoration: underline; ">
                  <strong><?php echo $school->schools_id; ?><strong></span></td>
              <td style="text-align: center;">
                <?php if ($school->registrationNumber) { ?>
                  Registration ID: <span style="text-decoration: underline; ">
                    <strong><?php echo $school->registrationNumber; ?><strong></span>
                <?php } ?>
              </td>
              <td style="text-align: right;">Session: <span style="text-decoration: underline; ">
                  <strong><?php echo $session_detail->sessionYearTitle; ?><strong></span></td>
            </tr>
          </table>
          <table class="table">
            <tr>
              <td>Institute Name: <span style="text-decoration: underline; ">
                  <strong><?php echo $school->schoolName; ?><strong></span></td>
              <td colspan="2">District: <span style="text-decoration: underline; ">
                  <strong><?php $query = "SELECT `districtTitle` FROM `district` WHERE districtId = '" . $school->district_id . "'";
                          echo $this->db->query($query)->result()[0]->districtTitle; ?></td>
              <td colspan="4">Level of Institute: <span style="text-decoration: underline; ">
                  <strong><?php $query = "SELECT `levelofInstituteTitle` FROM `levelofinstitute` WHERE levelofInstituteId = '" . $school->level_of_school_id . "'";
                          echo $this->db->query($query)->result()[0]->levelofInstituteTitle; ?></td>
            </tr>
          </table>
        </div>

        <?php
        $pecial_fine = 0;
        if ($session_id == 1) { ?>

        <?php
          if ($school->level_of_school_id == 1  or  $school->level_of_school_id == 2) {
            $special_fine = 50000;
          }
          if ($school->level_of_school_id == 3  or  $school->level_of_school_id == 4) {
            $special_fine = 200000;
          }
        }
        $bise_tdr = 0;
        $query = "SELECT * FROM `bise_verification_requests` WHERE school_id = '" . $school->schools_id . "' AND status IN(1,2,0)";
        $bise_verification = $this->db->query($query)->result();
        if ($bise_verification and $bise_verification[0]->status == 1 or $bise_verification[0]->status == 2) {
          $bise_tdr = $bise_verification[0]->tdr_amount;
        } else {
          $bise_tdr = 0;
        }


        ?>

        <table class="table table_reg">
          <tr>
            <th style="width: 150px !important"> Due's Date </th>
            <th>Application Processing Fee</th>
            <th>Inspection Fee</th>
            <th style="width: 120px;"> Late Fee </th>

            <?php
            $query = "SELECT * FROM `levelofinstitute` 
                                WHERE `levelofinstitute`.`levelofInstituteId` = $school->level_of_school_id";
            $level_securities = $this->db->query($query)->result()[0];

            ?>
            <th>Security Fee <br /><small>(<?php echo $level_securities->levelofInstituteTitle; ?>)</small></th>
            <?php if ($session_id == 1) { ?>
              <th>Fine <br /><small>2018-19 Special Fine (<?php echo $level_securities->levelofInstituteTitle; ?>)</small></th>
            <?php } ?>
            <th>Total</th>
          </tr>
          <?php
          $count = 1;

          foreach ($session_fee_submission_dates as $session_fee_submission_date) {
            $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee;
          ?>

            <tr>
              <th>
                Upto <?php echo date('d M, Y', strtotime($session_fee_submission_date->last_date)); ?>
              </th>

              <td><?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?></td>
              <td><?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?></td>

              <td>
                <?php
                $fine = 0;
                $fine = ($session_fee_submission_date->fine_percentage * $total) / 100;
                echo $session_fee_submission_date->fine_percentage . " % - ";
                echo number_format($fine);
                ?>
              </td>
              <!-- <td> -->
              <?php //echo number_format($fine + $total);  
              ?>
              <!-- </td> -->
              <td>
                <?php $security = ($level_securities->security_fee - $bise_tdr);

                echo number_format($security);
                ?>

              </td>
              <?php if ($session_id == 1) { ?>
                <td></td>
              <?php } ?>
              <td>
                <strong>
                  <?php if ($session_id == 1) { ?>
                    <?php
                    echo number_format($fine + $total + $security + $specialfine);
                    ?>

                  <?php } else { ?>

                    <?php echo number_format($fine + $total + $security); ?>
                  <?php } ?>
                </strong>
              </td>

            </tr>



          <?php } ?>
          <?php if ($session_id == 1) { ?>
            <tr>
              <th> After 1 Dec, 2019 </th>
              <td><?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?></td>
              <td><?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?></td>
              <td>

                <?php echo $session_fee_submission_dates['4']->fine_percentage; ?> % -

                <?php
                $fine = 0;
                $fine = ($session_fee_submission_dates['4']->fine_percentage * $total) / 100;
                echo number_format($fine);
                ?>

              </td>

              <td>
                <?php $security = ($level_securities->security_fee - $bise_tdr);

                echo number_format($security);
                ?>

              </td>
              <?php

              $specialfine = 0; ?>

              <td><?php
                  //echo $school->district_id . " - ";
                  $specialfine = $special_fine;
                  echo number_format($special_fine); ?></td>


              <td>
                <strong>

                  <?php
                  // echo "$fine + $total + $security + $specialfine";
                  echo number_format($fine + $total + $security + $specialfine);
                  ?>

                </strong>
              </td>

            </tr>
          <?php } ?>
        </table>


        <br /><br />
        <style>
          .table2 td,
          .table2 th {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid white !important;
          }
        </style>
        <table class="table table2" style="width: 100%; text-align: center;">
          <tr>
            <td style="width: 33%;"><strong>Applicant Signature</strong>
              <hr style="border:1px solid #333;width:100%;  margin-top: 60px;">
            </td>
            <td style="width: 33%;">
              <strong>Cashier</strong>
              <hr style="border:1px solid #333;width:100%;  margin-top: 60px;">
            </td>
            <td style="width: 33%;"><strong> Bank Officer</strong>
              <hr style="border:1px solid #333;width:100%; margin-top: 60px;">
            </td>
          </tr>
        </table>
      </div>
    </div>



  </page>
</body>



</html>