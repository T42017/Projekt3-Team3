<!DOCTYPE html>
<html>
	<head>
	   <meta charset="UTF-8">
	</head>
	<body>
    
    <?php
        require __DIR__ . '/vendor/autoload.php';
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
        $twig = new Twig_Environment($loader, array('cache' => __DIR__ . '/cache', 'debug' => true));
        
        $file = GetPermaLink(1);
        
        if ($file === "admin2") {
            $adminFile = GetPermaLink(2);
            if ($adminFile === "lanaut") {
                echo $twig->render('admin/lanaUtBocker.twig', array());
            } else if ($adminFile === "addbook") {
                $db = new PDO('mysql:host=localhost;dbname=trälleborg;charset=utf8mb4', 'root', '');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                try {
                    if(isset($_POST['submit'])) {

                        $title = $_POST['title'];
                        $isbn = str_replace("-", "", $_POST['ISBN']);
                        $author = $_POST['author'];
                        $category = $_POST['category'];
                        $release_year = $_POST['release_year'];
                        $publisher = $_POST['publisher'];
                        $language = $_POST['language'];

                        $stmt = $db->prepare("INSERT INTO books (title, ISBN, author, category, release_year, publisher, language) 
                                                value (:title, :isbn, :author, :category, :release_year, :publisher, :language)");

                        $stmt->bindParam(':title', $title);
                        $stmt->bindParam(':isbn', $isbn);
                        $stmt->bindParam(':author', $author);
                        $stmt->bindParam(':category', $category);
                        $stmt->bindParam(':release_year', $release_year);
                        $stmt->bindParam(':publisher', $publisher);
                        $stmt->bindParam(':language', $language);
                        $stmt->execute();

                        //print_r($stmt->fetch(PDO::FETCH_ASSOC));

                        echo 'Book tillagd';
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    if (strpos($error, 'Duplicate entry') && strpos($error, "for key 'ISBN'")) {
                        $error = 'En bok med samma ISBN finns redan';
                    }
                }
                echo $twig->render('admin/addNewBooks.twig', array('error' => isset($error) ? $error : ""));
            } else if ($adminFile === "lamnain") {
                echo $twig->render('admin/lamnain.twig', array());
            } else if ($adminFile === "tabort") {
                echo $twig->render('admin/tabort.twig', array());
            } else {
                echo $twig->render('admin/admin.twig', array());
            }
        } else {
            $pdo = new PDO('mysql:host=localhost;dbname=trälleborg;charset=utf8mb4', 'root', '');
            $stmt = $pdo->query('SELECT * FROM books LIMIT 18');

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
            echo $twig->render('site.twig', array('books' => $book));
        }
        
        function GetPermaLink($skip = 0)
        {
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
    ?>
    </body>
</html>