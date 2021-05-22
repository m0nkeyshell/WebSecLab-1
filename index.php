<?php

    include("functions.php");

    include("views/header.php");

    if (isset($_GET['page']) == 'timeline') {
        
        include("views/timeline.php");
        
    } else if (isset($_GET['page']) == 'yourtweets') {
        
        include("views/yourtweets.php");
        
    } else if (isset($_GET['page']) == 'search') {
        
        include("views/search.php");
        
    } else if (isset($_GET['page']) == 'publicprofiles') {
        
        include("views/publicprofiles.php");
        
    } else {

        include("views/home.php");
        
    }
        
    include("views/footer.php");


?>