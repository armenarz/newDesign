<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
?>
<!doctype html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../img/favicon.ico">

        <!-- Common CSS -->
        <?php echo file_get_contents('../../css/commonCSS.html',true); ?>

        <!-- Custom CSS-->
        <link rel="stylesheet" href="../../css/doctor.css"/>

        <title>Prom-Test Laboratories</title>
    </head>
    <body>
        <!-- Navbar -->
        <?php require_once("../menuBuilder.php");?>
        <div class="container-fluid">
            <form name="tempData" method="post">
                <?php require_once("../tempData.php");?>            
                <div class="row">
                    <div class="col-lg-2"><img class="img-fluid py-4" src="../../img/Logo.svg"><h2>Доктора</h2></div>
                    <div class="col-lg-5">
                        <fieldset class="form-group border rounded mt-4 pb-4 px-4 d-print-none">
                            <legend class="form-control px-2 w-auto"><strong>Выборка по фильтрам</strong></legend>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="selectSale">Sales</label>
                                    <select class="form-control" name="salesId" id="selectSale" disabled>
                                        <option value="0"></option>
                                    </select>
                                </div>                            
                                <div class="col-lg-4">
                                    <label for="selectWorkplace">Место работы</label>
                                    <select class="form-control" name="workplaceId" id="selectWorkplace" disabled>
                                        <option value="0"></option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="selectSpeciality">Специальность</label>
                                    <select class="form-control" name="specialityId" id="selectSpeciality" disabled>
                                        <option value="0"></option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-3">
                        <fieldset class="form-group border rounded mt-4 pb-4 px-4 d-print-none">
                            <legend class="form-control px-2 w-auto"><strong>Выборка по доктору</strong></legend>
                            <label for="searchDoctor">Поиск по Id и ФИО</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="doctorId" id="searchDoctor" disabled>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton"><i class="fas fa-search"></i></button>
                                </div>
                            </div>    
                        </fieldset>
                    </div>
                    <div class="col-lg-2">
                        <fieldset class="form-group border rounded mt-4 pb-4 px-4 d-print-none">
                            <legend class="form-control px-2 w-auto"><strong>Общие</strong></legend>
                            <label for="generalSelectionId">Показать</label>
                            <select class="form-control" name="generalSelectionId" id="generalSelectionId">
                                <option value="0"></option>
                                <option value="1">Все доктора</option>
                                <option value="2">Все активные доктора</option>
                                <option value="3">Все неактивные доктора</option>
                            </select>
                        </fieldset>
                    </div>
                </div>
                <!-- sidebar -->
                <div class="row">
                    <div class="col-lg-2">
                        <nav class="nav navbar-white bg-white flex-column d-print-none" id="toolbars">
                            <a class="nav-link border-bottom active border-top" href="#" id="exportLink"><i class="far fa-file-excel"></i>&nbsp;Экспорт&nbsp;в&nbsp;Excel</a>
                            <a class="nav-link disabled border-bottom" href="#" data-toggle="modal" data-target="#addModalWindow" id="addLink"><i class="far fa-plus-square"></i>&nbsp;Добавить</a>
                            <a class="nav-link border-bottom" href="#" data-toggle="modal" data-target="#editModalWindow" id="editLink"><i class="far fa-edit"></i>&nbsp;Редактировать</a>
                            <a class="nav-link disabled border-bottom" href="#" data-toggle="modal" data-target="#deleteModalWindow" id="deleteLink"><i class="far fa-minus-square"></i>&nbsp;Удалить</a>
                        </nav>
                    </div>
                    <div class="col-lg-10">
                        <div id="content">
                            <div class="alert alert-primary d-print-none" role="alert">
                                Загрузка...
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Edit Modal Window -->
        <div class="modal fade" id="editModalWindow" tabindex="-1" role="dialog" aria-labelledby="editModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLongTitle">Редактировать данные доктора</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal From for Editing Data -->
                            <form name="formEdit" id="formEdit" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageEditModal">Для редактирования данных доктора заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentEditModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKEdit">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Modal Window -->
        <div class="modal fade" id="addModalWindow" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLongTitle">Добавить новый доктор</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal From for Adding Data -->
                            <form name="formAdd" id="formAdd" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageAddModal">Для добавления нового доктора заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentAddModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKAdd">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Modal Window -->
        <div class="modal fade" id="deleteModalWindow" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLongTitle">Удалить доктора</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal From for Deleting Data -->
                            <form name="formDelete" id="formDelete" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageDeleteModal">Вы действительно хотите удалить данного доктора?</div>
                                    </div>
                                </div>
                                <div id="contentDeleteModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKDelete">Удалить</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Common JavaScript -->
        <?php echo file_get_contents('../../js/commonJS.html',true); ?>

        <!-- Custom JavaScript-->
        <script src="../../js/doctor.js"></script>
    </body>
</html>