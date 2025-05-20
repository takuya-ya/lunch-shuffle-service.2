<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>シャッフルランチ</title>
</head>
<body>
  <h1>
    <a href="./index.php">シャッフルランチ</a>
  </h1>
  <a href="employee.php">社員を登録する</a>

  <form action="index.php" method="post">
      <button type="submit">シャッフルする</button>
  </form>

  <?php foreach ($groups as $i => $group) :?>
      <h3>
        <?php echo "グループ$i";?>
      </h3>
    <p>
        <!-- echoの改行が、半角空白として扱われて表示される。HTMLでは改行・タブ・スペースはすべて「空白1つ」扱い -->
        <?php foreach ($group as $employee): ?>
            <?php echo $employee['name'] ;?>
        <?php endforeach?>
    </p>

  <?php endforeach ?>

</html>
