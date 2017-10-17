<?php
    require __DIR__ . '/vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
    $twig = new Twig_Environment($loader, array('cache' => __DIR__ . '/cache', 'debug' => true));
    $file = GetPermaLink(1);

    if ($file === "admin") {
        $adminFile = GetPermaLink(2);
        
        if ($adminFile === "lanaut") {
            require_once 'php/lanaut.php';
            DoStuff($twig);
        }
        
        else if ($adminFile === "addbook") {
            require_once 'php/addNewBook.php';
            DoStuff($twig);
        }
        
        else if ($adminFile === "lamnain") {
            require_once 'php/lamnain.php';
            DoStuff($twig);
        }
        else if ($adminFile === "tabort"){
            require_once 'php/tabort.php';
            DoStuff($twig);
        }
        
        else {
            echo $twig->render('admin/admin.twig', array());
        }
    }else if ($file === "bookinfo") {
        require_once 'php/bookinfo.php';
        DoStuff($twig);
    } else if ($file === "fourofour") {
        
        echo $twig->render('fourofour.twig', array());
    } else {
        
        require_once 'php/site.php';
        DoStuff($twig);
    }
    
    function GetPermaLink($skip = 0) {
        $path = ltrim($_SERVER['REQUEST_URI'], '/');
        $elements = explode('/', $path);

        if(empty($elements[0])) 
            return null;
        
        for($i=0; $i< $skip;$i++)
            array_shift($elements);

        $req = array_shift($elements);
        return strtolower($req);
    }

    function ConnectToDatabase() {
        $db = new PDO('mysql:host=localhost;dbname=trälleborg;charset=utf8mb4', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }

?>