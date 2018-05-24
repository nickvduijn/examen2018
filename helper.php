<?php
/**
 * class Helper
 * Deze helper is er voor bedoelt om makkelijker data op te halen en om
 * wat makkelijker de ontwikkeling in te gaan met zelfgeschreven methodes.
 */

class Helper {
    // Algemene error variable (voor berichten)
    public $error;

    /*
     * method debug() zorgt ervoor dat ik makkelijk arrays en/of objecten kan debuggen.
     * $args is de array of object die debugged moet worden.
     */

    public static function debug($args) {
        echo '<pre>';
        print_r($args);
        echo '</pre>';
        die;
    }
    /*
     * method login() zorgt ervoor dat er wordt gechecked of de juiste login gegevens zijn toegevoegd.
     * $mysqli is nodig voor de verbinding met de database.
     * $email is het ingevulde e-mailadres.
     * $password is het ingevulde wachtwoord.
     */
    public function login($mysqli, $email, $password) {
        // Tegen SQL injectie
        $email = mysqli_real_escape_string($mysqli, $email);
        $password = mysqli_real_escape_string($mysqli, $password);

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($mysqli, $sql);
        // Check of er een resultaat is gevonden, zoja dan wordt er gekeken of het wachtwoord klopt.
        if(mysqli_num_rows($result) > 0) {
            $data = $this->format_data($result);
            if (password_verify($password, $data[0]['password'])) {
                return $data[0];
            } else {
                $this->error = "Het ingevulde wachtwoord is helaas fout!";
            }
        } else {
            $this->error = "Het ingevulde e-mailadres bestaat nog niet!";
        }

        return $this->error;
    }

    /*
     * method save() is een functie dat wordt gebruikt om data op te slaan of om bij te werken.
     * $mysqli is nodig voor verbinding met de database
     * $type is om te onderscheiden welke query die moet gebruiken omdat het verschillende tabellen zijn.
     * $data is de POST die wordt meegegeven met ingevulde data.
     */
    public function save($mysqli, $type, $data) {
        switch($type) {
            case 'student':
                $sql = "INSERT INTO users (email, password, class, fullname, company_id, group_id) VALUES ('".$data['email']."', '".password_hash($data['password'], PASSWORD_DEFAULT)."', '".$data['class']."', '".$data['fullname']."', '".$data['company_id']."', 1)";
                break;
            case 'student_update':
                $sql = "UPDATE users SET email='".$data['email']."', password='".$data['password']."', class='".$data['class']."', fullname='".$data['fullname']."', company_id='".$data['company_id']."' WHERE id = ".$data['id'];
                break;
            case 'company':
                $sql = "INSERT INTO companies (name, street, postal, city, contact_name, contact_email, website) VALUES ('".$data['name']."', '".$data['street']."', '".$data['postal']."', '".$data['city']."', '".$data['contact_name']."', '".$data['contact_email']."', '".$data['website']."')";
                break;
            case 'company_update':
                $sql = "UPDATE companies SET name='".$data['name']."', street='".$data['street']."', postal='".$data['postal']."', city='".$data['city']."', contact_name='".$data['contact_name']."' , contact_email='".$data['contact_email']."', phone='".$data['phone']."', website='".$data['website']."' WHERE id = ".$data['id'];
                break;
            case 'experience':
                $sql = "INSERT INTO experiences (title, body, rating, created, company_id, created_by_id) VALUES ('".$data['title']."', '".$data['body']."', '".$data['rating']."', NOW(), '".$data['company_id']."', '".$data['created_by_id']."')";
                break;
        }

        $result = mysqli_query($mysqli, $sql);

        if($result){
            return true;
        } else {
            return false;
        }
    }

    public function delete($mysqli, $type, $data) {
        switch($type) {
            case 'student':
                $sql = "DELETE FROM users WHERE id = " . $data['id'];
                break;
            case 'company':
                $sql = "DELETE FROM companies WHERE id = " . $data['id'];
                break;
        }

        $result = mysqli_query($mysqli, $sql);

        if($result){
            return true;
        } else {
            return false;
        }
    }

    public function getAllStudents($mysqli) {
        $sql = "SELECT * FROM users WHERE group_id = 1";
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            return $this->format_data($result);
        } else {
            return false;
        }
    }

    public function getAllCompanies($mysqli) {
        $sql = "SELECT * FROM companies";
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            return $this->format_data($result);
        } else {
            return false;
        }
    }

    public function getUserById($mysqli, $id) {
        $sql = "SELECT * FROM users WHERE id = " . (int) $id;
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            return $this->format_data($result);
        } else {
            return false;
        }
    }

    public function getCompanyById($mysqli, $id) {
        $sql = "SELECT * FROM companies WHERE id = " . (int) $id;
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            return $this->format_data($result);
        } else {
            return false;
        }
    }

    public function getPostByUserId($mysqli, $userid) {
        $sql = "SELECT * FROM experiences WHERE created_by_id = " . (int) $userid;
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            return $this->format_data($result);
        } else {
            return false;
        }
    }

    public function getAllExperiences($mysqli) {
        $sql = "SELECT * FROM experiences GROUP BY company_id";
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            return $this->format_data($result);
        } else {
            return false;
        }
    }

    public function getExperienceById($mysqli, $id) {
        $sql = "SELECT * FROM experiences WHERE id = " . (int) $id;
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            return $this->format_data($result);
        } else {
            return false;
        }
    }

    public function getExperienceByCompanyId($mysqli, $companyId) {
        $sql = "SELECT * FROM experiences WHERE company_id = " . (int) $companyId;
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            return $this->format_data($result);
        } else {
            return false;
        }
    }

    public function avarageExperienceByCompanyId($mysqli, $companyId) {
        $sql = "SELECT avg(rating) as avarage FROM experiences WHERE company_id = " . (int) $companyId;
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            return $this->format_data($result);
        } else {
            return false;
        }
    }

    /*
     * method format_data() zet data die komt uit de database om naar een gehele array.
     * $result is het resultaat waaruit het array moet ontstaan.
     */
    public function format_data($result) {
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {
            array_push($data, $row);
        }

        return $data;
    }

}