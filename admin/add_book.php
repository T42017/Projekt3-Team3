<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script type="application/javascript" src="../js/popper.min.js"></script>
    <script type="application/javascript" src="../js/jquery-3.2.1.js"></script>
    <script type="application/javascript" src="../js/bootstrap.min.js"></script>
    <script type="application/javascript" src="../js/isbnSearch.js"></script>
    <title>Add new book</title>
    <style>
        body {
            background: lightgreen;
        }
        
        input {
            display: inline-block;
            margin: 5px 10px 20px 10px;
            width: 300px;
            height: 30px;
        }
        
        button {
            display: block;
            margin-left: 125px;
        }
        
        h1, h3 {
            margin: 10px;
        }
        
        #loadingGif {
            display: none;
        }
        
        #loadingImg {
            width: 20px;
        }
    </style>
</head>

<body>
    <?php
    
    $db = new PDO('mysql:host=localhost;dbname=trälleborg;charset=utf8mb4', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (!$db) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
    }
    
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
    ?>
    
    <form method="post">
        <h3>ISBN (På baksidan av boken)</h3>
        <input type="text" id="isbn" name="ISBN" minlength="10" maxlength="20" pattern="^[0-9\-]+$" required autofocus>
        
        <div id="loadingGif">
            Searching info about book
            <img id="loadingImg" src="../loading.gif"/>
        </div>
        
        <h3>title</h3>
        <input type="text" name="title" minlength="4" maxlength="50" required>
        
        <h3>author</h3>
        <input type="text" id="author" name="author" maxlength="50">
        
        <h3>categories</h3>
        <input type="text" id="category" name="category" maxlength="50">
        
        <h3>release year</h3>
        <input type="year" id="year" name="release_year" maxlength="4">
        
        <h3>publisher</h3>
        <input type="text" id="publisher" name="publisher" maxlength="50">
        
        <h3>language</h3>
        <input type="text" id="language" name="language" minlength="2" maxlength="50" required>
        
        <button type="submit" name="submit">Skicka</button>
    </form>
</body>

</html>