<?php
function DoStuff($twig) {
    $shouldSelectSida = GetPermaLink(2);
    $sida = 1;

    if ($shouldSelectSida === 'sida') {
         $sida = GetPermaLink(3);
    }
    
    $listStart = ($sida - 1) * 18;
    
    if ($listStart < 0) {
        echo 'Index out of range';
        exit;
    }

    $db = ConnectToDatabase();
    
    echo $twig->render('site.twig', array('books' => GetAllBooks($db, $listStart), 'sida' => $sida));
}

function GetAllBooks($db, $listStart) {
    $stmt = $db->prepare('SELECT * FROM books ORDER BY id ASC LIMIT :start, 18');
    $stmt->bindParam(':start', $listStart, PDO::PARAM_INT);
    $stmt->execute();

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
    return isset($book) ? $book : null;
}
?>