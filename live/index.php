<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Live scoring output for presentation/mobile
 *
 * --
 *
 * This file is part of Kisakone.
 * Kisakone is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kisakone is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Kisakone.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


# setup epiphany
require_once 'epiphany/src/Epi.php';
Epi::setPath('base', 'epiphany/src');
Epi::init('route', 'database');

# setup configs and database
require_once '../config.php';
global $settings;
$settings['DB_TYPE'] = 'mysql';
EpiDatabase::employ($settings['DB_TYPE'], $settings['DB_DB'], $settings['DB_ADDRESS'], $settings['DB_USERNAME'], $settings['DB_PASSWORD']);
require_once '../data/db_init.php';

# setup routes
getRoute()->get('/', 'live_index');
getRoute()->get('/(\d+)', 'live_event');
getRoute()->get('.*', 'live_not_found');
getRoute()->run();


/**
 * Query results for a round
 *
 * @param  int $round round id
 * @return array of data
 */
function GetRoundResults($round)
{
    $round = esc_or_null($round, 'int');

    $rows = getDatabase()->all(format_query("
SELECT :Player.player_id AS PlayerId, :Player.firstname AS FirstName, :Player.lastname AS LastName,
    :Player.pdga AS PDGANumber, :PDGAPlayers.rating AS Rating, :RoundResult.Result AS Total,
    :RoundResult.Penalty, :RoundResult.SuddenDeath,
    :StartingOrder.GroupNumber, (:HoleResult.Result - :Hole.Par) AS Plusminus, Completed,
    :HoleResult.Result AS HoleResult, :Hole.id AS HoleId, :Hole.HoleNumber, :RoundResult.PlusMinus AS RoundPlusMinus,
    :Classification.Name AS ClassName, CumulativePlusminus, CumulativeTotal, :RoundResult.DidNotFinish,
    :Classification.id AS Classification, :Club.ShortName AS ClubName,
    :PDGAPlayers.country AS PDGACountry
FROM :Round
LEFT JOIN :Section ON :Round.id = :Section.Round
LEFT JOIN :StartingOrder ON (:StartingOrder.Section = :Section.id)
LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
LEFT JOIN :HoleResult ON (:HoleResult.RoundResult = :RoundResult.id AND :HoleResult.Player = :StartingOrder.Player)
LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
LEFT JOIN :User ON :Player.player_id = :User.Player
LEFT JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
LEFT JOIN :Classification ON :Classification.id = :Participation.Classification
LEFT JOIN :Hole ON :HoleResult.Hole = :Hole.id
LEFT JOIN :Club ON :Participation.Club = :Club.id
LEFT JOIN :PDGAPlayers ON :Player.pdga = :PDGAPlayers.pdga_number
WHERE :Round.id = $round AND :Section.Present
ORDER BY
    (:RoundResult.DidNotFinish IS NULL OR :RoundResult.DidNotFinish = 0) DESC,
    :Hole.id IS NULL, :RoundResult.CumulativePlusminus, :Player.player_id
"));

    $retValue = array();
    $lastrow = null;

    foreach ($rows as $row) {
        if (!$row['PlayerId'])
            continue;

        if (@$lastrow['PlayerId'] != $row['PlayerId']) {
            if ($lastrow) {
                $class = $lastrow['ClassName'];
                if (!isset($retValue[$class]))
                    $retValue[$class] = array();

                $retValue[$class][] = $lastrow;
            }
            $lastrow = $row;
            $lastrow['Results'] = array();
            $lastrow['TotalPlusMinus'] = $lastrow['Penalty'];
        }

        $lastrow['Results'][$row['HoleNumber']] = array('Hole' => $row['HoleNumber'], 'HoleId' => $row['HoleId'], 'Result' => $row['HoleResult']);
        $lastrow['TotalPlusMinus'] += $row['Plusminus'];
    }

    if ($lastrow) {
        $class = $lastrow['ClassName'];
        if (!isset($retValue[$class]))
            $retValue[$class] = array();

        $retValue[$class][] = $lastrow;
    }

    foreach ($retValue as $k => $v)
        $retValue[$k] = CalculateStandings($v);

    return $retValue;
}


/**
 * Query db for rounds in an event
 *
 * @param  int $event event id
 * @return array of data
 */
function GetRounds($event)
{
    $event = esc_or_null($event, 'int');

    return getDatabase()->all(format_query("SELECT id FROM :Round WHERE Event = $event ORDER BY StartTime"));
}


/**
 * Get list of active events as html drop-down
 *
 * @return html output with select drop-down
 */
function GetEventSelector()
{
    $start = time() - 7*24*60*60;
    $end = time() + 7*24*60*60;

    $events = getDatabase()->all(format_query("
SELECT id, Name
FROM :Event
WHERE Date BETWEEN FROM_UNIXTIME($start) AND FROM_UNIXTIME($end)
ORDER BY Date, id
"));

    $data = <<<EOF
        <label for="event">Choose event:</label>
        <select id="event" name="event">
            <option value="">---</option>
EOF;

    foreach ($events as $event) {
        $data .= '<option value="' . $event['id'] . '">' . $event['Name'] . '</option>' . "\n";
    }
    $data .= '        </select>' . "\n";
    $data .= <<<EOF
            <script>
            $('#event').change(function() {
                var url = $('#event').val();
                $(location).attr('href', url);
            });
            </script>
EOF;

    return $data;
}


/**
 * Create a drop-down for rounds in an event
 *
 * @param int $event event id
 * @return html code with drop-down
 */
function GetRoundSelector($event)
{
    $event = esc_or_null($event, 'int');
    $prev_round = @$_GET['round'];

    $rounds = GetRounds($event);
    $data = <<<EOF
    <label for="round">Round:</label>
    <select id="round" name="round">
EOF;

    $round_idx = 1;

    foreach ($rounds as $round) {
        $data .= '<option value="' . $round['id'] . '"' .
            ($prev_round == $round['id'] ? ' selected="selected"' : '') . '>Round ' . $round_idx++ . '</option>' . "\n";
    }

    $data .= <<<EOF
    </select>
    <script defer="defer">$("#round").change(function() { $("#filter-form").submit(); });</script>
EOF;

    return $data;
}


/**
 * Create a drop-down for classes in an event
 *
 * @param int $event event id
 * @return html code with drop-down
 */
function GetClassSelector($event)
{
    $event = esc_or_null($event, 'int');
    $prev_class = @$_GET['class'];

    $classes = getDatabase()->all(format_query("
SELECT :Classification.id AS id, Name
FROM :Classification
INNER JOIN :ClassInEvent ON (:ClassInEvent.Event = $event AND :ClassInEvent.Classification = :Classification.id)
ORDER BY :Classification.id
"));

    $data = <<<EOF
    <label for="class">Class:</label>
    <select id="class" name="class">
        <option value="">---</option>
EOF;

    foreach ($classes as $class) {
        $data .= '<option value="' . $class['id'] . '"' .
            ($prev_class == $class['id'] ? ' selected="selected"' : '') . '>' . $class['Name'] . '</option>' . "\n";
    }

    $data .= <<<EOF
    </select>
    <script defer="defer">$("#class").change(function() { $("#filter-form").submit(); });</script>
EOF;

    return $data;
}


/**
 * Create a drop-down for scrollspeed
 *
 * @return html code with drop-down
 */
function GetScrollSelector()
{
    return <<<EOF
    <label for="scroll">Scrolling:</label>
    <select id="scroll" name="presentation">
        <option value="">---</value>
        <option value="10">Really fast</option>
        <option value="20">Fast</value>
        <option value="40">Medium</value>
        <option value="60">Slow</value>
        <option value="90">Really slow</value>
    </select>
    <script defer="defer">$("#scroll").change(function() { $("#filter-form").submit(); });</script>
EOF;
}


function GetEventData($event)
{
    return getDatabase()->one(format_query("SELECT id, Name FROM :Event WHERE id = $event"));
}


function GetCourseData($round)
{
    $data = getDatabase()->one(format_query("SELECT Course FROM :Round WHERE id = $round"));
    $course = $data['Course'];

    if (!$course)
        return array();

    return getDatabase()->all(format_query("
SELECT Course, HoleNumber, HoleText, Par, Length
FROM :Hole
WHERE Course = $course
ORDER BY HoleNumber
"));
}


/**
 * Map hole score to proper css color
 *
 * @param int $score hole score
 * @param int $par hole par
 * @return html class with color
 */
function Score2Color($score, $par)
{
    $diff = $score - $par;

    if (!$score || $score >= 88) // dnf
        return "par";
    if ($score == 1)
        return "hio";

    if ($diff <= -2)
        return "eagle";
    if ($diff == -1)
        return "birdie";
    if ($diff == 0)
        return "par";
    if ($diff == 1)
        return "bogey";
    if ($diff >= 2)
        return "double";
}


/**
 * A copy of pdr_includeStandings from ui/event.php.
 * Adds standing to data from database.
 *
 * @param array $data full competition data
 * @return return modified array
 */
function CalculateStandings($data)
{
    $out = array();
    $lastResult = - 999;
    $lastStanding = 0;
    $step = 1;

    foreach ($data as $item) {
        $result = $item['CumulativePlusminus'];

        if ($item['DidNotFinish'])
            $result = 999;

        if ($result == $lastResult) {
            $item['Standing'] = $lastStanding;
            $step++;
        }
        else {
            $lastStanding += $step;
            $step = 1;
            $item['Standing'] = $lastStanding;
            $lastResult = $result;
        }

        $out[] = $item;
    }
    return $out;
}


/**
 * Show an index page for choosing a event
 */
function live_index()
{
    $event = @$_GET['event'];

    if ($event) {
        getRoute()->redirect("live/$event");
        return null;
    }

    html_header("Kisakone Live");

?>
<div class="col-lg-8 col-md-10 col-sm-12">
<strong>Kisakone Live</strong>
<form method="get">
    <div id="event-selector" class="event-filter"></div>
        <?php echo GetEventSelector(); ?>
    </div>
</form>

<?php
    html_footer();
}


/**
 * Show data for specific event.
 * Defaults to round 1 if round not specified.
 *
 * @param int $event event id
 */
function live_event($event)
{
    $class = @$_GET['class'];
    $round = @$_GET['round'];

    if (!$round) {
        $rounds = GetRounds($event);
        $round = $rounds[0]['id'];
    }

    output_html_response($event, $round, $class);
}


/**
 * If page is not found, redirect to index.
 */
function live_not_found() {
    getRoute()->redirect('index.php');
}


/**
 * Output whatever results is in the array as html
 *
 * @param int $event event id
 * @param int $round round id
 * @param int $class_filter class id
 */
function output_html_response($event, $round, $class_filter)
{
    $eventdata = GetEventData($event);
    $rows = GetRoundResults($round);

    html_header($eventdata['Name'] . " - Kisakone Live");
?>

<div id="header" class="cntr col-lg-10 col-md-12 col-sm-12 col-lg-offset-1">
    <form method="get" id="filter-form">
        <div id="round-selector" class="event-filter">
            <?php echo GetRoundSelector($event); ?>
        </div>
        <div id="class-selector" class="event-filter">
            <?php echo GetClassSelector($event); ?>
        </div>
        <div id="scroll-selector" class="event-filter">
            <?php echo GetScrollSelector(); ?>
        </div>
    </form>
</div>

<div class="col-lg-10 col-md-12 col-sm-12 col-lg-offset-1">
<div class="table-responsive">
<table class="table table-stripped table-hover table-condensed table-bordered">
<thead>

<?php
    $course = GetCourseData($round);
    $holes = count(array_keys($course));
    $colspan = 7 + $holes;
?>

<tr class="cntr">
    <td class="right noborder" colspan="3">Hole:</td>

<?php
    foreach ($course as $hole) {
        $text = $hole['HoleText'] ? $hole['HoleText'] : $hole['HoleNumber'];
        $text = strlen($text) < 2 ? "&nbsp;" . $text : $text;
        print "<td>$text</td>";
    }
?>
    <td>+/-</td><td>Rnd</td><td>+/-</td><td>Tot</td>
</tr>

<tr class="cntr">
    <td class="right noborder" colspan="3">Par:</td>
<?php
    $total_par = 0;
    foreach ($course as $hole) {
        $par = $hole['Par'];
        print "<td>$par</td>";
        $total_par += $par;
    }
?>
    <td>&nbsp;</td><td class="totals"><?php echo $total_par ?></td><td colspan="2" class="noborder">&nbsp;</td>
</tr>

</thead>
<tbody>

<?php
    foreach ($rows as $class) {
        if ($class_filter && $class_filter != $class[0]['Classification'])
            continue;
?>
<tr>
    <th class="classname" colspan="<?php echo $colspan ?>"><?php echo $class[0]['ClassName'] ?></th></tr>
<?php

        foreach ($class as $row) {
            $country = strtolower($row['PDGACountry'] ? $row['PDGACountry'] : "fi");
?>
<tr class="cntr">
    <td><?php echo @$row['Standing'] ?></td>
    <td class="left">
        <span class="pad-right flag-icon flag-icon-<?php echo $country ?>"></span><?php echo $row['FirstName'] . "&nbsp;" . $row['LastName'] ?>
    </td>
    <td class="left"><?php echo $row['ClubName'] ?></td>
<?php
            $dnf = 0;
            foreach (range(1, $holes) as $holenum) {
                $score = @$row['Results'][$holenum]['Result'];
                $par = $course[$holenum-1]['Par'];
                $color = Score2Color($score, $par);

                if ($score >= 99) {
                    $score = "";
                    $dnf = "DNF";
                }
?>
    <td class="<?php echo $color ?>"><?php echo $score ?></td>
<?php
            }

            $round_pm = $row['RoundPlusMinus'];
            $round_t = $row['Total'];
            $cumu_pm = $row['CumulativePlusminus'];
            $cumu_t = $row['CumulativeTotal'];

            if ($dnf)
                $round_pm = $round_t = $cumu_pm = $cumu_t = "DNF";
?>
    <td><?php echo $round_pm ?></td>
    <td><?php echo $round_t ?></td>
    <td class="totals"><?php echo $cumu_pm ?></td>
    <td class="totals"><?php echo $cumu_t ?></td>
</tr>
<?php
        }
    }
?>
</tbody>
</table>
</div>

<footer class="clear cntr" id="footer">Kisakone Live v1.1</footer>
</div>

<?php
    html_footer();
}


/**
 * Print html header for us
 * @param  string $title Page title
 */
function html_header($title)
{
    header("Content-Type: text/html; charset=utf-8");
    header("Cache-Control: private, max-age=0, no-cache");
?>
<!doctype html>
<html>
<title><?php echo $title ?></title>
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/flag-icon/css/flag-icon.min.css" />
<link rel="stylesheet" href="../css/live.css" />
<script src="../sfl/js/analytics.js"></script>
<script src="../js/live.js"></script>
<body onload='setup_reloading(<?php echo @$_GET['presentation'] ?>);'>
<?php
}


/**
 * Print html footer for us
 */
function html_footer()
{
?>
</html>
<?php
}

