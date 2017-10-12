<?php

    function DoStuff($twig) {
        $addNewBook = new AddNewBook();
        $addNewBook->SetPost($_POST);

        if(isset($_POST['submit'])) {
            if (!$addNewBook->ValidateInput()){
                echo 'validation error';
                exit;
            }

            try {
                $db = ConnectToDatabase();
                $addNewBook->InsertNewBook($db);

                $addNewBook->info = 'Book tillagd';
            } catch (Exception $e) {
                $error = $e->getMessage();
                if (strpos($error, 'Duplicate entry') && strpos($error, "for key 'ISBN'")) {
                    $addNewBook->error = 'En bok med samma ISBN finns redan';
                }
            }
        }
        
        $addNewBook->Render($twig);
    }
    
    class AddNewBook {
        public $info = '';
        public $error = '';
        public $post;
        
        function ValidateInput() {
            $title = $this->post['title'];
            if (empty($title))
                return false;

            $isbn = str_replace("-", "", $this->post['ISBN']);
            if (preg_match('/[^0-9]/', $isbn)) {
                return false;
            }

            $author = $this->post['author'];
            $category = $this->post['category'];

            $release_year = $this->post['release_year'];
            if (strlen($release_year) != 4)
                return false;

            $publisher = $this->post['publisher'];
            $language = $this->post['language'];
            
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