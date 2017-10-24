<?php
function DoStuff($twig) {
    $shouldSelectSida = GetPermaLink(2);
    $sida = 1;
    $pageSize = 36;
    
    if ($shouldSelectSida === 'sida') {
        $sida = GetPermaLink(3);
    }
    
    $listStart = ($sida - 1) * $pageSize;
    
    if ($listStart < 0) {
        echo 'Index out of range';
        exit;
    }
       
    $db = ConnectToDatabase();
    
    $goNextPage = false;
    
    if ($listStart + $pageSize < GetMaxBooks($db))
        $goNextPage = true;
    
    $books = array();
        
    if(isset($_GET['categories']))
    {
        $categories =$_GET['categories'];
    }
    
    else
    {
        $categories = '';
    }
    
    if(isset($_GET['search']))
    {
        $searchDb = '%' . $_GET['search'] . '%';
        $search =$_GET['search'];
    }
    
    else
    {
        $searchDb = '%';
        $search = '';
    }
    
    
       
    echo $twig->render('site.twig', array('books' => GetBooks($db, $listStart, $pageSize, $searchDb, $categories), 'sida' => $sida, 'canGoNextPage' => $goNextPage, 'search' => $search, 'categories' => $categories));
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

function GetBooks($db, $listStart, $pageSize, $search, $cat) {
    
    if($cat > 0)
    {
        $stmt = $db->prepare("SELECT * FROM books INNER JOIN books_genre ON books.id=books_genre.book_id AND books_genre.genre_id=:cat order by books.id");
        $stmt->bindParam(':cat', $cat, PDO::PARAM_INT);
        $stmt->execute();
        
    }
    else
    {
        $stmt = $db->prepare("SELECT * FROM books WHERE title LIKE :search ORDER BY title ASC LIMIT :start, :pageSize ");
        $stmt->bindParam(':start', $listStart, PDO::PARAM_INT);
        $stmt->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->execute();
    }
        
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {   
        $book[] = array(
            'title'=> $row["title"],
            'ISBN'=> $row["ISBN"],
            'author'=> $row["author"],
            'genres'=> GetGenresFromBook($db, $row["ISBN"]),
            'release_year'=> $row["release_year"],
            'publisher'=> $row["publisher"],
            'language' => $row["language"]
        );
    }
    return isset($book) ? $book : null;
}

function GetMaxBooks($db) {
    $stmt = $db->query('SELECT COUNT(*) FROM books');
    $row = $stmt->fetch();
    return $row[0];
}
?>