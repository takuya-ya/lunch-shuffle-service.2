<h2>社員の登録</h2>

<?php if (count($errors)) : ?>
  <ul>
    <?php foreach ( $errors as $error): ?>
      <li><?php echo $error ?></li>
      <?php endforeach; ?>
    </ul>
    <?php endif ?>

<form action="/employee/create" method="post">
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
