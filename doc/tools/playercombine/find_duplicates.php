<?php

require_once 'config.php';
require_once 'data/db.php';

$min_level = isset($argv[1]) && is_numeric($argv[1]) ? $argv[1] : 5;
echo "# notice: only printing confidence level $min_level or higher\n\n";


function find_sflid_dupes()
{
    $result = db_all("SELECT *,COUNT(*) AS num FROM :User WHERE SflId IS NOT NULL GROUP BY SflId HAVING num > 1");

    if (!$result)
        die("query error: $query");

    $retValue = array();
    if (count($result) == 0)
        return $retValue;

    foreach ($result as $row) {
        $sflid = $row['SflID'];
        if (!$sflid) {
            print_r($row);
            die("debug");
        }

        $res = db_all("SELECT * FROM :User WHERE SflId = $sflid");
        if (!$res) {
            echo "Error with sflid $sflid, moving on...";
            continue;
        }
        $retValue[$sflid] = $res;
    }

    return $retValue;
}


function find_competitions($playerid)
{
    $row = db_one("SELECT Player, COUNT(*) AS Sum FROM :Participation WHERE Player = $playerid");

    if (count($row) == 0)
        return 0;

    return $row['Sum'];
}


function find_latest_competition($playerid)
{
    $row = db_one("SELECT UNIX_TIMESTAMP(SignupTimestamp) AS Signup FROM :Participation WHERE Player = $playerid ORDER BY SignupTimestamp DESC LIMIT 1");

    if (count($row) == 0)
        return 0;

    return $row['Signup'];
}


function find_pdga_numbers($playerid)
{
    $row = db_one("SELECT pdga FROM :Player WHERE player_id = $playerid");
    if (count($row) == 0)
        return null;
    return $row['pdga'];
}



$dupes = find_sflid_dupes();
$players = array();
foreach ($dupes as $sflid => $items) {
    foreach ($items as $data) {
        $pid = $data['Player'];

        $players[$sflid][] = array(
            "player"    => $pid,
            "lastlogin" => $data['LastLogin'],
            "email"     => $data['UserEmail'],
            "name"      => $data['UserFirstName'] . " " . $data['UserLastName'],
            "comps"     => find_competitions($pid),
            "signups"   => find_latest_competition($pid),
            "pdga"      => find_pdga_numbers($pid)
        );
    }
}




$cases = array();
foreach ($players as $sflid => $data) {
    $last_player = $last_login = $likely = $selection = 0;
    $playerids = $emails = $names = $pdgas = $comps = $logins = $signups = array();
    $ids_with_comps = $most_comps = $most_comps_id = 0;

    foreach ($data as $item) {
        $playerid = $item['player'];
        $playerids[] = $playerid;

        if ($item['lastlogin'] > $last_login) {
            $last_player = $playerid;
            $last_login = $item['lastlogin'];
            $selection = "last login";
        }

        if ($item['comps'] > $most_comps) {
            $most_comps = $item['comps'];
            $most_comps_id = $playerid;
        }

        $comps[] = $item['comps'];
        $logins[] = $item['lastlogin'];
        $signups[] = $item['signups'] ? strftime("%Y-%m-%d %H:%M:%S", $item['signups']) : '';
        $emails[] = $item['email'];

        if (!in_array($item['name'], $names))
            $names[] = $item['name'];

        #if (!in_array($item['pdga'], $pdgas))
            $pdgas[] = $item['pdga'];

        if ($item['comps'] > 0)
            $ids_with_comps++;
    }

    if ($last_login == 0 || count(array_filter($logins)) >= 2) {
        if (count(array_filter($comps)) == 1 && $most_comps_id) {
            # one has comps, so take it
            $last_player = $most_comps_id;
            $selection = "most comps";
        }
        elseif (count(array_filter($comps)) == 0) {
            # neither has, so just pick one
            $last_player = $playerids[0];
            $selection = "earliest id";
        }
        else {
            # both/all have comps, so take the one that has latest comp
            $last_time = $last_pid = 0;
            foreach ($playerids as $pid) {
                $time = find_latest_competition($pid);
                if ($time > $last_time) {
                    $last_time = $time;
                    $last_pid = $pid;
                }
            }

            $last_player = $last_pid;
            $selection = "last comp";
        }
    }


    $like = array();
    // Names match
    if (count($names) == 1)
        $like[] = "name";

    // Email match
    if (count(array_unique($emails)) == 1)
        $like[] = "email";

    // All have pdga set and it matches
    if (count(array_unique($pdgas)) == 1 && $pdgas[0])
        $like[] = "pdga";

    // Only one id has competitions
    if ($ids_with_comps == 1)
        $like[] = "comps";

    // Only one has logged in since 2015
    if (count(array_filter($logins)) == 1)
        $like[] = "logins";

    // Last account logged in has the most comps
    if ($most_comps_id == $last_player)
        $like[] = "login-comps";

    $likely = count($like);
    $o = implode(array_diff($playerids, array($last_player)), ",");
    $i = implode($playerids, ", ");
    $n = implode($names, ", ");
    $e = implode($emails, ", ");
    $p = implode($pdgas, ", ");
    $c = implode($comps, ", ");
    $l = implode($like, ", ");
    $ll = implode($logins, ", ");
    $s = implode($signups, ", ");

    if ($likely >= $min_level)
        print "
#  sflid: $sflid
# confid: $likely ($l)
#  names: $n
# emails: $e
#  pdgas: $p
# plrids: $i
#  comps: $c
# logins: $ll
# signup: $s
# reason: $selection
./doc/tools/playercombine/combine.sh $last_player $o
";

}
