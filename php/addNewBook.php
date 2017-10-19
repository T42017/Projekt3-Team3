<?php

function DoStuff($twig) {
    $site = new Site();
    $site->SetPost($_POST);
    $db = ConnectToDatabase();
    
    if(isset($_POST['submit'])) {
        $valid = $site->ValidateInput();
        if (!empty($valid)) {
            $site->error = $valid;
        } else {
            try {
                if ($site->hasFileToUpload)
                    $site->UploadFile();
                
                $genres = array();
                if (isset($_POST['genres']))
                    $genres = $_POST['genres'];

                $site->InsertNewBook($db, $genres);

                $site->info = 'Boken har lagts till';
            } catch (Exception $e) {
                $error = $e->getMessage();
                if (strpos($error, 'Duplicate entry') && strpos($error, "for key 'ISBN'")) {
                    $site->error = 'En bok med samma ISBN-nummer finns redan';
                }
            }
        }
    }
    
    $site->GetAllgenres($db);
    $site->Render($twig);
}

class Site {
    public $info = '';
    public $error = '';
    public $genres;
    public $post;
    public $hasFileToUpload = true;

    function ValidateInput() {
        
        if (empty($this->post['title']))
            return 'Ingen title';

        $this->post['ISBN'] = str_replace("-", "", $this->post['ISBN']);
        if (!preg_match('/^[0-9]{10,13}$/', $this->post['ISBN']))
            return 'Fel isbn format';
        
        if (empty($this->post['release_year']) || !preg_match('/^[0-9]{4}$/', $this->post['release_year']))
            return 'Utgivningsåret var i fel format';
        
        if (!isset($_FILES["fileToUpload"]) || empty($_FILES["fileToUpload"]["name"]))
            $this->hasFileToUpload = false;
        
        if ($this->hasFileToUpload) {
            $target_file = 'uploads/' . basename($_FILES["fileToUpload"]["name"]);
            $temp_file = 'uploads/' . basename($_FILES["fileToUpload"]["tmp_name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check === false) 
                return 'File is not an image';

            // Check if file already exists
            if (file_exists($temp_file))
                return "Sorry, file already exists.";

             // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000)
                return "Sorry, your file is too large";
        }

        return '';
    }
    
    function UploadFile() {
        $imageFileType = pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION);
        $target_file = 'uploads/' . str_replace('.tmp', '.' . $imageFileType, basename($_FILES["fileToUpload"]["tmp_name"]));
        
        $this->post['image_location'] = $target_file;
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    
    function InsertNewBook($db, $genres) {
        $stmt = $db->prepare("INSERT INTO books (title, ISBN, author, release_year, publisher, language, image_location) 
                                value (:title, :isbn, :author, :release_year, :publisher, :language, :image)");

        $stmt->bindParam(':title', $this->post['title']);
        $stmt->bindParam(':isbn', $this->post['ISBN']);
        $stmt->bindParam(':author', $this->post['author']);
        $stmt->bindParam(':release_year', $this->post['release_year']);
        $stmt->bindParam(':publisher', $this->post['publisher']);
        $stmt->bindParam(':language', $this->post['language']);
        $stmt->bindParam(':image', $this->post['image_location']);
        $stmt->execute();
        
        $bookId = $this->GetBookId($db, $this->post['ISBN']);
        
        foreach ($genres as $genre) {
            $this->InsertGenre($db, $bookId, $this->GetGenreId($db, $genre));
        }
        
        return $stmt;
    }
    
    function GetAllgenres($db) {
        $stmt = $db->query("SELECT name FROM genre");

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $genres[] = array(
                'name' => $row['name']
            );
        }
        
        $this->genres = $genres;
        return $genres;
    }
    
    function InsertGenre($db, $bookId, $genreId) {
        $stmt = $db->prepare("INSERT INTO books_genre (book_id, genre_id)
                                value (:book, :genre)");

        $stmt->bindParam(':book', $bookId);
        $stmt->bindParam(':genre', $genreId);
        $stmt->execute();
        
        return $stmt;
    }
    
    function GetGenreId($db, $name) {
        $stmt = $db->prepare("SELECT id FROM genre WHERE name = :name");
        
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (count($result) > 0)
            return $result['id'];
        else
            return null;
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

    function Render($twig) {
        echo $twig->render('admin/addNewBooks.twig', 
                           array(
                               'info' => $this->info,
                               'error' => $this->error,
                               'genres' => $this->genres
                           ));
    }

    function SetPost($post) {
        $this->post = $post;
    }
}          
?>
