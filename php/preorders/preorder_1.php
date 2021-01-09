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
        <link rel="stylesheet" href="../../css/preorder.css"/>

        <title>Prom-Test Laboratories</title>
    </head>
    <body>
        <!-- Navbar -->
        <?php require_once("../menuBuilder.php");?>
        <div class="container-fluid">
            <form name="tempData" method="post">
                <?php require_once("../tempData.php"); ?>
                <div class="row">
                    <div class="col-lg-2"><img class="img-fluid py-4" src="../../img/Logo.svg"><h2>Предзаказы</h2></div>
                    <div class="col-lg-3">
                        <fieldset class="form-group border rounded mt-4 pb-4 px-4 d-print-none">
                            <legend class="form-control px-2 w-auto"><strong>Выборка по дате предзаказа</strong></legend>
                            <div class="row">
                                <div class="col">
                                    <label for="preorderStartDate">Начальная дата</label>
                                    <select class="form-control" name="preorderStartDate" id="preorderStartDate" disabled>
                                        <option value="0"></option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="preorderEndDate">Конечная дата</label>
                                    <select class="form-control" name="preorderEndDate" id="preorderEndDate" disabled>
                                        <option value="0"></option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>     
                    <div class="col-lg-3">
                        <fieldset class="form-group border rounded mt-4 pb-4 px-4 d-print-none">
                            <legend class="form-control px-2 w-auto"><strong>Выборка предзаказа</strong></legend>
                            <label for="searchPreorderId">Поиск предзаказа по Id или ФИО</label>
                            <div class="input-group">
                                <input type="text" class="form-control ui-widget" name="searchPreorderId" id="searchPreorderId" disabled>
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
                                <option value="1">Необработанные</option>
                                <option value="2">Подтвержденные</option>
                                <option value="3">Отклоненные</option>
                                <option value="4">Все предзаказы</option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-lg-2"></div>
                </div>
                <!-- sidebar -->
                <div class="row">
                    <div class="col-lg-2">
                        <nav class="nav navbar-white bg-white flex-column d-print-none" id="toolbars">
                            <a class="nav-link border-bottom active border-top" href="#" id="exportLink"><i class="far fa-file-excel"></i>&nbsp;Экспорт&nbsp;в&nbsp;Excel</a>
                            <a class="nav-link border-bottom" href="#" data-toggle="modal" data-target="#changeStatusModalWindow" id="changeStatusLink"><i class="far fa-edit"></i>&nbsp;Изменить&nbsp;статус</a>
                        </nav>
                    </div>
                    <div class="col-lg-10">
                        <div class="content" id="content">
                            <div class="alert alert-primary d-print-none" role="alert">
                                Загрузка...
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>  
        <!-- Change Status Modal Window -->
        <div class="modal fade" id="changeStatusModalWindow" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeStatusModalLongTitle">Изменить статус предзаказа</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal From for Changing Preorder Status -->
                            <form name="formChangeStatus" id="formChangeStatus" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageChangeStatusModal">Для изменения статуса предзаказа заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentChangeStatusModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKChangeStatus">Изменить</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Message Modal Windows -->
        <div class="modal fade" id="messageModalWindow" tabindex="-1" role="dialog" aria-labelledby="messageModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageModalLongTitle">Promtest Laboratories</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal From for Deleting Data -->
                            <form name="formMessage" id="formMessage" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageTitleModal">Сообщение системы.</div>
                                    </div>
                                </div>
                                <div id="contentMessageModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрить</button>
                        <!-- <button type="button" class="btn btn-primary" id="buttonOKmessage">Удалить</button> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Common JavaScript -->
        <?php echo file_get_contents('../../js/commonJS.html',true); ?>

        <!-- Custom JavaScript-->
        <script src="../../js/preorder.js"></script>
    </body>
</html>