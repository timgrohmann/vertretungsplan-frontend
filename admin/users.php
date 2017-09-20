<?php $_title = "Benutzerverwaltung"?>
<?php include("./php/header.php") ?>

<main class="container">
    <h2>Benutzerverwaltung</h2>
    <div class="col-md-12">
        <table class="customtable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>E-Mail</th>
                <th>Schule</th>
                <th>Klasse</th>
            </tr>
            <?php
            $school_list = Data::getSchoolList();
            function getSchool($id,$schools){
                foreach ($schools as $s) {
                    if ($s['_id'] == $id) {
                        return $s['name'];
                    }
                }
                return $id;
            }
            foreach (Data::query('SELECT * FROM users ORDER BY id') as $key => $user): ?>
                <tr>
                    <td><?=$user['id']?></td>
                    <td><?=$user['name']?></td>
                    <td><?=$user['amzn_mail']?></td>
                    <td title="<?=$user['school_id']?>"><?=getSchool($user['school_id'],$school_list)?></td>
                    <td><?=$user['klasse']?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</main>

<?php include("./php/footer.php") ?>
