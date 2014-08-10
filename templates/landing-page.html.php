<span style="color:#D77600; font-size:14pt">
    <?php echo $date; ?>
</span>
<table>
    <tr>
        <td><img src="<?php echo $profileImage; ?>" class='profile-image' /></td>
        <td>
            <span style="color:#D77600; font-size:14pt">			
                Welcome
                <a href="/family/?personId=<?php echo $personId; ?>">
                    <?php echo $name; ?>
                </a>
                to Upavadi Family Site
            </span>
            <h2>
                <span style="color:#D77600; font-size:14pt">			
                    Events for Yesterday, Today and Tomorrow<br />
                </span>
            </h2>
        </td>
</table>
<table>
    <tr>
        <td style="vertical-align: top;">
            <?php include('birthdays.html.php'); ?>
        </td>
        <td style="vertical-align: top;">
            <?php include('m-anniverseries.html.php'); ?>
        </td>
        <td style="vertical-align: top;">
            <?php include('d-anniverseries.html.php'); ?>
        </td>
    </tr>
</table>