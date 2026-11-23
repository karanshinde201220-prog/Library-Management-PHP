<?php
require_once __DIR__ . '/../config.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('libra_session');
    session_set_cookie_params(['httponly'=>true, 'samesite'=>'Lax', 'secure'=>!empty($_SERVER['HTTPS'])]);
    session_start();
}
try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed. Check config.php and import sql/schema.sql. Details: '.htmlspecialchars($e->getMessage()));
}
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function redirect(string $to): never { header('Location: '.$to); exit; }
function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function verify_csrf(): void { if ($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Invalid session token. Refresh and try again.'); } }
function flash(string $type, string $message): void { $_SESSION['flash']=['type'=>$type,'message'=>$message]; }
function show_flash(): void { if (!empty($_SESSION['flash'])) { $f=$_SESSION['flash']; echo '<div class="alert '.e($f['type']).'">'.e($f['message']).'</div>'; unset($_SESSION['flash']); } }
function current_user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): void { if (!current_user()) redirect('../login.php'); }
function require_admin(): void { require_login(); if (current_user()['role']!=='admin') { http_response_code(403); exit('Access denied. Administrator permission required.'); } }
function require_member(): void { require_login(); if (current_user()['role']!=='member') { http_response_code(403); exit('This page is for member accounts.'); } }
function audit(PDO $pdo, string $action, string $details=''): void { $s=$pdo->prepare('INSERT INTO audit_logs(user_id,action,details) VALUES(?,?,?)'); $s->execute([current_user()['id']??null,$action,$details]); }
function money($n): string { return '₹'.number_format((float)$n,2); }
function overdue_days(string $dueDate): int { $due=new DateTimeImmutable($dueDate); $today=new DateTimeImmutable('today'); return max(0,(int)$due->diff($today)->format('%r%a')); }
function setting(PDO $pdo,string $key,$default=null) { $s=$pdo->prepare('SELECT setting_value FROM settings WHERE setting_key=?');$s->execute([$key]);$v=$s->fetchColumn();return $v===false?$default:$v; }
