<?php


$ldap_server = "localhost";
$base_dn = "dc=marti,dc=com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $ldap_conn = ldap_connect($ldap_server);
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

    $user_dn = "cn=$user,ou=usuaris,$base_dn";

    if (@ldap_bind($ldap_conn, $user_dn, $pass)) {
        header("Location: exit.html");
        exit();
    } else {
        echo "<script>alert('Error: Usuari o contrasenya incorrectes'); window.location='index.html';</script>";
    }
    ldap_close($ldap_conn);
}
?>
