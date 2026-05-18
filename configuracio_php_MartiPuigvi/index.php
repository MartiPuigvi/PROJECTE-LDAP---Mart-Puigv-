<?php
/**
 * Script d'autenticació contra servidor LDAP
 * Projecte: marti.com
 */

$ldap_server = "localhost";
$base_dn = "dc=marti,dc=com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // 1. Connexió al servidor
    $ldap_conn = ldap_connect($ldap_server);
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

    // 2. Construïm el DN de l'usuari amb la teva estructura real (cn i ou=usuaris)
    $user_dn = "cn=$user,ou=usuaris,$base_dn";

    // 3. Intentem l'autenticació
    if (@ldap_bind($ldap_conn, $user_dn, $pass)) {
        // Assegura't que el teu fitxer d'èxit es diu exit.php (o canvia-ho per success.html si el tens així)
        header("Location: exit.php");
        exit();
    } else {
        echo "<script>alert('Error: Usuari o contrasenya incorrectes'); window.location='index.php';</script>";
    }
    
    ldap_close($ldap_conn);
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Login - marti.com</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f0f2f5; }
        .login-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 320px; }
        h2 { text-align: center; margin-bottom: 20px; color: #333; }
        .error-msg { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 0.9em; text-align: center; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #0056b3; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; }
        button:hover { background-color: #004085; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Portal marti.com</h2>
    
    <?php if (!empty($error)): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Usuari:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Contrasenya:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Iniciar Sessió</button>
    </form>
</div>

</body>
</html>
