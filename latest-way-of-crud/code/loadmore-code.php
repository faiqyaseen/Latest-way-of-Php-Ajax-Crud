<?php

$conn = mysqli_connect("localhost", "root", "", "test1") or die("Connection Failed.!");
if (isset($_POST['searchTerm'])) {
        $search = $_POST['searchTerm'];
        if(isset($_POST['page_no'])){
            $page = $_POST['page_no'];
        }
        else{
            $page = 0;
        }
        $limit = 5;

        $sql = "SELECT * FROM user WHERE name LIKE '%{$search}%' OR age LIKE '%{$search}%'
        OR email LIKE '%{$search}%' OR country LIKE '%{$search}%'
        OR gender LIKE '%{$search}%' LIMIT {$page},{$limit}";
        $result = mysqli_query($conn, $sql) or die("QUERY FAILED.!");
        $output = "";
        if (mysqli_num_rows($result) > 0) {
            $serial = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= "                
                
                    <tr id='{$row['id']}'>
                        <td>{$serial}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['country']}</td>
                        <td>
                            <button class='btn btn-warning' id='edit-modal-btn' data-toggle='modal' data-eid='{$row['id']}'>Edit</button>
                            <button class='btn btn-danger' id='delete-modal-btn' data-did='{$row['id']}' data-toggle='modal'>Delete</button>
                        </td>
                    </tr>
                    ";
                    $serial ++ ;
            }
            $output .= "
                <tr id='load-pagination'>
                    <td colspan='7'>
                        <button class='btn btn-primary' data-id='".  $page + $limit ."' id='load-btn' >Load More</button>
                    </td>
                </tr>
            ";
            echo $output;
        } else {
            // echo "<tr><td colspan='7'>Record Not Found.!</td><tr>";
            echo "";
        }
    }
?>