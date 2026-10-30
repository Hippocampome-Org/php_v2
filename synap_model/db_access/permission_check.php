<?php   
include ("access_db.php");
$perm = $_SESSION['perm'] ?? null;
if ($perm == NULL) {
        //Changed from here on Feb 8 2026
        $query = "SELECT permission FROM user WHERE id = '2'";
        $rs = mysqli_query($GLOBALS['conn'],$query);
        while (list($permission) = mysqli_fetch_row($rs)) {
                if ($permission == 1) {
                        $anonymous = 1;
                }
                else {
                        $anonymous = 0;
                }
        }
        if ($anonymous == 0) {
                header("Location:error1.html");
        } 
}
?>
