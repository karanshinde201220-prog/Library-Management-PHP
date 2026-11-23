<?php
// Run from terminal: php seed_admin.php
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Run this script from the command line only.'); }
require __DIR__.'/includes/bootstrap.php';
$email='admin@library.local';$username='admin';$password='admin123';
$s=$pdo->prepare('SELECT id FROM users WHERE username=? OR email=? LIMIT 1');$s->execute([$username,$email]);$id=$s->fetchColumn();
if($id){$pdo->prepare("UPDATE users SET role='admin',is_active=1 WHERE id=?")->execute([$id]);echo "Admin account already exists; role enabled. Existing password was not changed.\n";}
else{$pdo->prepare("INSERT INTO users(name,email,username,password_hash,role) VALUES('Library Administrator',?,?,?,'admin')")->execute([$email,$username,password_hash($password,PASSWORD_DEFAULT)]);echo "Admin created. Username: admin | Password: admin123\n";}
