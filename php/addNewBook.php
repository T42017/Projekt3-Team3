<?php

function DoStuff($twig) {
    $site = new Site();
    $site->SetPost($_POST);
    
    if(isset($_POST['submit'])) {
        if (!$site->ValidateInput()){
            echo 'validation error';
            exit;
        }
        
        try {
            $db = ConnectToDatabase();
            $site->InsertNewBook($db);

            $site->info = 'Boken har lagts till';
        } catch (Exception $e) {
            $error = $e->getMessage();
            if (strpos($error, 'Duplicate entry') && strpos($error, "for key 'ISBN'")) {
                $site->error = 'En bok med samma ISBN-nummer finns redan';
            }
        }
    }
    
    $site->Render($twig);
}

class Site {
    public $info = '';
    public $error = '';
    public $post;

    function ValidateInput() {
        
        if (empty($this->post['title']))
            return false;

        $this->post['ISBN'] = str_replace("-", "", $this->post['ISBN']);
        if (preg_match('/[^0-9]/', $this->post['ISBN'])) {
            return false;
        }

        if (strlen($this->post['release_year']) != 4)
            return false;

        return true;
    }

    function InsertNewBook($db) {
        $stmt = $db->prepare("INSERT INTO books (title, ISBN, author, category, release_year, publisher, language) 
                                value (:title, :isbn, :author, :category, :release_year, :publisher, :language)");

        $stmt->bindParam(':title', $this->post['title']);
        $stmt->bindParam(':isbn', $this->post['ISBN']);
        $stmt->bindParam(':author', $this->post['author']);
        $stmt->bindParam(':category', $this->post['category']);
        $stmt->bindParam(':release_year', $this->post['release_year']);
        $stmt->bindParam(':publisher', $this->post['publisher']);
        $stmt->bindParam(':language', $this->post['language']);
        $stmt->execute();
        
        return $stmt;
    }

    function Render($twig) {
        echo $twig->render('admin/addNewBooks.twig', array('info' => $this->info, 'error' => $this->error));
    }

    function SetPost($post) {
        $this->post = $post;
    }
}          
?>