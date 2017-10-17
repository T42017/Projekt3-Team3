<?php
function DoStuff($twig) {
    $shouldSelectSida = GetPermaLink(3);
    $sida = 1;
    $pageSize = 32;

    if ($shouldSelectSida === 'sida') {
         $sida = GetPermaLink(4);
    }
    
    $listStart = ($sida - 1) * $pageSize;
    
    if ($listStart < 0) {
        echo 'Index out of range';
        exit;
    }
    
    $db = ConnectToDatabase();
    
    if (ValidateInput()) {
        try {
            RemoveBook($db, GetBookId($db, $_POST['isbn']));
        } catch (Exception $e) {
            $error = $e->getMessage();
            echo $error;
            exit;
        }
    }
    
    $goNextPage = false;
    if ($listStart + $pageSize < GetMaxBooks($db))
        $goNextPage = true;
    
    echo $twig->render('admin/tabortbok.twig', array('books' => GetBooks($db, $listStart, $pageSize), 'sida' => $sida, 'canGoNextPage' => $goNextPage));
}

function GetBooks($db, $listStart, $pageSize) {
    $stmt = $db->prepare('SELECT * FROM books ORDER BY id ASC LIMIT :start, :pageSize');
    $stmt->bindParam(':start', $listStart, PDO::PARAM_INT);
    $stmt->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {   
        $books[] = array(
            'title'=> $row["title"],
            'ISBN'=> $row["ISBN"],
            'author'=> $row["author"],
            'release_year'=> $row["release_year"],
            'publisher'=> $row["publisher"],
            'language' => $row["language"]
        );
    }
    return isset($books) ? $books : null;
}

function GetBookId($db, $isbn) {
    $stmt = $db->prepare("SELECT id FROM books WHERE ISBN = :isbn");

    $stmt->bindParam(':isbn', $isbn);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (count($result) > 0)
        return $result['id'];
    else
        return null;
}

function GetMaxBooks($db) {
    $stmt = $db->query('SELECT COUNT(*) FROM books');
    $row = $stmt->fetch();

    return $row[0];
}

function RemoveBook($db, $id) {
    $stmt = $db->prepare('DELETE FROM books WHERE id = :id;
                          DELETE FROM books_genre WHERE book_id = :id;');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function ValidateInput() {
    if (!isset($_POST['isbn']))
        return false;
    
    return true;
}
?>