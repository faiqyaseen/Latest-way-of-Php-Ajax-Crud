<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">
        <div class="row mt-5">

            <!-- SEARCH INPUT  -->
            <div class="col-md-6">
                <div class="col-md-6">
                    <input type="text" placeholder="Search" id="search-data" class="form-control">
                </div>
            </div>


            <!-- ADD DATA BUTTON -->
            <div class="col-md-6 d-flex justify-content-end">
                <div class="col-md-6">
                    <button class="btn btn-primary" id="message-hide" data-bs-toggle="modal">Add Data</button>
                </div>
            </div>

            <!-- ADD MODAL  -->
            <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form id="form-data">
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" id="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Age:</label>
                                    <input type="number" id="userage" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" id="useremail" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="radio" value="Male" name="gender" id="usergender"> Male
                                    <input type="radio" value="Female" name="gender" id="usergender"> Female
                                </div>
                                <div class="form-group">
                                    <label for="">Country:</label>
                                    <select id="usercountry" class="form-control">
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="India">India</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Sirilanka">Sirilanka</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="add-data">Add Data</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END ADD MODAL  -->

            <!-- DELETE MODEL -->
            <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <input type="hidden">
                            <h3>Are You Really Want To Delete This Record?</h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn btn-primary" id="delete-user">Yes Delete It</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END DELETE MODEL -->

            <!-- EDIT MODAL  -->
            <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form id="form-edit-data">

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="edit-data">Update User</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END EDIT MODAL  -->

            <!-- MESSAGE BOX -->
            <div id="message">
                <!-- <div id="inner-message" class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                test error message
                            </div> -->
            </div>
            <!-- END MESSAGE BOX -->
        </div>

        <!-- USER TABLE -->
        <div class="row mt-2">
            <div class="col-md-12">
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
                    <tbody id="table-data">

                    </tbody>

                </table>
            </div>
        </div>
        <!-- END USER TABLE -->
    </div>



    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap.esm.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    <script>
        $(document).ready(function() {

            // HIDE MESSAGE BOX AND ADD MODAL SHOW
            $("#message-hide").on("click", function() {
                $("#message").fadeOut();
                $("#add-modal").modal("show");
            })


            // FUNCTION LIVE SEARCH USERS 
            function search_data(page) {
                var search_term = $("#search-data").val();

                $.ajax({
                    url: "code/loadmore-code.php",
                    type: "POST",
                    data: {
                        searchTerm: search_term,
                        page_no: page
                    },
                    success: function(data) {
                        if (data) {
                            $("#load-pagination").remove();
                            $("#table-data").append(data);
                        } else {
                            $("#load-btn").addClass("disabled").removeClass("btn-outline-primary").html("Finished");
                        }
                    }
                })
            }
            search_data();
            // CALLING LIVE SEARCH USERS
            $("#search-data").on("keyup", function() {
                $("#table-data").html("");
                search_data();
            })

            $(document).on("click","#load-btn",function(){
                var loadid = $(this).data("id")
                search_data(loadid);
            })


            // ADD USER
            $("#add-data").on("click", function(e) {
                e.preventDefault();
                $("#message").fadeIn();
                var username = $("#username").val();
                var userage = $("#userage").val();
                var useremail = $("#useremail").val();
                var usergender = $("#usergender:checked").val();
                var usercountry = $("#usercountry").val();
                if (username == "" || userage == "" || useremail == "" || usercountry == "") {
                    var message = `
                    <div id="inner-message" class="alert alert-error alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                All Fields Are Required.!
                            </div>
                    `;
                    $("#message").html(message);
                    if ($('#message').fadeIn()) {
                        setTimeout(function() {
                            $("#message").fadeOut("slow");
                        }, 4000)
                    }

                    $(".close").on("click", function() {
                        $("#message").fadeOut("slow");
                    });
                } else {
                    $.ajax({
                        url: "code/code.php",
                        type: "POST",
                        data: {
                            user_name: username,
                            user_age: userage,
                            user_email: useremail,
                            user_gender: usergender,
                            user_country: usercountry
                        },
                        success: function(data) {
                            $("#add-modal").modal('hide');
                            fetch_data();
                            $("#message").html(data);
                            setTimeout(function() {
                                $("#message").fadeOut("slow");
                            }, 4000)
                            $(".close").on("click", function() {
                                $("#message").fadeOut("slow");
                            });
                            $("#form-data").trigger("reset");
                        }
                    })
                    // var row = $("tr").eq(1).attr('id');
                    // $("#"+row).addClass('bg-primary');
                }
            })


            // DELETE USER
            $(document).on("click", "#delete-modal-btn", function() {
                var delete_id = $(this).data("did");
                var active_page = $(this).data("activepage");
                $("#delete-modal").modal("show");
                $("#delete-user").on("click", function() {
                    $.ajax({
                        url: "code/code.php",
                        type: "POST",
                        data: {
                            del_id: delete_id
                        },
                        success: function(data) {
                            if ($("#search-data").val() == "") {
                                fetch_data(active_page);
                            } else {
                                // search_data();
                            }
                            $("#delete-modal").modal("hide");
                            $("#message").fadeIn("slow");
                            $("#message").html(data);
                            setTimeout(function() {
                                $("#message").fadeOut("slow");
                                $("#message").html("");
                            }, 2000)
                            $(".close").on("click", function() {
                                $("#message").fadeOut("slow");
                                $("#message").html("");
                            });
                        }
                    })
                })
            })


            // LOAD UPDATE USER FORM AND UPDATE USER DATA
            $(document).on("click", "#edit-modal-btn", function() {
                var edit_id = $(this).data("eid");
                var active_page = $(this).data("activepage");
                $.ajax({
                    url: "code/code.php",
                    type: "POST",
                    data: {
                        loadEdit: edit_id
                    },
                    success: function(data) {
                        $("#form-edit-data").html(data);
                    }
                })
                $("#edit-modal").modal("show");

                // UPDATE USER
                $("#edit-data").on("click", function(e) {
                    e.preventDefault();
                    $("#message").fadeIn();
                    var userid = $("#edituserid").val();
                    var username = $("#editusername").val();
                    var userid = $("#edituserid").val();
                    var userage = $("#edituserage").val();
                    var useremail = $("#edituseremail").val();
                    var usergender = $("#editusergender:checked").val();
                    var usercountry = $("#editusercountry").val();
                    if (username == "" || userage == "" || useremail == "" || usercountry == "") {
                        var message = `
                    <div id="inner-message" class="alert alert-error alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                All Fields Are Required.!
                            </div>
                    `;
                        $("#message").html(message);
                        if ($('#message').fadeIn()) {
                            setTimeout(function() {
                                $("#message").fadeOut("slow");
                            }, 4000)
                        }

                        $(".close").on("click", function() {
                            $("#message").fadeOut("slow");
                        });
                    } else {
                        $.ajax({
                            url: "code/code.php",
                            type: "POST",
                            data: {
                                edit_user_id: userid,
                                edit_user_name: username,
                                edit_user_age: userage,
                                edit_user_email: useremail,
                                edit_user_gender: usergender,
                                edit_user_country: usercountry
                            },
                            success: function(data) {
                                $("#edit-modal").modal('hide');
                                if ($("#search-data").val() == "") {
                                    fetch_data(active_page);
                                } else {
                                    // search_data();
                                }
                                $("#message").html(data);
                                setTimeout(function() {
                                    $("#message").fadeOut("slow");
                                }, 4000)
                                $(".close").on("click", function() {
                                    $("#message").fadeOut("slow");
                                });
                                $("#form-edit-data").trigger("reset");
                                $("#" + userid).addClass("bg-primary");
                                setTimeout(function() {
                                    $("#" + userid).removeClass("bg-primary");
                                }, 1000)
                            }
                        })
                    }
                })
            })
        })
    </script>
</body>

</html>