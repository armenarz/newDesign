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
        <link rel="stylesheet" href="../../css/reagent.css"/>

        <title>Prom-Test Laboratories</title>
    </head>
    <body>
        <!-- Navbar -->
        <?php require_once("../menuBuilder.php");?>
        <div class="container-fluid">
            <form name="tempData" method="post">
                <?php require_once("../tempData.php");?>            
                <div class="row">
                <div class="col-lg-2"><img class="img-fluid py-4" src="../../img/Logo.svg"><h2>Реагенты</h2></div>
                    <div class="col-lg-5">
                        <fieldset class="form-group border rounded mt-4 pb-4 px-4 d-print-none">
                            <legend class="form-control px-2 w-auto"><strong>Выборка по методу и группе</strong></legend>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="selectMethod">Метод</label>
                                    <select class="form-control" name="methodId" id="selectMethod" disabled>
                                        <option value=""></option>
                                    </select>
                                </div>                            
                                <div class="col-lg-4">
                                    <label for="selectGroup">Группа</label>
                                    <select class="form-control" name="groupId" id="selectGroup" disabled>
                                        <option value="0"></option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="selectVisibility">Показать</label>
                                    <select class="form-control" name="visibilityId" id="selectVisibility">
                                        <option value="0">Все</option>
                                        <option value="1" selected>Видимые</option>
                                        <option value="2">Скрытые</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-3">
                        <fieldset class="form-group border rounded mt-4 pb-4 px-4 d-print-none">
                            <legend class="form-control px-2 w-auto"><strong>Выборка по реагенту</strong></legend>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="searchReagent">Поиск</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="searchReagent" id="searchReagent" disabled>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="searchButton"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="selectReagent">Из списка</label>
                                    <select class="form-control" name="reagentId" id="selectReagent" disabled>
                                        <option value="0"></option>
                                    </select>      
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
                                <option value="1">Все реагенты</option>
                                <option value="2">Все видимые реагенты</option>
                                <option value="3">Все скрытые реагенты</option>
                                <option value="4">Все активные реагенты</option>
                                <option value="5">Все не активные реагенты</option>
                                <option value="6">Все используемые реагенты</option>
                                <option value="7">Все неиспользуемые реагенты</option>
                            </select>
                        </fieldset>
                    </div>
                </div>
                <!-- sidebar -->
                <div class="row">
                    <div class="col-lg-2">
                        <nav class="nav navbar-white bg-white flex-column d-print-none" id="toolbars">
                            <a class="nav-link border-bottom active border-top" href="#" data-toggle="modal" data-target="#calendarModalWindow" id="calendarLink"><i class="far fa-calendar-alt"></i>&nbsp;Календарь</a>
                            <a class="nav-link border-bottom" href="#" id="exportLink"><i class="far fa-file-excel"></i>&nbsp;Экспорт&nbsp;в&nbsp;Excel</a>
                            <a class="nav-link border-bottom" href="#" data-toggle="modal" data-target="#addModalWindow" id="addLink"><i class="far fa-plus-square"></i>&nbsp;Добавить</a>
                            <a class="nav-link border-bottom" href="#" data-toggle="modal" data-target="#copyModalWindow" id="copyLink"><i class="far fa-copy"></i>&nbsp;Копировать</a>
                            <a class="nav-link border-bottom" href="#" data-toggle="modal" data-target="#editModalWindow" id="editLink"><i class="far fa-edit"></i>&nbsp;Редактировать</a>
                            <a class="nav-link disabled border-bottom" href="#" data-toggle="modal" data-target="#deleteModalWindow" id="deleteLink"><i class="far fa-minus-square"></i>&nbsp;Удалить</a>
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
        <!-- Calendar Modal Window -->
        <div class="modal fade" id="calendarModalWindow" tabindex="-1" role="dialog" aria-labelledby="calendarModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="calendarModalLongTitle">Редактировать календарь</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal From for Calendar -->
                            <form name="formCalendar" id="formCalendar" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageCalendarModal">Для добавления и удаления не рабочего дня кликните на соответствующий день календаря.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">
                                        <div id="contentCalendarModal"></div>
                                    </div>
                                    <div class="col"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <!-- <button type="button" class="btn btn-primary" id="buttonOKCalendar">Сохранить</button> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Modal Window -->
        <div class="modal fade" id="editModalWindow" tabindex="-1" role="dialog" aria-labelledby="editModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLongTitle">Редактировать данные реагента</h5>
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
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageEditModal">
                                            Для редактирования данных реагента заполните нужными значениями поля формы.
                                        </div>
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
                        <h5 class="modal-title" id="addModalLongTitle">Добавить новый реагент</h5>
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
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageAddModal">Для добавления нового реагента заполните нужными значениями поля формы.</div>
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
        <!-- Copy Modal Window -->
        <div class="modal fade" id="copyModalWindow" tabindex="-1" role="dialog" aria-labelledby="copyModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="copyModalLongTitle">Копировать реагент</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal From for Copying Data -->
                            <form name="formCopy" id="formCopy" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageCopyModal">Для копирования нового реагента заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentCopyModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKCopy">Копировать</button>
                    </div>
                </div>
            </div>
        </div>        
        <!-- Delete Modal Window -->
        <div class="modal fade" id="deleteModalWindow" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLongTitle">Удалить реагент</h5>
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
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageDeleteModal">Вы действительно хотите удалить данный реагент?</div>
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
        <script src="../../js/reagent.js"></script>
    </body>
</html>