<!DOCTYPE html>
<html lang="en" class="<?= $htmlClass ?? '' ?>">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/img/logo_bukoo.png" rel="apple-touch-icon" sizes="180x180">
  <link type="image/png" href="assets/img/logo_bukoo.png" rel="icon" sizes="32x32">
  <link type="image/png" href="assets/img/logo_bukoo.png" rel="icon" sizes="16x16">
  <link href="assets/img/favicon/site.webmanifest" rel="manifest">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css?v=<?= time(); ?>" rel="stylesheet">
  <title><?= $title ?? 'Bukoo' ?></title>
</head>

<body class="<?= $bodyClass ?? '' ?>">