<?php
    require_once 'Util.php';
    function HTML_head($title = Util::APP_NAME) {
        echo '<!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta name="description" content="">
                <link rel="shortcut icon" href="img/logo.png">
                <meta name="author" content="Fernando Illan">
                <title>' . $title . '</title>
                <!-- Bootstrap core CSS-->
                <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
                <!-- Custom fonts for this template-->
                <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
                <!-- Custom styles for this template-->
                <link href="css/sb-admin.css" rel="stylesheet">
            </head>';
    }

    function HTML_body(array $breadcums = []) {
        $breadcums = ['index.php' => Util::APP_NAME] + $breadcums;        
        require_once 'navigation.php';        
        echo '<body class="fixed-nav sticky-footer bg-dark" id="page-top">

            <!-- content-wrapper-->
            <div class="content-wrapper">
            
                <!-- container-fluid-->
                <div class="container-fluid">';
            
            echo '<!-- Breadcrumbs-->
                    <ol class="breadcrumb">';
                    $i = 0;
                    $len = count($breadcums);
                    foreach ($breadcums as $key => $value) {                                            
                        echo '<li class="breadcrumb-item">
                                <a href="' . $key . '">' . $value . '</a>
                            </li>';
                        if ($i == $len - 2) {
                            break;
                        }                        
                        $i++;
                    }
                    echo '<li class="breadcrumb-item active">' . $breadcums[array_key_last($breadcums)] . '</li>
                    </ol>
                <!-- /.Breadcrumbs-->';  
                                                                 
            echo '<!-- Page Header -->
                    <div class="row">
                        <div class="col-12">
                            <h1 class="modal-header">' 
                                . $breadcums[array_key_last($breadcums)] . 
                            '</h1>
                        </div>
                    </div>
                    <!-- /.Page Header -->';
    
    }

    function HTML_fotter() {
        echo '</div>
            <!-- /.container-fluid-->
            <br>

            <!-- footer -->
            <footer class="sticky-footer">
                <div class="container">
                    <div class="text-center">
                        <small>' . Util::STR_FOOTER . '</small>
                    </div>
                </div>
            </footer>
            <!-- /.footer -->
        
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fa fa-angle-up"></i>
            </a>
            <!-- /.Scroll to Top Button-->
        
            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
            <!-- Page level plugin JavaScript-->
            <script src="vendor/chart.js/Chart.min.js"></script>
            <script src="vendor/datatables/jquery.dataTables.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin.min.js"></script>
            <!-- Custom scripts for this page-->
            <script src="js/sb-admin-datatables.min.js"></script>
            <script src="js/sb-admin-charts.min.js"></script>            
        </div>
        <!-- /.content-wrapper-->
        </body>
        </html>';
    }