<?php
    
function DoStuff($twig) {
    $lamnaIn = new LamnaIn();
    
    if (isset($_POST['submit'])) {
        $lamnaIn->SetPost($_POST);
        
        if (!$lamnaIn->ValidateInput()) {
            echo 'Validation error';
            exit;
        }

        $db = ConnectToDatabase();

        if ($lamnaIn->IsBookLoaned($db)) {
            
            $lamnaIn->ReturnBook($db);
            
            $lamnaIn->info = 'Boken är nu inlämmnad!';
            
        } else {
            $lamnaIn->error = 'Boken är inte utlånad!';
        }
    }
    
    $lamnaIn->Render($twig);
}

class LamnaIn {
    public $info = '';
    public $error = '';
    public $post;
    
    function ValidateInput() {
        $this->post['ISBN'] = str_replace("-", "", $this->post['ISBN']);
        if (preg_match('/[^0-9]/', $this->post['ISBN']))
            return false;
        
        return true;
    }
    
    function Render($twig) {
        echo $twig->render('admin/lamnain.twig', array('error' => $this->error, 'info' => $this->info));
    }
    
    function SetPost($post) {
        $this->post = $post;
    }
    
    function ReturnBook($db) {
        $stmt = $db->prepare("UPDATE books SET user_id = NULL WHERE ISBN = :isbn");

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
}
?>