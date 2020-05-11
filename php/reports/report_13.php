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
                            <a class="nav-link border-bottom" href="#" id="doctor13Link" data-toggle="modal" data-target="#doctor13ModalWindow"><i class="far fa-file-alt"></i>&nbsp;Врач13</a>
                            <a class="nav-link border-bottom" href="#" id="doctorSelectedLink" data-toggle="modal" data-target="#doctorSelectedModalWindow"><i class="far fa-file-alt"></i>&nbsp;Врач выбранный</a>
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
        <!-- Doctor13 Modal Window -->
        <div class="modal fade" id="doctor13ModalWindow" tabindex="-1" role="dialog" aria-labelledby="doctor13ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="doctor13ModalLongTitle">Врач13</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal Form for Doctor 13 Data -->
                            <form name="formDoctor13" id="formDoctor13" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageDoctor13Modal">Заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentDoctor13Modal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="buttonDoctor13ToExcel">Экспорт в Excel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKDoctor13">Создать</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Doctor Selected Modal Window -->
        <div class="modal fade" id="doctorSelectedModalWindow" tabindex="-1" role="dialog" aria-labelledby="doctorSelectedModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="doctorSelectedModalLongTitle">Врач выбранный</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <!-- Modal Form for Doctor Selected Data -->
                            <form name="formDoctorSelected" id="formDoctorSelected" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-primary d-print-none" role="alert" id="messageDoctorSelectedModal">Заполните нужными значениями поля формы.</div>
                                    </div>
                                </div>
                                <div id="contentDoctorSelectedModal">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="buttonDoctorSelectedToExcel">Экспорт в Excel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        <button type="button" class="btn btn-primary" id="buttonOKDoctorSelected">Создать</button>
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