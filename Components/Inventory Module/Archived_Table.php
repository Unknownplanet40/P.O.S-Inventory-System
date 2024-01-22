<!-- Modal -->
<div class="modal fade" id="Archive" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-1 shadow">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Archived Products</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="overflow-y: auto; height: 400px;">
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Catagory</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Action</th>

                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php
                            $sql = "SELECT * FROM pos_products WHERE Achieved = 1";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row['image_path'] == NULL) {
                                        if ($row['category'] == "Liquid") {
                                            $image = "../../assets/Default_Image/Def_Liquid.png";
                                        } elseif ($row['category'] == "Powder") {
                                            $image = "../../assets/Default_Image/Def_Powder.png";
                                        } elseif ($row['category'] == "Basket") {
                                            $image = "../../assets/Default_Image/Def_basket.png";
                                        } else {
                                            $image = "../../assets/Default_Image/Def_Others.png";
                                        }
                                    } else {
                                        $image = "../../assets/Custom_image/" . $row['image_path'];
                                    }
                                    if (strlen($row['product_name']) > 12) {
                                        $prodName = substr($row['product_name'], 0, 12) . "...";
                                    } else {
                                        $prodName = $row['product_name'];
                                    } ?>
                                    <tr>
                                        <td class="text-start"><img src="<?php echo $image; ?>" alt="Product Image" class="rounded-circle m-3" width="25px" height="25px"><span title="<?php echo $row['product_name']; ?>" data-bs-toggle="tooltip" data-bs-placement="left" class="text-truncate"><?php echo $prodName; ?></span></td>
                                        <td class="text-center"><?php echo $row['category']; ?></td>
                                        <td class="text-center"><?php echo $row['price']; ?></td>
                                        <td class="text-center pt-3">
                                            <form method="POST" id="Restore<?php echo $row['id']; ?>">
                                                <input type="hidden" name="prodID" value="<?php echo $row['id']; ?>">
                                                <input type="submit" class="btn btn-outline-success btn-sm m-2" name="Restore" value="Restore">
                                            </form>
                                            <script>
                                                document.getElementById("Restore<?php echo $row['id']; ?>").addEventListener("submit", function(event) {
                                                    event.preventDefault();
                                                    Swal.fire({
                                                        title: 'Are you sure?',
                                                        text: "You want to restore this product?",
                                                        icon: 'warning',
                                                        width: '360px',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#FFA500',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Yes, restore it!'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            //document.getElementById("Restore<?php echo $row['id']; ?>").action = "./RestoreProd.php";
                                                            document.getElementById("Restore<?php echo $row['id']; ?>").submit();
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