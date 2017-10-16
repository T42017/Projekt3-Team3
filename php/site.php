<?php
function DoStuff($twig) {
    $shouldSelectSida = GetPermaLink(2);
    $sida = 1;
    $pageSize = 18;
    
    if ($shouldSelectSida === 'sida') {
        $sida = GetPermaLink(3);
    }
    
    $listStart = ($sida - 1) * $pageSize;
    
    if ($listStart < 0) {
        echo 'Index out of range';
        exit;
    }
       
    $db = ConnectToDatabase();
    
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
    
    $goNextPage = false;
    
    if ($listStart + $pageSize < GetMaxBooks($db))
        $goNextPage = true;
       
    echo $twig->render('site.twig', array('books' => GetBooks($db, $listStart, $pageSize, $searchDb), 'sida' => $sida, 'canGoNextPage' => $goNextPage, 'search' => $search));   
}

function GetBooks($db, $listStart, $pageSize, $search) {
    $stmt = $db->prepare("SELECT * FROM books WHERE title LIKE :search ORDER BY title ASC LIMIT :start, :pageSize ");
    $stmt->bindParam(':start', $listStart, PDO::PARAM_INT);
    $stmt->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {   
        $book[] = array(
            'title'=> $row["title"],
            'ISBN'=> $row["ISBN"],
            'author'=> $row["author"],
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