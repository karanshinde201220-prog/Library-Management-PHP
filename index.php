<?php require __DIR__.'/includes/bootstrap.php'; if(!current_user()) redirect('login.php'); redirect(current_user()['role']==='admin'?'admin/index.php':'member/index.php');
