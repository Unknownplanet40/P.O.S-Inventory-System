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
            $perML = $row['perML_order'];

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

            if ($row['Achieved'] != 1) {
                $output[] = array(
                    'id' => (int)$id, // (int) convert sa integer ang string (optional)
                    'product_name' => $product_name,
                    'category' => $category,
                    'price' => (float)$price,
                    'quantity' => (int)$quantity,
                    'ml' => (int)$ml,
                    'perML_order' => (int)$perML,
                    'Current_ML' => (int)$CML,
                    'Total_ML' => (int)$TML,
                    'CurrentStock' => (int)$CurrentStock,
                    'isLowStock' => $isLowStock,
                    'image_path' => $image_path
                );
            }
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
    global $conn;

    $sql = "SELECT * FROM customer_information";
    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) > 0) {

        if (!file_exists('../../dump/Customers.json')) {
            mkdir('../../dump/Customers.json.json', 0777, true);
        }

        $output = array();

        while ($row = mysqli_fetch_assoc($result)) {

            $customer_id = $row['Cust_ID'];
            $first_name = $row['Cust_first_name'];
            $last_name = $row['Cust_last_name'];
            $phone_number = $row['Cust_number'];
            $address = $row['Cust_Address'];

            $output[] = array(
                'customer_id' => (int)$customer_id, // (int) convert sa integer ang string (optional)
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone_number' => $phone_number,
                'address' => $address
            );
        }

        $fp = fopen('../../dump/Customers.json', 'w');
        fwrite($fp, json_encode($output));
        fclose($fp);
    }
}
