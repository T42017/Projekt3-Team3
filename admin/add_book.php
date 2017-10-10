<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/popper.min.js"></script>
    <script src="../js/jquery-3.2.1.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <title>Add new book</title>
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
        if(isset($_POST['title']) && !empty($_POST['title']) &&
          isset($_POST['ISBN']) && !empty($_POST['ISBN']) &&
          isset($_POST['author']) && !empty($_POST['author']) &&
          isset($_POST['category']) && !empty($_POST['category']) &&
          isset($_POST['release_date']) && !empty($_POST['release_date']) &&
          isset($_POST['publisher']) && !empty($_POST['publisher']) &&
          isset($_POST['language']) && !empty($_POST['language'])) {

            $title = $_POST['title'];
            $isbn = $_POST['ISBN'];
            $author = $_POST['author'];
            $category = $_POST['category'];
            $release_date = $_POST['release_date'];
            $publisher = $_POST['publisher'];
            $language = $_POST['language'];

            $stmt = $db->prepare("INSERT INTO books (title, ISBN, author, category, release_date, publisher, language) value (:title, :isbn, :author, :category, :release_date, :publisher, :language)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':isbn', $isbn);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':release_date', $release_date);
            $stmt->bindParam(':publisher', $publisher);
            $stmt->bindParam(':language', $language);
            $stmt->execute();

            //print_r($stmt->fetch(PDO::FETCH_ASSOC));

            echo '<h1>Book added<h1>';
        }
    } catch (Exception $e) {
        echo 'Exception -> ';
        var_dump($e->getMessage());
    }
    
    ?>
    
    <script type="application/javascript">
        $(document).ready(function () {
            
            $('#isbn').on('input propertychange paste',function(e){
                var isbn = document.getElementById("isbn").value;
                
                if (isbn.includes("-") && false)
                    isbn = isbn.replace(/-/g, "");
                
                if (!/^\d+$/.test(isbn) || (isbn.length < 10 || isbn.length > 13))
                    return;
                
                checkISBN(isbn);
            });
            
            function checkISBN(isbn) {
                $.getJSON("http://libris.kb.se/xsearch?query=" + isbn + "&format=json", function(result){
                    $.each(result, function(i, field){
                        if (i != "xsearch")
                            return;

                        var title = "";
                        var publisher = "";
                        var language = "";
                        var date = null;

                        $.map(field.list, function(value, index) {
                            if (!title && value.title) 
                                title = value.title;

                            if (!publisher && value.publisher)
                                publisher = value.publisher;

                            if (!language && value.language)
                                language = value.language;
                            
                            if (!date && value.date) {
                                var placeholder = value.date;
                                if (placeholder.length > 4)
                                    placeholder = placeholder.substring(placeholder.length - 4, placeholder.length);
                                var d = new Date();
                                d.setFullYear(placeholder, 0, 0);
                                date = d;
                            }
                            
                            if (title && language && publisher)
                                return;
                        });

                        document.getElementById("title").value = title;
                        document.getElementById("publisher").value = publisher;
                        document.getElementById("language").value = language;
                        if (date)
                            document.getElementById("date").value = date;
                    });
                });
            };
        });
    </script>
    
    <form method="post">
        <h3>ISBN</h3>
        <input type="text" id="isbn" name="ISBN" required autofocus  minlength="10" maxlength="20" pattern="\d+">
        
        <h3>title</h3>
        <input type="text" id="title" name="title" required minlength="4" maxlength="50">
        
        <h3>author</h3>
        <input type="text" id="author" name="author" required minlength="4" maxlength="50">
        
        <h3>category</h3>
        <input type="text" id="category" name="category" maxlength="50">
        
        <h3>release date</h3>
        <input type="date" name="release_date">
        
        <h3>publisher</h3>
        <input type="text" id="publisher" name="publisher">
        
        <h3>language</h3>
        <input type="text" id="language" name="language" required minlength="2" maxlength="50">
        
        <input type="submit" name="submit">
    </form>
    
    <style>
        input {
            margin: 5px 10px 10px 10px;
        }
        
        h3 {
            margin: 10px;
        }
    </style>
</body>

</html>