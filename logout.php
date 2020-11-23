<?php
    require_once 'header.php';

    echo'
    <meta http-equiv="Refresh" content="0;url=login.php">
    ';

    if (isset($_SESSION['user']))
    {
        destroySession();
    }
    else
    {

    }

    echo'

    </body>

    </html>
    ';