<?php
session_start();
    $db = mysqli_connect("localhost","root","","twitter");
    if(mysqli_connect_errno()){
        print_r(mysqli_connect_errno());
        exit();
    }

    if(isset($_GET["function"])) {
        if($_GET["function"] == "logout") {
            session_unset();
        }
    }

    function time_since($since) {
        $chunks = array(
            array(60 * 60 * 24 * 365 , 'year'),
            array(60 * 60 * 24 * 30 , 'month'),
            array(60 * 60 * 24 * 7, 'week'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60 , 'hour'),
            array(60 , 'min'),
            array(1 , 's')
        );
    
        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($since / $seconds)) != 0) {
                break;
            }
        }
    
        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
        return $print;
    }

    function displayTweets($type){
        $whereClause = "";
        global $db;
        if ($type == 'public'){
          
        } else if ($type == 'isFollowing'){
            if(isset($_SESSION['id'])){
            $query = "SELECT * FROM `isfollowing` WHERE `follower` = ".mysqli_real_escape_string($db, $_SESSION['id']);
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result) == '0'){
                $whereClause = " WHERE `userid` = -1 ";
            } else {
                $whereClause = "";
                while ($row = mysqli_fetch_assoc($result)){
                    if($whereClause == "") {
                        $whereClause = "WHERE";
                    } else {
                        $whereClause .= " OR ";
                    }
                    $whereClause .= " `userid` = ".$row['isFollowing'];
                }
                }                
            } 
        } else if($type == 'yourtweets'){
            if(isset($_SESSION['id'])){
                $whereClause = "WHERE userid = ". mysqli_real_escape_string($db, $_SESSION['id']);
            }
            
        } else if ($type == 'search'){
            echo '<p>Showing search results for "'.mysqli_real_escape_string($db, $_GET['q']).'":</p>';
            $whereClause = "WHERE tweet LIKE '%". mysqli_real_escape_string($db, $_GET['q'])."%'";
        } else if (is_numeric($type)) {
            $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($db, $type)." LIMIT 1";
                $userQueryResult = mysqli_query($db, $userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);
            echo "<h2>".mysqli_real_escape_string($db, $user['email'])."'s Tweets</h2>";
            $whereClause = "WHERE userid = ". mysqli_real_escape_string($db, $type);
            
            
        }

        $query = "SELECT * FROM `tweets` ".$whereClause." ORDER BY `datetime` DESC LIMIT 10";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) == 0){
            echo "There are no tweets to display";
        } else {
            while ($row = mysqli_fetch_assoc($result)){
                $userQuery = "SELECT * FROM `users` WHERE id = ".mysqli_real_escape_string($db, $row['userid'])." LIMIT 1";
                $userQueryResult = mysqli_query($db, $userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);
                echo "<div class='tweet'><p>".$user['email']." <span class='time'>".time_since(time() - strtotime($row['datetime']))." ago</span></p>";
                echo "<p>".$row['tweet']."</p>";
                echo "<p><a class='toggleFollow' href='#' data-userId='".$row['userid']."'>";
                if(isset($_SESSION['id'])){
                    $isFollowingQuery = "SELECT * FROM `isfollowing` WHERE `follower` = ".mysqli_real_escape_string($db,isset($_SESSION['id']))." AND `isFollowing` = ".mysqli_real_escape_string($db, isset($row['userid']))." LIMIT 1";
                    $isFollowingQueryresult = mysqli_query($db, $isFollowingQuery);
                    //print_r(mysqli_num_rows($isFollowingQueryresult));
                    if (mysqli_num_rows($isFollowingQueryresult) > 0) {
                        echo "Unfollow";
                    } else {
                        echo "Follow";
                    }
                }
               
                echo "</a></p></div>";
            }
        }
    }

function displaySearch() {
        
    echo '<form class="form-inline">
    <div class="form-group">
      <input type="hidden" name="page" value="search">
      <input type="text" name="q" class="form-control" id="search" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-primary">Search Tweets</button>
  </form>';    
    
}
function displayTweetBox() {
        
    if (isset($_SESSION['id'])) {
        if($_SESSION['id'] > 0){
        
        echo '<div id="tweetSuccess" class="alert alert-success">Your tweet was posted successfully.</div>
        <div id="tweetFail" class="alert alert-danger"></div>
        <div class="form">
        <div class="form-group">
        <textarea class="form-control" id="tweetContent"></textarea>
        </div>
        <button id="postTweetButton" class="btn btn-primary">Post Tweet</button>
    </div>';      
        }  
    }
}

function displayUsers() {
        
    global $db; 
    $query = "SELECT * FROM users LIMIT 10";  
    $result = mysqli_query($db, $query);   
    while ($row = mysqli_fetch_assoc($result)) {  
        echo "<p><a href='?page=publicprofiles&userid=".$row['id']."'>".$row['email']."</a></p>";      
    }
    
    
    
}


?>