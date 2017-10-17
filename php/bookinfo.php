<?php
function DoStuff($twig) {
    $isbn = GetPermaLink(2);
    
    if (empty($isbn)) {
        echo "<center><h1>No book selected</h1></center>";
        exit();
    }
    
    $db = ConnectToDatabase();
    
    $bookInfo = new bookInfo();
    $bookInfo->GetBookFromIsbn($db, $isbn);

    if (count($bookInfo->book) === 0) {
        echo '<link rel="stylesheet" href="/projekt3/css/style.css">';
        echo '<center><h1>Book not found in database</h1></center>';
        exit();
    }
    
    $bookInfo->Render($twig);
}

class bookInfo {
    public $book;
    
    function Render($twig) {
        echo $twig->render('bookinfo.twig', array('book' => $this->book));
    }

    function GetBookFromIsbn($db, $isbn) {
        $stmt = $db->prepare("SELECT * FROM books WHERE ISBN = :isbn");
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (count($row) <= 0)
            return array();
        
        $genres = $this->GetGenresFromBook($db, $row["ISBN"]);
        
        $book = array(
            'title'=> $row["title"],
            'ISBN'=> $row["ISBN"],
            'author'=> $row["author"],
            'genres' => $genres,
            'release_year'=> $row["release_year"],
            'publisher'=> $row["publisher"],
            'language' => $row["language"]
        );
        
        $this->book = $book;
        return $book;
    }
    
    function GetGenresFromBook($db, $isbn) {
        $stmt = $db->prepare("SELECT genre.name FROM genre
                                INNER JOIN books_genre 
                                INNER JOIN books
                                WHERE ISBN = :isbn AND
                                books_genre.book_id = books.id AND
                                books_genre.genre_id = genre.id");
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();
        
        $genres = '';
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($genres))
                $genres .= ', ';
            $genres .= $row['name'];
        }
        
        return $genres;
    }
    
    function SetPost($post) {
        $this->post = $post;
    }
}
?>