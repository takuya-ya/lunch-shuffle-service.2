<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>社員の登録</title>
</head>
<body>
  <h1>
    <a href="/">シャッフルランチ</a>
  </h1>

  <h2>社員の登録</h2>

  <?php if (count($errors)) : ?>
    <ul>
      <?php foreach ( $errors as $error): ?>
        <li><?php echo $error ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif ?>

  <form action="employee/create" method="post">
    <div>
      <label for="name">社員名</label>
      <input type="text" name='name'>
    </div>
    <button type="submit">登録する</button>
  </form>

  <h2>社員の一覧</h2>
  <?php foreach ( $employees as $employee): ?>
    <li><?php echo $employee['name'] ?></li>
  <?php endforeach; ?>
  </body>
</html>
