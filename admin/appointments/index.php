<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Appointments</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <!-- Date range filter -->
            <div class="form-group">
                <label for="date-filter">Filter by Date:</label>
                <input type="date" class="form-control" id="date-filter">
            </div>

            <table id="appointment-table" class="table table-hover table-striped table-bordered">
                <colgroup>
                    <col width="5%">
                    <col width="20%">
                    <col width="20%">
                    <col width="25%">
                    <col width="20%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Created</th>
                        <th>Code</th>
                        <th>Owner</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT * FROM `appointment_list` ORDER BY unix_timestamp(`date_created`) DESC ");
                        while($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td class=""><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                            <td><?php echo $row['code'] ?></td>
                            <td class=""><p class="truncate-1"><?php echo ucwords($row['owner_name']) ?></p></td>
                            <td class="text-center">
                                <?php 
                                    switch ($row['status']){
                                        case 0:
                                            echo '<span class="rounded-pill badge badge-primary">Pending</span>';
                                            break;
                                        case 1:
                                            echo '<span class="rounded-pill badge badge-success">Confirmed</span>';
                                            break;
                                        case 3:
                                            echo '<span class="rounded-pill badge badge-danger">Cancelled</span>';
                                            break;
                                    }
                                ?>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="./?page=appointments/view_details&id=<?php echo $row['id'] ?>" data-id=""><span class="fa fa-window-restore text-gray"></span> View</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    // Initialize the dataTable
    var table = $('#appointment-table').DataTable({
        columnDefs: [
            { orderable: false, targets: 5 }
        ]
    });

    // Date filter change event
    $('#date-filter').on('change', function() {
        var selectedDate = $(this).val();
        table.draw();
    });

    // Custom filtering function
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var selectedDate = $('#date-filter').val();
        var rowDate = data[1]; // Assuming the date is in the second column
        if (selectedDate === '' || rowDate === selectedDate) {
            return true;
        }
        return false;
    });
});

function delete_appointment($id) {
    $.ajax({
        url: _base_url_ + "classes/Master.php?f=delete_appointment",
        method: "POST",
        data: {id: $id},
        dataType: "json",
        error: function(err) {
            console.log(err);
            alert_toast("An error occurred.", 'error');
        },
        success: function(resp) {
            if (typeof resp == 'object' && resp.status == 'success') {
                location.reload();
            } else {
                alert_toast("An error occurred.", 'error');
            }
        }
    });
}
</script>
