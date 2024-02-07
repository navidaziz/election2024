<div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">

    <?php
    $query = "SELECT * FROM polling_stations WHERE polling_station_id = '" . $polling_station_id . "'";
    $polling_staion = $this->db->query($query)->row();


    // $query = "SELECT * FROM candidates";
    // $candidates = $this->db->query($query)->result();
    // foreach ($candidates as $candidate) {

    // }

    ?>

    <h4>Polling Station: <?php echo $polling_staion->polling_station; ?></h4>



    <form method="post" action="<?php echo base_url(); ?>admin/polling_stations/add_election_result">
        <input type="hidden" value="<?php echo $polling_station_id; ?>" name="polling_station_id" />
        <table class="table table-bordered">
            <?php
            $query = "SELECT * FROM candidates";
            $candidates = $this->db->query($query)->result();
            $count = 1;
            foreach ($candidates as $candidate) {
                $vote = 0;
                $query = "SELECT * FROM election_results 
                WHERE polling_station_id = '" . $polling_station_id . "'
                AND candidate_id = '" . $candidate->candidate_id . "'";
                $result = $this->db->query($query)->row();
                if ($result) {
                    $vote = $result->votes;
                }



            ?>
                <tr>
                    <th><?php echo $count++; ?></th>
                    <td><?php echo file_type(base_url("assets/uploads/" . $candidate->symbol), 20, 20); ?></td>
                    <th><?php echo $candidate->name     ?></th>
                    <td><input required type="number" value="<?php echo $vote; ?>" name="candidates[<?php echo $candidate->candidate_id; ?>]" /></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4" style="text-align: center;">
                    <input class="btn btn-success" type="submit" value="Add Result" />
                </td>
            </tr>
        </table>
    </form>


</div>