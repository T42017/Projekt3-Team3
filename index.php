<!DOCTYPE html>
<html>
	<head>
	   <meta charset="UTF-8">
        <title>hejsan</title>
	</head>
	<body>
    
    <?php
        require __DIR__ . '/vendor/autoload.php';
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
        $twig = new Twig_Environment($loader, array('cache' => __DIR__ . '/cache', 'debug' => true));
        
        $file = GetPermaLink(1);
        
        if ($file === "admin2") {
            $db = new PDO('mysql:host=localhost;dbname=trälleborg;charset=utf8mb4', 'root', '');

            try {
                echo "w".isset($_POST['submit']);
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

                    echo '<h3>Book tillagd<h3>';
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
                if (strpos($error, 'Duplicate entry') && strpos($error, "for key 'ISBN'")) {
                    echo '<h3>En bok med samma ISBN finns redan';
                } else {
                    echo 'Exception -> ';
                    echo $error;
                }
            }
            echo $twig->render('admin/addNewBooks.twig', array());
        } else {
            $pdo = new PDO('mysql:host=localhost;dbname=trälleborg;charset=utf8mb4', 'root', '');
            $stmt = $pdo->query('SELECT * FROM books');

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