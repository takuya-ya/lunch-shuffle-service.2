
  <a href="employee">社員を登録する</a>

  <form action="shuffle" method="post">
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
