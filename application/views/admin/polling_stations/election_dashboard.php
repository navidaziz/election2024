<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title" style="display: inline;"></h4>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body">
                ...
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Content Wrapper. Contains page content -->
<script>
    $(document).ready(function() {
        //skin-blue sidebar-mini
        $(".skin-blue").addClass("sidebar-collapse");
    });
</script>
<style>
    .table {
        background-color: transparent !important;
        margin: 2px;
        width: 99%;
        padding: 0px;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        line-height: 1;
        vertical-align: top;
        border-top: 1px solid #ddd;
        background-color: transparent !important;
    }
</style>
<style>
    .block_div {
        border: 1px solid #9FC8E8;
        border-radius: 10px;
        min-height: 3px;
        margin: 3px;
        padding: 10px;
        background-color: white;
    }
</style>

<?php

$query = "SELECT * FROM polling_stations";
$polling_stations = $this->db->query($query)->result();

$query = "SELECT * FROM candidates";
$candidates = $this->db->query($query)->result();

?>


<div class="content-wrapper">

    <section class="content" style="background-image:url(img/fairview-hospital-hero.jpg); background-repeat:no-repeat; min-height:500px;">

        <!-- Small boxes (Stat box) -->
        <div class="row">


            <section class="content" style="padding-top: 0px !important;">


                <div class="row">
                    <div class="col-md-4">
                        <div class="block_div">
                            <h4><strong><?php echo $system_global_settings[0]->system_title ?></strong></h4>
                            <h4>Top Candidates List</h4>
                            <h5 style="text-align: center; color:red">غیر حتمی ۔ غیر سرکاری نتائج</h5>
                            <table class="table ">
                                <tr>
                                    <th>#</th>
                                    <th>Symbol</th>
                                    <th>Image</th>
                                    <th>Candidate</th>
                                    <th style="text-align: center;">Total Votes</th>
                                </tr>
                                <?php
                                $query = "SELECT c.`name`, c.`symbol`, c.`image`, SUM(votes) as total 
                                          FROM `election_results` as r 
                                          INNER JOIN candidates as c ON(c.candidate_id = r.candidate_id) 
                                          GROUP BY `r`.`candidate_id` ORDER BY total DESC;";
                                $candidates = $this->db->query($query)->result();
                                $count = 1;
                                foreach ($candidates as $candidate) { ?>
                                    <tr>
                                        <th><?php echo $count++; ?></th>
                                        <td><?php echo file_type(base_url("assets/uploads/" . $candidate->symbol), 20, 20); ?></td>
                                        <td><?php echo file_type(base_url("assets/uploads/" . $candidate->image), 20, 20); ?></td>

                                        <th><?php echo $candidate->name; ?></th>
                                        <th style="text-align: center;"><?php echo $candidate->total; ?></th>
                                    </tr>
                                <?php } ?>

                            </table>
                            <br />
                            <div style="text-align: center;">

                                <?php
                                $query = "SELECT COUNT(*) as total FROM polling_stations";
                                $total_polling_stations = $this->db->query($query)->row()->total;
                                ?>

                                <strong>Total Polling Stations: <?php echo $total_polling_stations; ?></strong>
                                <?php
                                $query = "SELECT  COUNT( DISTINCT r.polling_station_id) as total
                                    FROM `election_results` as r 
                                    INNER JOIN polling_stations as s ON(s.polling_station_id = r.polling_station_id)
                                    HAVING total > 0 ;";
                                if ($this->db->query($query)->row()) {
                                    $result_added = $this->db->query($query)->row()->total;
                                } else {
                                    $result_added = 0;
                                }
                                ?>
                                <h5>Total Result Received: <?php echo $result_added; ?></h5>


                                <?php
                                $percentage = 0;
                                if ($total_polling_stations > 0) {
                                    $percentage = round(($result_added * 100) / $total_polling_stations, 2);
                                } ?>

                                <div class="progress" style="height: 20px !important;">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $percentage; ?>%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage; ?>%</div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <?php
                                        $query = "SELECT COUNT(*) as total FROM polling_stations
                                            WHERE district = 'Chitral Upper'";
                                        $total_polling_stations = $this->db->query($query)->row()->total;
                                        ?>
                                        <h6>Upper Chitral - Total PS: <strong><?php echo $total_polling_stations; ?></strong></h6>
                                        <?php
                                        $query = "SELECT  COUNT( DISTINCT r.polling_station_id) as total
                                                FROM `election_results` as r 
                                                INNER JOIN polling_stations as s ON(s.polling_station_id = r.polling_station_id)
                                                WHERE  s.district = 'Chitral Upper'
                                                HAVING total > 0 ;";
                                        if ($this->db->query($query)->row()) {
                                            $result_added = $this->db->query($query)->row()->total;
                                        } else {
                                            $result_added = 0;
                                        }
                                        ?>
                                        <h6>Result Received: <strong><?php echo $result_added; ?></strong> </h6>

                                        <?php
                                        $percentage = 0;
                                        if ($total_polling_stations > 0) {
                                            $percentage = round(($result_added * 100) / $total_polling_stations, 2);
                                        } ?>

                                        <div class="progress" style="height: 20px !important;">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo $percentage; ?>%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage; ?>%</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <?php
                                        $query = "SELECT COUNT(*) as total FROM polling_stations
                                            WHERE district = 'Chitral Lower'";
                                        $total_polling_stations = $this->db->query($query)->row()->total;
                                        ?>
                                        <h6>Lower Chitral - Total PS: <strong><?php echo $total_polling_stations; ?></strong></h6>
                                        <?php
                                        $query = "SELECT  COUNT( DISTINCT r.polling_station_id) as total
                                                FROM `election_results` as r 
                                                INNER JOIN polling_stations as s ON(s.polling_station_id = r.polling_station_id)
                                                WHERE  s.district = 'Chitral Lower'
                                                HAVING total > 0 ;";
                                        if ($this->db->query($query)->row()) {
                                            $result_added = $this->db->query($query)->row()->total;
                                        } else {
                                            $result_added = 0;
                                        }
                                        ?>
                                        <h6>Result Received: <strong><?php echo $result_added; ?></strong> </h6>

                                        <?php
                                        $percentage = 0;
                                        if ($total_polling_stations > 0) {
                                            $percentage = round(($result_added * 100) / $total_polling_stations, 2);
                                        } ?>

                                        <div class="progress" style="height: 20px !important;">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo $percentage; ?>%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage; ?>%</div>
                                        </div>
                                    </div>

                                </div>

                                <p style="text-align: center;">
                                    Design and Developed By <strong> <i>Navid Aziz</i></strong> # 0324 4424414
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="block_div">
                            <h4>Polling Station Wise Result Updates</h4>
                            <marquee onmouseover="this.stop();" onmouseout="this.start();" direction="up" style="height: 661px;">
                                <div class="list-group">
                                    <?php
                                    $query = "SELECT s.polling_station, s.polling_station_id, 
                                SUM(r.votes) as total,
                                r.last_update
                                          FROM `election_results` as r 
                                          INNER JOIN polling_stations as s ON(s.polling_station_id = r.polling_station_id)
                                          GROUP BY `r`.`polling_station_id`
                                          
                                          HAVING total > 0 
                                          ORDER BY r.last_update DESC
                                          ;";
                                    $polling_stations = $this->db->query($query)->result();
                                    $count = 1;
                                    foreach ($polling_stations as $polling_station) { ?>



                                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start ">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1 pull-left"><strong><?php echo $polling_station->polling_station; ?></strong></h5>
                                                <small class="pull-right">Last Update: <?php echo date("h:m:s a", strtotime($polling_station->last_update)); ?></small>
                                            </div>
                                            <p class="mb-1">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <?php
                                                        $query = "SELECT c.`name`, c.`symbol`, c.`image`, SUM(votes) as total 
                                                            FROM `election_results` as r 
                                                            INNER JOIN candidates as c ON(c.candidate_id = r.candidate_id) 
                                                            WHERE r.polling_station_id = '" . $polling_station->polling_station_id . "'
                                                            GROUP BY `r`.`candidate_id` 
                                                            ORDER BY total DESC;";
                                                        $candidates = $this->db->query($query)->result();
                                                        $count = 1;
                                                        foreach ($candidates as $candidate) { ?>

                                                            <td style="text-align: center;">
                                                                <img style="width: 20px;" height="20px" src="<?php echo base_url("assets/uploads/" . $candidate->symbol); ?>" class="rounded" alt="Cinque Terre">
                                                                <br />

                                                                <small style="font-size: 8px;"><?php echo $candidate->name; ?> </small>
                                                                <br />
                                                                <strong style="font-size: 16px;"><?php echo $candidate->total; ?></strong>
                                                            </td>

                                                        <?php } ?>
                                                    </tr>
                                                </table>
                                            </p>
                                        </a>




                                    <?php } ?>
                            </marquee>
                            </ul>
                        </div>

                    </div>
                </div>


            </section>
        </div>
        <script>
            function refreshPage() {
                location.reload();
            }

            // Set interval to call the refreshPage function every 10 seconds (10000 milliseconds)
            setInterval(refreshPage, 60000);
        </script>