<?php

function getItem()
{
    // kunin ang global na variable na $conn
    global $conn; // importante kapag wla to sa loob ng function, hindi mahahanap ang $conn

    // kunin ang lahat ng item sa database
    $sql = "SELECT * FROM pos_products";
    // iexecute ang query
    $result = mysqli_query($conn, $sql);

    // kung may laman ang result
    if (mysqli_num_rows($result) > 0) {

        // check kung merong .json sa dump folder
        if (!file_exists('../../dump/products.json')) {
            // delete ang .json
            mkdir('../../dump/products.json', 0777, true);
        }

        // gawin ang result na array
        $output = array();

        // ilagay ang result sa array
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $product_name = $row['product_name'];
            $category = $row['category'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $CML = $row['Current_ML'];
            $TML = $row['Total_ML'];

            if ($row['ml'] == 0) {
                $ml = NULL;
            } else {
                $ml = $row['ml'];
            }

            $CurrentStock = $row['CurrentStock'];
            if ($row['isLowStock'] == 1) {
                $isLowStock = true;
            } else {
                $isLowStock = false;
            }

            if ($row['image_path'] == NULL) {
                if ($category == "Liquid") {
                    $image_path = "../../assets/Default_Image/Def_Liquid.png";
                } elseif ($category == "Powder") {
                    $image_path = "../../assets/Default_Image/Def_Powder.png";
                } elseif ($category == "Basket") {
                    $image_path = "../../assets/Default_Image/Def_basket.png";
                } else {
                    $image_path = "../../assets/Default_Image/Def_Others.png";
                }
            } else {
                $image_path = $row['image_path'];
            }

            $output[] = array(
                'id' => (int)$id, // (int) convert sa integer ang string (optional)
                'product_name' => $product_name,
                'category' => $category,
                'price' => (float)$price,
                'quantity' => (int)$quantity,
                'ml' => (int)$ml,
                'Current_ML' => (int)$CML,
                'Total_ML' => (int)$TML,
                'CurrentStock' => (int)$CurrentStock,
                'isLowStock' => $isLowStock,
                'image_path' => $image_path
            );
        }

        // gumawa ng .json sa dump folder
        $fp = fopen('../../dump/products.json', 'w');
        // ilagay ang output sa .json
        fwrite($fp, json_encode($output));
        // isara ang .json
        fclose($fp);

        // yun lang and I THANK YOU!
    }
}

function getCustomerinfo()
{
}
