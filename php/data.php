<?php

    include('connection.php');
    $val = $_GET['url'];
    if ($val ==0 )
    {
      $sql = "SELECT DATE_FORMAT(`users`.`account_created_on`, '%d %b %y') AS `date`, COUNT(DATE_FORMAT(`users`.`account_created_on`, '%d %b %y')) AS `count` FROM `users` GROUP BY `date` ORDER BY `account_created_on`;";
      $result = mysqli_query($conn,$sql);
      $result_array = array();
      if ($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          array_push($result_array,[strtotime($row['date'])*1000,(int)$row['count']]);
        }
      }
    }
    else if ($val ==1 )
    {
      $sql = "SELECT DATE_FORMAT(`user_url`.`date`, '%d %b %y') AS `sort_date`, COUNT(DATE_FORMAT(`user_url`.`date`, '%d %b %y')) AS `count` FROM `user_url` GROUP BY `sort_date` ORDER BY `date`;";
      $result = mysqli_query($conn,$sql);
      $result_array = array();
      if ($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          array_push($result_array,[strtotime($row['sort_date'])*1000,(int)$row['count']]);
        }
      }
    }

    else if ($val==2)
    {

      $sql = "SELECT `user_url`.`url` AS `URL` , COUNT(`user_url`.`user`) AS `NoByDomain` FROM `user_url` GROUP BY `user_url`.`url` ORDER BY `user_url`.url";
      $result = mysqli_query($conn,$sql);
      $result_array = array();
      if ($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          array_push( $result_array,[($row['URL']) , (int)$row['NoByDomain']] );
        }
      }

    }

    else if ($val==3)
    {

      $sql = "SELECT `user_url`.`user` AS `user`, COUNT(`user_url`.`url`) AS `NoOfWebsites` FROM `user_url` GROUP BY `user_url`.`user` ORDER BY `user_url`.`user`";
      $result = mysqli_query($conn,$sql);
      $result_array = array();
      if ($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          array_push( $result_array,[($row['user']) , (int)$row['NoOfWebsites']] );
        }
      }

    }
    else if ($val==4)
    {
        $conn = new mysqli($servername, $username, $password,'perfmon');
        $sql = "SELECT `countrycode`, COUNT(`time_zone`) AS 'usersByTimezone', `country`.`country_name` AS 'country' FROM `timezonetable`, `user_details`, `country` WHERE `user_details`.`time_zone` = `timezonetable`.`timezone` AND `country`.`country_code`=`timezonetable`.`countrycode` GROUP BY `user_details`.`time_zone`";
        $result = mysqli_query($conn,$sql);

        $result_array = array();

        if ($result->num_rows > 0)
        {
            $result_array = array();
            while($row = $result->fetch_assoc())
            {
                $r['code']=$row['countrycode'];
                $r['z']=(int)$row['usersByTimezone'];
                $r['country']=$row['country'];
                // $r='code: '.$_SESSION[$row['time_zone']].', z: '.$row['count'].'';
                array_push($result_array,$r);
                // $result_array[]=$r;
            }
        }
    }
    echo json_encode($result_array, JSON_PRETTY_PRINT);


?>
