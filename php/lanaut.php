<?php
    
function DoStuff($twig) {
    $lanaUt = new LanaUt();
    
    if (isset($_POST['submit'])) {
        $lanaUt->SetPost($_POST);
        
        if (!$lanaUt->ValidateInput()) {
            echo 'Validation error';
            exit;
        }

        $db = ConnectToDatabase();

        if ($lanaUt->IsBookLoaned($db)) {
            $lanaUt->error = 'Bok är redan utlånad';
        } else {
            $id = $lanaUt->GetUserId($db);

            if ($id === null)
            {
                $lanaUt->InsertNewUser($db);
                $id = $lanaUt->GetUserId($db);
            }

            $lanaUt->LoanBook($db, $id);

            $lanaUt->info = 'Utlånad';
        }
    }
    
    $lanaUt->Render($twig);
}

class LanaUt {
    public $info = '';
    public $error = '';
    public $post;
    
    function ValidateInput() {
        $this->post['ISBN'] = str_replace("-", "", $this->post['ISBN']);
        if (preg_match('/[^0-9]/', $this->post['ISBN']))
            return false;
        
        if (empty($this->post['name']))
            return false;

        if (!filter_var($this->post['email'], FILTER_VALIDATE_EMAIL))
            return false;
        
        $this->post['phone'] = str_replace("-", "", $this->post['phone']);
        $this->post['phone'] = str_replace(" ", "", $this->post['phone']);
        if (preg_match('/[^0-9]/', $this->post['phone']))
            return false;
        
        return true;
    }
    
    function Render($twig) {
        echo $twig->render('admin/lanaUtBocker.twig', array('error' => $this->error, 'info' => $this->info));
    }
    
    function SetPost($post) {
        $this->post = $post;
    }
    
    function LoanBook($db, $userId) {
        $stmt = $db->prepare("UPDATE books SET user_id = :userId WHERE ISBN = :isbn");

        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':isbn', $this->post['ISBN']);
        $stmt->execute();

        return $stmt;
    }

    function IsBookLoaned($db) {
        $stmt = $db->prepare("SELECT user_id FROM books WHERE ISBN = :isbn limit 1");

        $stmt->bindParam(':isbn', $this->post['ISBN']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row['user_id'] == null)
            return false;

        return true;
    }
    
    function InsertNewUser($db) {
        $stmt = $db->prepare("INSERT INTO Users (name, email, telephone) 
                                value (:name, :email, :phone)");

        $stmt->bindParam(':name', $this->post['name']);
        $stmt->bindParam(':email', $this->post['email']);
        $stmt->bindParam(':phone', $this->post['phone']);
        $stmt->execute();

        return $stmt;
    }

    function GetUserId($db) {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");

        $stmt->bindParam(':email', $this->post['email']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (count($result) > 0)
            return $result['id'];
        else
            return null;
    }
}

?>
