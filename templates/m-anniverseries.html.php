<h2><span style="color:#D77600; font-size:14pt">
        Marriage Anniversaries
    </span>
</h2>
<table style="width: auto"  cellspacing="1" cellpadding="1" border="1">
    <thead>
        <tr>
            <th style="background-color: #EDEDED;">Date</th>
            <th style="background-color: #EDEDED;">Husband</th>
            <th style="background-color: #EDEDED;">Wife</th>
            <th style="background-color: #EDEDED;">Years</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($manniversaries as $manniversary): ?>
            <tr>
                <td><?php echo $manniversary['marrdate']; ?></a></td>
                <td><a href="/family/?personId=<?php echo $manniversary['personid1']; ?>">
                        <?php echo $manniversary['firstname1']; ?><?php echo $manniversary['lastname1']; ?></a></td>
                <td><a href="/family/?personId=<?php echo $manniversary['personid2']; ?>">
                        <?php echo $manniversary['firstname2']; ?><?php echo $manniversary['lastname2']; ?></a></td>
                <td><?php echo $manniversary['Years']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>