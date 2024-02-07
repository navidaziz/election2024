<link rel="stylesheet" href="<?php echo site_url("assets/datatables"); ?>/jquery.dataTables.css" />
<script src="<?php echo site_url("assets/datatables"); ?>/jquery.dataTables.js"></script>
<script src="<?php echo site_url("assets/datatables"); ?>/dataTables.buttons.min.js"></script>
<script src="<?php echo site_url("assets/datatables"); ?>/jszip.min.js"></script>
<script src="<?php echo site_url("assets/datatables"); ?>/pdfmake.min.js"></script>
<script src="<?php echo site_url("assets/datatables"); ?>/vfs_fonts.js"></script>
<script src="<?php echo site_url("assets/datatables"); ?>/buttons.html5.min.js"></script>
<script src="<?php echo site_url("assets/datatables"); ?>/buttons.print.min.js"></script>

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
                    <div class="col-md-12">
                        <div class="block_div" id="new_registration_list">
                            <h4>Election Result List</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="summary_report">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>District</th>
                                            <th>Polling Station</th>
                                            <?php foreach ($candidates as $candidate) { ?>
                                                <th><?php echo $candidate->name     ?></th>
                                            <?php } ?>
                                            <th>Update Results</th>
                                        </tr>

                                    </thead>
                                    <?php
                                    $count = 1;
                                    foreach ($polling_stations as $polling_station) { ?>
                                        <tr>
                                            <th><?php echo $count++; ?></th>
                                            <th><?php echo $polling_station->district ?></th>
                                            <th><?php echo $polling_station->polling_station ?></th>
                                            <?php foreach ($candidates as $candidate) { ?>
                                                <td style="text-align: center;"><?php
                                                                                $query = "SELECT votes FROM election_results 
                                                        WHERE polling_station_id = '" . $polling_station->polling_station_id . "'
                                                        AND candidate_id = '" . $candidate->candidate_id . "'";
                                                                                $vote_result = $this->db->query($query)->row();
                                                                                if ($vote_result) {
                                                                                    echo $vote_result->votes;
                                                                                }
                                                                                ?></td>
                                            <?php } ?>
                                            <td>
                                                <?php
                                                $query = "SELECT COUNT(*) as total FROM  election_results 
                                            WHERE polling_station_id = '" . $polling_station->polling_station_id . "'";
                                                $total = $this->db->query($query)->row()->total;
                                                ?>
                                                <?php if ($total > 0) { ?>
                                                    <button onclick="update_result('<?php echo $polling_station->polling_station_id; ?>')" class="btn btn-success btn-sm">Update Result</button>
                                                <?php } else { ?>
                                                    <button onclick="update_result('<?php echo $polling_station->polling_station_id; ?>')" class="btn btn-danger btn-sm">Add Result</button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>


            </section>
        </div>

        <script>
            function update_result(polling_station_id) {
                $.ajax({
                        method: "POST",
                        url: "<?php echo site_url('admin/polling_stations/add_result_form'); ?>",
                        data: {
                            polling_station_id: polling_station_id
                        },
                    })
                    .done(function(respose) {
                        $('#modal').modal('show');
                        $('#modal_title').html("Update Vote Results");
                        $('#modal_body').html(respose);
                    });
            }
        </script>

        <script>
            $(document).ready(function() {
                $('#summary_report').DataTable({
                    dom: 'Bfrtip',
                    paging: false,
                    title: 'Record Room Summary Report',
                    "order": [],
                    searching: true,
                    buttons: [

                        {
                            extend: 'print',
                            title: 'Record Room Summary Report',
                        },
                        {
                            extend: 'excelHtml5',
                            title: 'Record Room Summary Report',

                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Record Room Summary Report',
                            pageSize: 'A4',

                        }
                    ]
                });
            });
            $(document).ready(function() {
                $('#missing_file_number').DataTable({
                    dom: 'Bfrtip',
                    paging: false,
                    title: 'Record Room Missing File',
                    "order": [],
                    searching: true,
                    buttons: [

                        {
                            extend: 'print',
                            title: 'Record Room Missing File',

                        },
                        {
                            extend: 'excelHtml5',
                            title: 'Record Room Missing File',

                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Record Room Missing File',
                            pageSize: 'A4',

                        }
                    ]
                });
            });
            $(document).ready(function() {
                $('#table_new_registration').DataTable({
                    dom: 'Bfrtip',
                    paging: false,
                    title: 'New Registration Cases',
                    "order": [],
                    searching: true,
                    buttons: [

                        {
                            extend: 'print',
                            title: 'New Registration Cases',

                        },
                        {
                            extend: 'excelHtml5',
                            title: 'New Registration Cases',

                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'New Registration Cases',
                            pageSize: 'A4',
                        }
                    ]
                });
            });
        </script>