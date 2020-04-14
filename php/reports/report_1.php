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
        <link rel="stylesheet" href="../../css/report.css"/>

        <title>Prom-Test Laboratories</title>
    </head>
    <body>
        <!-- Navbar -->
        <?php require_once("../menuBuilder.php");?>
        <div class="container-fluid">
            <form name="tempData" method="post">
                <?php require_once("../tempData.php"); ?>
                <div class="row">
                    <div class="col-lg-2"><img class="img-fluid py-4" src="../../img/Logo.svg"><h2>Отчеты</h2></div>
                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-6">
                        
                    </div>                   
                </div>
                <!-- sidebar -->
                <div class="row">
                    <div class="col-lg-2">
                        <nav class="nav navbar-white bg-white flex-column d-print-none" id="sidebar">
                            <a class="nav-link border-top border-bottom" href="#" data-toggle="modal" data-target="#reagentExpensesModalWindow" id="reagentExpensesLink"><i class="far fa-file-alt"></i>&nbsp;Расход&nbsp;реагентов</a><!--active -->
                            <a class="nav-link border-bottom" href="#" id="reagentRemaindersLink" data-toggle="modal" data-target="#reagentRemaindersModalWindow"><i class="far fa-file-alt"></i>&nbsp;Остатки&nbsp;реагентов</a>
                            <a class="nav-link border-bottom" href="#" id="doctorsLink" data-toggle="modal" data-target="#doctorsModalWindow"><i class="far fa-file-alt"></i>&nbsp;Врачи</a>
                            <a class="nav-link border-bottom" href="#" id="debtsLink" data-toggle="modal" data-target="#debtsModalWindow"><i class="far fa-file-alt"></i>&nbsp;Долги</a>
                            <a class="nav-link border-bottom" href="#" id="repaidDebtsLink" data-toggle="modal" data-target="#repaidDebtsModalWindow"><i class="far fa-file-alt"></i>&nbsp;Погашенные&nbsp;долги</a>
                            <a class="nav-link border-bottom" href="#" id="dailyLink" data-toggle="modal" data-target="#dailyModalWindow"><i class="far fa-file-alt"></i>&nbsp;Дневной</a>
                            <a class="nav-link border-bottom" href="#" id="ordersByLabsLink" data-toggle="modal" data-target="#ordersByLabsModalWindow"><i class="far fa-file-alt"></i>&nbsp;Заказы&nbsp;по&nbsp;лабораториям</a>
                            <a class="nav-link border-bottom" href="#" id="ordersByUsersLink" data-toggle="modal" data-target="#ordersByUsersModalWindow"><i class="far fa-file-alt"></i>&nbsp;Заказы&nbsp;по&nbsp;пользователям</a>
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
        <!-- Reagent Expenses Modal Window -->
        <div class="modal fade" id="reagentExpensesModalWindow" tabindex="-1" role="dialog" aria-labelledby="reagentExpensesModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reagentExpensesModalLongTitle">Расход реагентов</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal Form for Reagent Expenses Data -->
                            <form name="formReagentExpenses" id="formReagentExpenses" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageReagentExpensesModal">Заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentReagentExpensesModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="buttonReagentExpensesToExcel">Экспорт в Excel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKReagentExpenses">Создать</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Reagent Remainders Modal Window -->
        <div class="modal fade" id="reagentRemaindersModalWindow" tabindex="-1" role="dialog" aria-labelledby="reagentRemaindersModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reagentRemaindersModalLongTitle">Остатки реагентов</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal Form for Reagent Remainders Data -->
                            <form name="formReagentRemainders" id="formReagentRemainders" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageReagentRemaindersModal">Заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentReagentRemaindersModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="buttonReagentRemaindersToExcel">Экспорт в Excel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKReagentRemainders">Создать</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Doctors Modal Window -->
        <div class="modal fade" id="doctorsModalWindow" tabindex="-1" role="dialog" aria-labelledby="doctorsModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="doctorsModalLongTitle">Врачи</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal Form for Doctors Data -->
                            <form name="formDoctors" id="formDoctors" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageDoctorsModal">Заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentDoctorsModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="buttonDoctorsToExcel">Экспорт в Excel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKDoctors">Создать</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Debts Modal Window -->
        <div class="modal fade" id="debtsModalWindow" tabindex="-1" role="dialog" aria-labelledby="debtsModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="debtsModalLongTitle">Долги</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal Form for Debts Data -->
                            <form name="formDebts" id="formDebts" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageDebtsModal">Заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentDebtsModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="buttonDebtsToExcel">Экспорт в Excel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKDebts">Создать</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Repaid Debts Modal Window -->
        <div class="modal fade" id="repaidDebtsModalWindow" tabindex="-1" role="dialog" aria-labelledby="repaidDebtsModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repaidDebtsModalLongTitle">Погашенные долги</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal Form for Repaid Debts Data -->
                            <form name="formRepaidDebts" id="formRepaidDebts" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageRepaidDebtsModal">Заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentRepaidDebtsModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="buttonRepaidDebtsToExcel">Экспорт в Excel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKRepaidDebts">Создать</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Daily Modal Window -->
        <div class="modal fade" id="dailyModalWindow" tabindex="-1" role="dialog" aria-labelledby="dailyModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dailyModalLongTitle">Дневной</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal Form for Daily Data -->
                            <form name="formDaily" id="formDaily" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageDailyModal">Заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentDailyModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="buttonDailyToExcel">Экспорт в Excel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKDaily">Создать</button>
                    </div>
                </div>
            </div>
        </div> 
        <!-- Orders By Laboratories Modal Window -->
        <div class="modal fade" id="ordersByLabsModalWindow" tabindex="-1" role="dialog" aria-labelledby="ordersByLabsModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ordersByLabsModalLongTitle">Заказы по лабораториям</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal Form for Orders By Labs Data -->
                            <form name="formOrdersByLabs" id="formOrdersByLabs" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageOrdersByLabsModal">Заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentOrdersByLabsModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="buttonOrdersByLabsToExcel">Экспорт в Excel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKOrdersByLabs">Создать</button>
                    </div>
                </div>
            </div>
        </div>       
        <!-- Orders By Users Modal Window -->
        <div class="modal fade" id="ordersByUsersModalWindow" tabindex="-1" role="dialog" aria-labelledby="ordersByUsersModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ordersByUsersModalLongTitle">Заказы по юзерам</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal Form for Orders By Users Data -->
                            <form name="formOrdersByUsers" id="formOrdersByUsers" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageOrdersByUsersModal">Заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentOrdersByUsersModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="buttonOrdersByUsersToExcel">Экспорт в Excel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKOrdersByUsers">Создать</button>
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
        <script src="../../js/report.js"></script>
    </body>
</html>