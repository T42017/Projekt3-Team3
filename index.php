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
                $info = "";
                $error = "";
                
                if (isset($_POST['submit'])) {
                    $isbn = str_replace("-", "", $_POST['ISBN']);
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    
                    $db = ConnectToDatabase();
                    
                    if (IsBookLoaned($db, $isbn)) {
                        $error = 'Bok är utlånad';
                    } else {
                        $id = GetUserId($db, $email);
                        
                        if ($id === null)
                        {
                            InsertNewUser($db, $name, $email, $phone);
                            $id = GetUserId($db, $email);
                        }
                        
                        LoanBook($db, $id, $isbn);
                        
                        $info = 'Utlånad';
                        
                    }
                }
                
                echo $twig->render('admin/lanaUtBocker.twig', array('error' => $error, 'info' => $info));
            } else if ($adminFile === "addbook") {
                $info = "";
                $error = "";
                
                try {
                    if(isset($_POST['submit'])) {
                        $title = $_POST['title'];
                        $isbn = str_replace("-", "", $_POST['ISBN']);
                        $author = $_POST['author'];
                        $category = $_POST['category'];
                        $release_year = $_POST['release_year'];
                        $publisher = $_POST['publisher'];
                        $language = $_POST['language'];
                        
                        $db = ConnectToDatabase();
                        InsertNewBook($db, $title, $isbn, $author, $category, $release_year, $publisher, $language);

                        $info = 'Book tillagd';
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    if (strpos($error, 'Duplicate entry') && strpos($error, "for key 'ISBN'")) {
                        $error = 'En bok med samma ISBN finns redan';
                    }
                }
                
                echo $twig->render('admin/addNewBooks.twig', array('info' => $info, 'error' => $error));
            } else if ($adminFile === "lamnain") {
                echo $twig->render('admin/lamnain.twig', array());
            } else if ($adminFile === "tabort") {
                echo $twig->render('admin/tabort.twig', array());
            } else {
                echo $twig->render('admin/admin.twig', array());
            }
        } else if ($file === "bookinfo") {
            $isbn = GetPermaLink(2);
            
            if (empty($isbn) || !isset($isbn)) {
                echo "<center><h1>No book selected</h1></center>";
                exit();
            }
            
            $db = ConnectToDatabase();
            $book = GetBookFromIsbn($db, $isbn);
            
            if (count($book) === 0) {
                echo '<link rel="stylesheet" href="/projekt3/css/style.css">';
                echo '<center><h1>Book not found in database</h1></center>';
                exit();
            }
            
            echo $twig->render('bookinfo.twig', array('book' => $book));
        } else {
            $db = ConnectToDatabase();
            
            echo $twig->render('site.twig', array('books' => GetAllBooks($db)));
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
        
        function InsertNewBook($db, $title, $isbn, $author, $category, $release_year, $publisher, $language) {
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
            
            return $stmt;
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
        
        function GetBookFromIsbn($db, $isbn) {
            $stmt = $db->prepare("SELECT * FROM books WHERE ISBN = :isbn");
            $stmt->bindParam(':isbn', $isbn);
            $stmt->execute();
            
            $book = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $book = array(
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
        
        function LoanBook($db, $userId, $isbn) {
            $stmt = $db->prepare("UPDATE books SET user_id = :userId WHERE ISBN = :isbn");
            
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':isbn', $isbn);
            $stmt->execute();
            
            return $stmt;
        }
        
        function IsBookLoaned($db, $isbn) {
            $stmt = $db->prepare("SELECT user_id FROM books WHERE ISBN = :isbn limit 1");

            $stmt->bindParam(':isbn', $isbn);
            $stmt->execute();
            $row = $stmt->fetch();
            
            if ($row[0] == null)
                return false;
            
            return true;
        }
        
        function InsertNewUser($db, $name, $email, $phone) {
            $stmt = $db->prepare("INSERT INTO Users (name, email, telephone) 
                                    value (:name, :email, :phone)");

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->execute();
            
            return $stmt;
        }
        
        function GetUserId($db, $email) {
            $stmt = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");

            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (count($result) > 0)
                return $result['id'];
            else
                return null;
        }
    ?>
    </body>
</html>