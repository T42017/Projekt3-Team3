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

        $this->book = $book;
        return $book;
    }
    
    function SetPost($post) {
        $this->post = $post;
    }
}
?>