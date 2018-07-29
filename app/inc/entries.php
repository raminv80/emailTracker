<?php $model = new \App\PixelTrracker();?>
<div class="container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Subject</th>
            <th scope="col">Token</th>
            <th scope="col">Views</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($model->getAll() as $email):?>
            <tr>
                <th scope="row"><?=$email['id']?></th>
                <td><?=$email['subject']?></td>
                <td><?=$email['token']?></td>
                <td><?=$email['views']?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
