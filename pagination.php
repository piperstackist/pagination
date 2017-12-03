<?php
    $dbname     = 'eduplus1';
 
    $host       = '127.0.0.1';
 
    $pass       = '';
 
    $user       = 'root';
 
    $pdoo       = new PDO("mysql:host=$host;dbname=$dbname",$user,$pass);
 
    $page       = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
 
    define('PER_PAGE', 3);
 
    function results($page, $per_page, $pdo){
 
        $begi       = ($page - 1) * $per_page;
 
        $per_page   = $per_page;
 
        $sql        = 'SELECT * FROM class LIMIT '.$begi.', '.$per_page.'';
 
        $stmt       = $pdo->prepare($sql);
 
        $stmt->execute();
 
        $x          = 1;
 
        while($row = $stmt->fetch()){
 
            echo '<tr>';
 
            echo '<td>'.$x.'</td>';
 
            echo '<td>'.$row['name'] . '</td>';
 
            echo '</tr>';
 
            $x++;
        }
    }
 
    ?>
    <table >
        <thead>
        <th>s/n</th>
        <th>class</th>
        </thead>
        <tbody>
            <?php
                results($page, PER_PAGE, $pdoo);
            ?>
        </tbody>          
    </table>
    <?php
 
    $sql2 = 'SELECT count(id) as tot FROM class';
 
    $st = $pdoo->prepare($sql2);
 
    $st->execute();
     
    $res = $st->fetch();
 
    $total_p = ceil($res['tot'] / PER_PAGE);
 
    $i = 1;
 
    $value = '';
 
    while($i <= $total_p){
 
        $value .= "<a href='?page=".$i."'>".$i."</a> ";
         
        ++$i;       
    }
 
    echo $page == 1 ? null : "<a href='?page=".--$page."'>Prev</a> ";
     
    echo $value;
 
    $p = (isset($_GET['page'])) ? $_GET['page'] : 1;
 
    echo $p >= $total_p ? null : "<a href='?page=" . ( $p + 1 ) . "'>Next</a> "; 
?>