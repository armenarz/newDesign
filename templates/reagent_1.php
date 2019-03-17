<?php
require_once('connect.php');
require_once('fillNonBreak.php');
require_once('session.php');
?>
<!doctype html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../img/favicon.ico">

        <!-- Bootstrap CSS -->
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="../bootstrap/4.1.3/css/bootstrap.min.css"/>
        
        <!--Font Awesome-->
        <link rel="stylesheet" href="../fontawesome/5.2.0/css/all.min.css">
        
        <!-- Custom CSS-->
        <link rel="stylesheet" href="../css/reagent_1.css"/>

        <title>Prom-Test Laboratories Admin</title>
    </head>
    <body>
        <form name="tempData" method="post">
            <input type="hidden" id="user_id" name="user_id" value="<?php session_start(); echo $_SESSION['user_id'];?>">
            <!-- Navbar -->
            <?php include "menuBuilder.php";?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-10"></div>
                </div>
            </div>
            <!-- sidebar -->
            <div class="row">
                <div class="col-lg-2" id="toolbars">
                    <nav class="nav navbar-white bg-white flex-column d-print-none">
                        <a class="nav-link active border-bottom border-top" href="#" onclick="PrintUserMenus();" id="printLink"><i class="fas fa-print"></i>&nbsp;Print</a>
                        <a class="nav-link border-bottom" href="#" data-toggle="modal" data-target="#editModalWindow" id="editLink"><i class="fas fa-edit"></i>&nbsp;Edit</a>
                        <a class="nav-link border-bottom" href="#" data-toggle="modal" data-target="#addModalWindow" id="addLink"><i class="far fa-plus-square"></i>&nbsp;Add</a>
                        <a class="nav-link border-bottom" href="#" data-toggle="modal" data-target="#deleteModalWindow" id="deleteLink"><i class="far fa-minus-square"></i>&nbsp;Delete</a>
                    </nav>
                </div>
                <div class="col-lg-10">
                    <div class="content">
                        <div class="alert alert-primary d-print-none" role="alert">
                            Loading...
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Modal Window -->
        <div class="modal fade" id="editModalWindow" tabindex="-1" role="dialog" aria-labelledby="editModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLongTitle">Edit...</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-primary d-print-none" role="alert" id="messageEditModal">Custom message for edit.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="buttonOKEdit">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Modal Window -->
        <div class="modal fade" id="addModalWindow" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLongTitle">Add...</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-primary d-print-none" role="alert" id="messageAddModal">Custom message for add.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="buttonOKAdd">Add...</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Modal Window -->
        <div class="modal fade" id="deleteModalWindow" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLongTitle">Delete...</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-primary d-print-none" role="alert" id="messageDeleteModal">Custom message for delete.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="buttonOKDelete">Delete User Menu</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
        <script src="../jquery/3.3.1/jquery-3.3.1.min.js"></script>
        
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
        <script src="../popper.js/1.14.3/popper.min.js"></script>

        <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
        <script src="../bootstrap/4.1.3/js/bootstrap.min.js"></script>

        <!-- Custom JavaScript-->
        <script src="../js/reagent_1.js"></script>
    </body>
</html>