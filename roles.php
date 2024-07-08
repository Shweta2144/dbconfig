<?php
$host = '127.0.0.1';
$db = 'shweta';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
echo "Connected successfully<br>";
} catch (\PDOException $e) {
throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
// Function to register a user
function registerUser($pdo, $username, $password, $role_id) {
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (username, password, role_id) VALUES (:username,
:password, :role_id)";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username, 'password' => $hashed_password,
'role_id' => $role_id]);
echo "User registered successfully<br>";
}
// Function to login a user
function loginUser($pdo, $username, $password) {
$sql = "SELECT users.*, roles.role_name FROM users JOIN roles ON
users.role_id = roles.id WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();
if ($user && password_verify($password, $user['password'])) {
echo "Login successful<br>";
echo "Welcome, " . $user['username'] . "! Your role is: " .
$user['role_name'] . "<br>";
return $user['role_name'];
} else {
echo "Invalid username or password<br>";
return null;
}
}
// Function to check permissions
function checkPermission($role, $required_role) {
$roles_hierarchy = ['viewer' => 1, 'editor' => 2, 'admin' => 3];
if ($roles_hierarchy[$role] >= $roles_hierarchy[$required_role]) {
echo "Permission granted<br>";
} else {
echo "Permission denied<br>";
}
}
$role = loginUser($pdo, 'john_doe', 'password123');
// Check permissions
if ($role) {
checkPermission($role, 'editor'); // Example check
}
?>