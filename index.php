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
        } else if ($adminFile === "addbook") {
            
            require_once 'php/addNewBook.php';
            DoStuff($twig);
        } else if ($adminFile === "lamnain") {
            
            echo $twig->render('admin/lamnain.twig', array());
        } else if ($adminFile === "tabort") {
            
            echo $twig->render('admin/tabort.twig', array());
        } else {
            
            echo $twig->render('admin/admin.twig', array());
        }
    } else if ($file === "bookinfo") {
            
        
        require_once 'php/bookinfo.php';
        DoStuff($twig);
    } else {
        $shouldSelectSida = GetPermaLink(2);
        $sida = 1;

<Konflikter vid sammanfogning>
                       
        if ($shouldSelectSida === 'sida') {
             $sida = GetPermaLink(3);
        }
        $listStart = ($sida - 1) * 18;
        
        $pdo = ConnectToDatabase();
        
        $stmt = $pdo->prepare("SELECT * FROM books ORDER BY id ASC LIMIT :start, 18");
        $stmt->bindParam(':start', $listStart, PDO::PARAM_INT);
        $stmt->execute();
        
        echo $twig->render('site.twig', array('books' => GetAllBooks($db), 'sida' => $sida));

    }

    function GetPermaLink($skip = 0) {
        $path = ltrim($_SERVER['REQUEST_URI'], '/');
        $elements = explode('/', $path);

        if(empty($elements[0]))
        {
            return null;
        }
        else
        {
            for($i=0; $i< $skip;$i++)
                array_shift($elements);

            $req = array_shift($elements);
            return strtolower($req);
        }
    }

    function ConnectToDatabase() {
        $db = new PDO('mysql:host=localhost;dbname=trälleborg;charset=utf8mb4', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    function GetAllBooks($db) {
        $stmt = $db->query('SELECT * FROM books');

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {   
            $book[] = array(
                'title'=> $row["title"],
                'ISBN'=> $row["ISBN"],
                'author'=> $row["author"],
                'category'=> $row["category"],
                'release_year'=> $row["release_year"],
                'publisher'=> $row["publisher"],
                'language' => $row["language"]
            );
        }
        return $book;
    }

?>