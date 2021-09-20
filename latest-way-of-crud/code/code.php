<?php
    $conn = mysqli_connect("localhost", "root", "", "test1") or die("Connection Failed.!");


    // SELECT AND PAGINATION
    if (isset($_POST['sid'])) {

        $limit_per_page = 5;
        $page = "";
        if (isset($_POST['page_no'])) {
            $page = $_POST['page_no'];
        } else {
            $page = 1;
        }

        $offset = ($page - 1) * $limit_per_page;

        $sql = "SELECT * FROM user ORDER BY id DESC LIMIT {$offset},{$limit_per_page}";
        $result = mysqli_query($conn, $sql);
        $output = '
            
            ';
        if (mysqli_num_rows($result) > 0) {
            $serial = $offset + 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= "
                    <tr id='{$row['id']}' >
                        <td>{$serial}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['country']}</td>
                        <td>
                            <button class='btn btn-warning' data-activepage='{$page}' id='edit-modal-btn' data-toggle='modal' data-eid='{$row['id']}'>Edit</button>
                            <button class='btn btn-danger' data-activepage='{$page}' id='delete-modal-btn' data-toggle='modal' data-did='{$row['id']}'>Delete</button>
                        </td>
                    </tr>
                    
                    ";
                    $serial ++ ;
            }
            $output .= "
                ";

            $sql_total = "SELECT * FROM user";
            $records = mysqli_query($conn, $sql_total);
            $total_record = mysqli_num_rows($records);
            $total_page = ceil($total_record / $limit_per_page);


            if ($page <= 1) {
                $prev_disable = "disabled";
            } else {
                $prev_disable = "";
            }
            $output .= "
                
                <tr><td colspan='7'>
                <ul class='pagination'>
                <li class='page-item {$prev_disable}'>
                    <a class='page-link' href='' id='" . ($page - 1) . "'tabindex='-1' aria-disabled='true'>Previous</a>
                </li>";
            for ($i = 1; $i <= $total_page; $i++) {
                if ($i == $page) {
                    $active = "active";
                } else {
                    $active = "";
                }
                $output .= "
                    <li class='page-item $active' aria-current='page'>
                    <a class='page-link' id='{$i}' href=''>{$i}</a>
                    </li>";
            }

            if ($page == $total_page) {
                $next_disable = "disabled";
            } else {
                $next_disable = "";
            }
            $output .= "
                <li class='page-item $next_disable'>
                    <a class='page-link' href='' id='" . ($page + 1) . "'>Next</a>
                </li>
                </ul>
                </tr></td>
                ";
            echo $output;
        } else {

            $page = $page - 1;
            $offset = ($page - 1) * $limit_per_page;

            $sql = "SELECT * FROM user ORDER BY id DESC LIMIT {$offset},{$limit_per_page}";
            $result = mysqli_query($conn, $sql);
            $output = '
            <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Id</td>
                    <td>Name</td>
                    <td>age</td>
                    <td>email</td>
                    <td>gender</td>
                    <td>country</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
            ';
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $output .= "
                    <tr id='{$row['id']}' >
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['country']}</td>
                        <td>
                            <button class='btn btn-warning' id='edit-modal-btn' data-toggle='modal' data-eid='{$row['id']}'>Edit</button>
                            <button class='btn btn-danger' data-activepage='{$page}' id='delete-modal-btn' data-toggle='modal' data-did='{$row['id']}'>Delete</button>
                        </td>
                    </tr>
                    ";
                }
                $output .= "
                </tbody>
                    </table>";

                $sql_total = "SELECT * FROM user";
                $records = mysqli_query($conn, $sql_total);
                $total_record = mysqli_num_rows($records);
                $total_page = ceil($total_record / $limit_per_page);


                if ($page <= 1) {
                    $prev_disable = "disabled";
                } else {
                    $prev_disable = "";
                }
                $output .= "
                <nav>
                <ul class='pagination'>
                <li class='page-item {$prev_disable}'>
                    <a class='page-link' href='' id='" . ($page - 1) . "'tabindex='-1' aria-disabled='true'>Previous</a>
                </li>";
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($i == $page) {
                        $active = "active";
                    } else {
                        $active = "";
                    }
                    $output .= "
                    <li class='page-item $active' aria-current='page'>
                    <a class='page-link' id='{$i}' href=''>{$i}</a>
                    </li>";
                }

                if ($page == $total_page) {
                    $next_disable = "disabled";
                } else {
                    $next_disable = "";
                }
                $output .= "
                <li class='page-item $next_disable'>
                    <a class='page-link' href='' id='" . ($page + 1) . "'>Next</a>
                </li>
                </ul>
            </nav>
                ";
                echo $output;
            } else {
                echo "<tr><td colspan='7'>Record Not Found.!</td><tr>";
            }
        }
    }
    // END SELECT AND PAGINATION


    // ADD USER
    if (isset($_POST['user_name'])) {
        $user_name = $_POST['user_name'];
        $user_age = $_POST['user_age'];
        $user_email = $_POST['user_email'];
        $user_country = $_POST['user_country'];
        $user_gender = $_POST['user_gender'];

        $sql = "INSERT INTO user(name, age, email, country, gender)  VALUES('{$user_name}',{$user_age},'{$user_email}','{$user_country}','{$user_gender}')";
        if (mysqli_query($conn, $sql)) {
            echo '
                <div id="inner-message" class="alert alert-error alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Your Data Submitted Successfuly.!
            </div>
                ';
        } else {
            echo '
                <div id="inner-message" class="alert alert-error alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Can;t Submitted.!
            </div>
                ';
        }
    }
    // END ADD USER


    // LIVE SEARCH USER
    if (isset($_POST['searchTerm'])) {
        $search = $_POST['searchTerm'];

        $sql = "SELECT * FROM user WHERE name LIKE '%{$search}%' OR age LIKE '%{$search}%'
        OR email LIKE '%{$search}%' OR country LIKE '%{$search}%'
        OR gender LIKE '%{$search}%'";
        $result = mysqli_query($conn, $sql) or die("QUERY FAILED.!");
        $output = "";
        if (mysqli_num_rows($result) > 0) {
            $serial = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= "
                    <tr id='{$row['id']}'>
                        <td>{$row['id']}</td>
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
            echo $output;
        } else {
            // echo "<tr><td colspan='7'>Record Not Found.!</td><tr>";
            echo "";
        }
    }
    // END LIVE SEARCH USER


    // DELETE USER
    if (isset($_POST['del_id'])) {
        $del_id = $_POST['del_id'];

        $sql = "DELETE FROM user WHERE id = {$del_id}";
        if (mysqli_query($conn, $sql)) {
            echo '
                <div id="inner-message" class="alert alert-error alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                User Deleted Successfuly.!
            </div>
                ';
        } else {
            echo '
                <div id="inner-message" class="alert alert-error alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Can\'t Delete.!
            </div>
                ';
        }
    }
    // END DELETE USER


    // LOAD UPDATE USER
    if(isset($_POST['loadEdit'])){
        $load_edit_id = $_POST['loadEdit'];

        $sql = "SELECT * FROM user WHERE id = $load_edit_id";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                if($row['gender'] == "Male"){
                    $malecheck = "checked";
                    $femalecheck = "";
                }else{
                    $malecheck = "";
                    $femalecheck = "checked";
                }

                if($row['country'] == "Pakistan"){

                    $pakistan_select = "selected";
                    $india_select = "";
                    $bangladesh_select = "";
                    $sirilanka_select = "";

                }elseif($row['country'] == "India"){

                    $pakistan_select = "";
                    $india_select = "selected";
                    $bangladesh_select = "";
                    $sirilanka_select = "";

                }elseif($row['country'] == "Bangladesh"){

                    $pakistan_select = "";
                    $india_select = "";
                    $bangladesh_select = "selected";
                    $sirilanka_select = "";

                }elseif($row['country'] == "Sirilanka"){

                    $pakistan_select = "";
                    $india_select = "";
                    $bangladesh_select = "";
                    $sirilanka_select = "selected";
                }

                echo "
                <div class='form-group'>
                <input type='hidden' value='{$row['id']}' id='edituserid'>
                <label>Name:</label>
                <input type='text' value='{$row['name']}' id='editusername' class='form-control'>
            </div>
            <div class='form-group'>
                <label>Age:</label>
                <input type='number' value='{$row['age']}' id='edituserage' class='form-control'>
            </div>
            <div class='form-group'>
                <label>Email:</label>
                <input type='email' value='{$row['email']}' id='edituseremail' class='form-control'>
            </div>
            <div class='form-group'>
                <input type='radio' value='Male' name='gender' {$malecheck} id='editusergender'> Male
                <input type='radio' value='Female' name='gender' {$femalecheck} id='editusergender'> Female
            </div>
            <div class='form-group'>
                <label >Country:</label>
                <select id='editusercountry' class='form-control'>
                    <option $pakistan_select value='Pakistan'>Pakistan</option>
                    <option $india_select value='India'>India</option>
                    <option $bangladesh_select value='Bangladesh'>Bangladesh</option>
                    <option $sirilanka_select value='Sirilanka'>Sirilanka</option>
                </select>
            </div>
                ";
            }
        }
        else{
            echo "No Record Found";
        }
    }
    // END LOAD UPDATE USER


    // UPDATE USER
    if(isset($_POST['edit_user_name'])){
        $user_id = $_POST['edit_user_id'];
        $user_name = $_POST['edit_user_name'];
        $user_age = $_POST['edit_user_age'];
        $user_email = $_POST['edit_user_email'];
        $user_gender = $_POST['edit_user_gender'];
        $user_country = $_POST['edit_user_country'];

        $sql = "UPDATE user SET name = '{$user_name}', age = {$user_age}, email = '{$user_email}',
        gender = '{$user_gender}', country = '{$user_country}' WHERE id = {$user_id} ";

        if(mysqli_query($conn,$sql)){
            echo '
            <div id="inner-message" class="alert alert-error alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                User Updated Successfuly.!
            </div>
            ';
        }else{
            echo '
            <div id="inner-message" class="alert alert-error alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Can\'t Updated.!
            </div>
            ';
        }
    }
    // END UPDATE USER
