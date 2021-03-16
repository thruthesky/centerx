
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">TITLE</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach( post()->list(SHOPPING_MALL, limit: 200) as $post ) { ?>
        <tr>
            <td><a href="/?p=admin.index&w=shopping-mall/admin-shopping-mall&cw=edit&idx=<?=$post->idx?>"><?=$post->idx?></a></td>
            <td><?=$post->title?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>