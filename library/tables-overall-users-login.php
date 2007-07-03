<?php
/*******************************************************************
* Extension name: graph-user_login_overall.php                     *
*                                                                  *
* Description:    this graph extension procduces a query of the    *
* overall logins made by a particular user on a daily, monthly,    *
* and yearly basis.                                                *
*                                                                  *
* Author: Liran Tal <liran@enginx.com>                             *
*                                                                  *
*******************************************************************/



if ($type == "daily") {
	daily($username);
} elseif ($type == "monthly") {
	monthly($username);
} elseif ($type == "yearly") {
	yearly($username);
}



function daily($username) {

	include 'library/config.php';
	include 'library/opendb.php';
        include 'libgraph/graphs.inc.php';

        $sql = "SELECT UserName, count(AcctStartTime), DAY(AcctStartTime) AS Day from radacct where username='$username' group by Day;";
        $res = mysql_query($sql) or die('Query failed: ' . mysql_error());

	$total_logins = 0;		// initialize variables
	$count = 0;			

        $array_logins = array();
        $array_days = array();

	$user = "";
        while($ent = mysql_fetch_array($res)) {

		// The table that is being procuded is in the format of:
		// +----------+----------------------+------+
		// | UserName | count(AcctStartTime) | Day  |
		// +----------+----------------------+------+

        	$user = $ent[0];	// username
        	$logins = $ent[1];	// total logins on that specific day
        	$day = $ent[2];		// day of the month [1-31]

		$total_logins = $total_logins + $logins;
		$count = $count + 1;

                array_push($array_logins, "$logins");
                array_push($array_days, "$day");

        }
	
	echo "<br/> <center> <h4>Logins/Hits statistics for user $user</h4> <br/> </center> ";

        echo "<br/><br/>";

        echo "<table border='2' class='table1'>\n";
        echo "
                        <thead>
                                <tr>
                                <th colspan='10'>Logins/Hits statistics</th>
                                </tr>
                        </thead>
                ";
        echo "<thread> <tr>
                        <th scope='col'> Username </th>
                        <th scope='col'> Logins/Hits count </th>
                        <th scope='col'> Day of month </th>
                </tr> </thread>";


        $i=0;
        foreach ($array_days as $a_day) {
                echo "<tr>
			<td> $user </td>
                        <td> $array_logins[$i] </td>
                        <td> $a_day </td>
                </tr>";

                $i++;
        }


	echo "</table>";

	echo "<br/> Total hits of <u>$total_logins</u> for user: <u>$user</u> <br/>";

        mysql_free_result($res);
        include 'library/closedb.php';
}





function monthly($username) {

	include 'library/config.php';
	include 'library/opendb.php';
        include 'libgraph/graphs.inc.php';

        $sql = "SELECT UserName, count(AcctStartTime), MONTHNAME(AcctStartTime) AS Month from radacct where username='$username' group by Month;";
        $res = mysql_query($sql) or die('Query failed: ' . mysql_error());

	$total_logins = 0;		// initialize variables
	$count = 0;			

        $array_logins = array();
        $array_months = array();

        $user = "";

        while($ent = mysql_fetch_array($res)) {

		// The table that is being procuded is in the format of:
		// +----------+----------------------+--------+
		// | UserName | count(AcctStartTime) | Month  |
		// +----------+----------------------+--------+

        	$user = $ent[0];	// username
        	$logins = $ent[1];	// total logins on that specific month
        	$month = $ent[2];		// Month of year [1-12]

		$total_logins = $total_logins + $logins;
		$count = $count + 1;

                array_push($array_logins, "$logins");
                array_push($array_months, "$month");

        }

        echo "<br/> <center> <h4>Logins/Hits statistics for user $user</h4> <br/> </center> ";

        echo "<br/><br/>";


        echo "<table border='2' class='table1'>\n";
        echo "
                        <thead>
                                <tr>
                                <th colspan='10'>Logins/Hits statistics</th>
                                </tr>
                        </thead>
                ";
        echo "<thread> <tr>
                        <th scope='col'> Username </th>
                        <th scope='col'> Logins/Hits count </th>
                        <th scope='col'> Month of year </th>
                </tr> </thread>";

        $i=0;
        foreach ($array_months as $a_month) {
                echo "<tr>
			<td> $user </td>
                        <td> $array_logins[$i] </td>
                        <td> $a_month </td>
                </tr>";

                $i++;
        }


	echo "</table>";

	echo "<br/> Total hits of <u>$total_logins</u> for user: <u>$user</u> <br/>";

        mysql_free_result($res);
        include 'library/closedb.php';
}








function yearly($username) {

	include 'library/config.php';
	include 'library/opendb.php';
        include 'libgraph/graphs.inc.php';


        $sql = "SELECT UserName, count(AcctStartTime), YEAR(AcctStartTime) AS Year from radacct where username='$username' group by Year;";
        $res = mysql_query($sql) or die('Query failed: ' . mysql_error());

	$total_logins = 0;		// initialize variables
	$count = 0;			

        $array_logins = array();
        $array_years = array();

        $user = "";

        while($ent = mysql_fetch_array($res)) {


		// The table that is being procuded is in the format of:
		// +----------+----------------------+-------+
		// | UserName | count(AcctStartTime) | Year  |
		// +----------+----------------------+-------+

        	$user = $ent[0];	// username
        	$logins = $ent[1];	// total logins on that specific month
        	$year = $ent[2];	// Year

		$total_logins = $total_logins + $logins;
		$count = $count + 1;

                array_push($array_logins, "$logins");
                array_push($array_years, "$year");

        }
        echo "<br/> <center> <h4>Logins/Hits statistics for user $user</h4> <br/> </center> ";

        echo "<br/><br/>";

        echo "<table border='2' class='table1'>\n";
        echo "
                        <thead>
                                <tr>
                                <th colspan='10'>Logins/Hits statistics</th>
                                </tr>
                        </thead>
                ";
        echo "<thread> <tr>
                        <th scope='col'> Username </th>
                        <th scope='col'> Logins/Hits count </th>
                        <th scope='col'> Year </th>
                </tr> </thread>";
        $i=0;
        foreach ($array_years as $a_year) {
                echo "<tr>
			<td> $user </td>
                        <td> $array_logins[$i] </td>
                        <td> $a_year </td>
                </tr>";

                $i++;
        }

 
	echo "</table>";

	echo "<br/> Total hits of <u>$total_logins</u> for user: <u>$user</u> <br/>";

        mysql_free_result($res);
        include 'library/closedb.php';
}


?>