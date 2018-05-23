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