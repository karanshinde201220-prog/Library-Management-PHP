<?php $u=current_user(); $isAdmin=$u && $u['role']==='admin'; $base=isset($basePath)?$basePath:'../'; ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e($pageTitle??APP_NAME)?> · <?=APP_NAME?></title><link rel="stylesheet" href="<?=$base?>assets/style.css"></head><body>
