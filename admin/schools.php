<?php $_title = "Schulverwaltung"?>
<?php include("./php/header.php") ?>

<?php if (isset($the_school['name']) && isset($_POST['name']) && isset($_POST['plan_url'])){
    Data::query('UPDATE schools SET name=:name, plan_url=:plan_url WHERE id=:id', array(':name' => $_POST['name'], ':plan_url' => $_POST['plan_url'], ':id' => $the_school['id']));
    ?>
    <script type="text/javascript">
        location.reload();
    </script>
    <?
} ?>

<main class="container">
    <h2>Schulverwaltung</h2>
    <?php if (!isset($the_school['name'])): ?>
    <div class="col-md-12">
        <table class="customtable">
            <tr>
                <th>Schulname</th>
                <th>Plan URL</th>
            </tr>
            <?php foreach (Data::getSchoolList() as $key => $school): ?>
                <tr>
                    <td title="<?=$school['_id']?>"><?=$school['name']?></td>
                    <td><a href="<?=$school['plan_url']?>"><?=$school['plan_url']?></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php else: ?>
        <hr>
        <h4><?=$the_school['name']?></h4>
        <form class="schoolform" action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?=$the_school['name']?>">
            <label for="url">Plan URL:</label>
            <input type="text" name="plan_url" value="<?=$the_school['plan_url']?>">

            <button class="center-block btn btn-default" type="submit">Änderungen bestätigen!</button>
        </form>
    <?php endif; ?>
</main>

<?php include("./php/footer.php") ?>
