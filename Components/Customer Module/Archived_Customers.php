<!-- Modal -->
<div class="modal fade" id="ArchiveCustomer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-1 shadow">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Customers</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="overflow-y: auto; height: 400px;">
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">Name
                                <th class="text-center">Contact</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Action</th>

                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php
                            $sql = "SELECT * FROM customer_information WHERE Archived = 1";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $custID = $row['Cust_ID'];
                                    if (strlen($row['Cust_Address']) > 30) {
                                        $prodName = substr($row['Cust_Address'], 0, 30) . "...";
                                    } else {
                                        $prodName = $row['Cust_Address'];
                                    } ?>
                                    <tr>
                                        <td class="text-start"><?php echo $row['Cust_first_name']; ?> <?php echo $row['Cust_last_name']; ?></td>
                                        <td class="text-center"><?php echo $row['Cust_number']; ?></td>
                                        <td class="text-center"><?php echo $prodName; ?></td>
                                        <td class="text-center pt-3">
                                            <form method="POST" id="Restore<?php echo $row['Cust_ID']; ?>">
                                                <input type="hidden" name="prodID" value="<?php echo $row['Cust_ID']; ?>">
                                                <input type="submit" class="btn btn-outline-success btn-sm m-2" name="Restore" value="Restore">
                                            </form>
                                            <script>
                                                document.getElementById("Restore<?php echo $row['Cust_ID']; ?>").addEventListener("submit", function(event) {
                                                    event.preventDefault();
                                                    Swal.fire({
                                                        title: 'Are you sure?',
                                                        text: "You want to restore this",
                                                        icon: 'warning',
                                                        width: '360px',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#FFA500',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Yes, restore it!'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            document.getElementById("Restore<?php echo $row['Cust_ID']; ?>").action = "./RestoreCustomer.php";
                                                            document.getElementById("Restore<?php echo $row['Cust_ID']; ?>").submit();
                                                        }
                                                    })
                                                });
                                            </script>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center">No Archived Products</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>