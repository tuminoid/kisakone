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


require_once 'epiphany/src/Epi.php';
Epi::setPath('base', 'epiphany/src');
Epi::init('route', 'database');

require_once '../config.php';
global $settings;
$settings['DB_TYPE'] = 'mysql';
EpiDatabase::employ($settings['DB_TYPE'], $settings['DB_DB'], $settings['DB_ADDRESS'], $settings['DB_USERNAME'], $settings['DB_PASSWORD']);

getRoute()->get('/', 'live_index');
getRoute()->get('/(\d+)', 'live_event');
getRoute()->run();


/**
 * Query results for a round
 *
 * @param  int $round round id
 * @return array of data
 */
function query_results($round)
{
    $rows = getDatabase()->all("
SELECT kisakone_Player.player_id AS PlayerId, kisakone_Player.firstname AS FirstName, kisakone_Player.lastname AS LastName,
    kisakone_Player.pdga AS PDGANumber, kisakone_PDGAPlayers.rating AS Rating, kisakone_RoundResult.Result AS Total,
    kisakone_RoundResult.Penalty, kisakone_RoundResult.SuddenDeath,
    kisakone_StartingOrder.GroupNumber, (kisakone_HoleResult.Result - kisakone_Hole.Par) AS Plusminus, Completed,
    kisakone_HoleResult.Result AS HoleResult, kisakone_Hole.id AS HoleId, kisakone_Hole.HoleNumber, kisakone_RoundResult.PlusMinus AS RoundPlusMinus,
    kisakone_Classification.Name AS ClassName, CumulativePlusminus, CumulativeTotal, kisakone_RoundResult.DidNotFinish,
    kisakone_Classification.id AS Classification, kisakone_Club.ShortName AS ClubName,
    kisakone_PDGAPlayers.country AS PDGACountry
FROM kisakone_Round
LEFT JOIN kisakone_Section ON kisakone_Round.id = kisakone_Section.Round
LEFT JOIN kisakone_StartingOrder ON (kisakone_StartingOrder.Section = kisakone_Section.id)
LEFT JOIN kisakone_RoundResult ON (kisakone_RoundResult.Round = kisakone_Round.id AND kisakone_RoundResult.Player = kisakone_StartingOrder.Player)
LEFT JOIN kisakone_HoleResult ON (kisakone_HoleResult.RoundResult = kisakone_RoundResult.id AND kisakone_HoleResult.Player = kisakone_StartingOrder.Player)
LEFT JOIN kisakone_Player ON kisakone_StartingOrder.Player = kisakone_Player.player_id
LEFT JOIN kisakone_User ON kisakone_Player.player_id = kisakone_User.Player
LEFT JOIN kisakone_Participation ON (kisakone_Participation.Player = kisakone_Player.player_id AND kisakone_Participation.Event = kisakone_Round.Event)
LEFT JOIN kisakone_Classification ON kisakone_Classification.id = kisakone_Participation.Classification
LEFT JOIN kisakone_Hole ON kisakone_HoleResult.Hole = kisakone_Hole.id
LEFT JOIN kisakone_Club ON kisakone_Participation.Club = kisakone_Club.id
LEFT JOIN kisakone_PDGAPlayers ON kisakone_Player.pdga = kisakone_PDGAPlayers.pdga_number
WHERE kisakone_Round.id = $round AND kisakone_Section.Present
ORDER BY
    (kisakone_RoundResult.DidNotFinish IS NULL OR kisakone_RoundResult.DidNotFinish = 0) DESC,
    kisakone_Hole.id IS NULL, kisakone_RoundResult.CumulativePlusminus, kisakone_Player.player_id
");

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
        $retValue[$k] = calculate_standings($v);

    return $retValue;
}


/**
 * Query db for rounds in an event
 *
 * @param  int $event event id
 * @return array of data
 */
function query_rounds($event)
{
    return getDatabase()->all("
SELECT id
FROM kisakone_Round
WHERE Event = $event
ORDER BY StartTime
");
}


/**
 * Get list of active events as html drop-down
 *
 * @return html output with select drop-down
 */
function create_event_select()
{
    $start = time() - 7*24*60*60;
    $end = time() + 7*24*60*60;

    $events = getDatabase()->all("
SELECT id, Name
FROM kisakone_Event
WHERE Date BETWEEN FROM_UNIXTIME($start) AND FROM_UNIXTIME($end)
ORDER BY Date, id
");

    $data = '
        <label for="event">Choose event:</label>
        <select id="event" name="event">
            <option value="">---</option>
    ';
    foreach ($events as $event) {
        $data .= '<option value="' . $event['id'] . '">' . $event['Name'] . '</option>' . "\n";
    }
    $data .= '        </select>' . "\n";
    $data .= "
            <script>
            $('#event').change(function() {
                var url = '/live/' + $('#event').val();
                $(location).attr('href', url);
            });
            </script>
    ";

    return $data;
}


/**
 * Create a drop-down for rounds in an event
 *
 * @param int $event event id
 * @return html code with drop-down
 */
function create_round_select($event)
{
    $prev_round = @$_GET['round'];

    $rounds = query_rounds($event);
    $data = '
    <label for="round">Round:</label>
    <select id="round" name="round">
    ';

    $round_idx = 1;

    foreach ($rounds as $round) {
        $data .= '<option value="' . $round['id'] . '"' .
            ($prev_round == $round['id'] ? ' selected="selected"' : '') . '>Round ' . $round_idx++ . '</option>' . "\n";
    }

    $data .= '
    </select>
    <script defer="defer">$("#round").change(function() { $("#filter-form").submit(); });</script>
    ';

    return $data;
}


/**
 * Create a drop-down for classes in an event
 *
 * @param int $event event id
 * @return html code with drop-down
 */
function create_class_select($event)
{
    $prev_class = @$_GET['class'];

    $classes = getDatabase()->all("
SELECT kisakone_Classification.id AS id, Name
FROM kisakone_Classification
INNER JOIN kisakone_ClassInEvent ON (kisakone_ClassInEvent.Event = $event AND kisakone_ClassInEvent.Classification = kisakone_Classification.id)
ORDER BY kisakone_Classification.id
");

    $data = '
    <label for="class">Class:</label>
    <select id="class" name="class">
        <option value="">---</option>
    ';

    foreach ($classes as $class) {
        $data .= '<option value="' . $class['id'] . '"' .
            ($prev_class == $class['id'] ? ' selected="selected"' : '') . '>' . $class['Name'] . '</option>' . "\n";
    }

    $data .= '
    </select>
    <script defer="defer">$("#class").change(function() { $("#filter-form").submit(); });</script>
    ';

    return $data;
}


/**
 * Create a drop-down for scrollspeed
 *
 * @return html code with drop-down
 */
function create_scroll_select()
{
    return '
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
';
}


function get_event_data($event)
{
    return getDatabase()->one("SELECT id, Name FROM kisakone_Event WHERE id = $event");
}


function get_course_data($round)
{
    $data = getDatabase()->one("SELECT Course FROM kisakone_Round WHERE id = $round");
    $course = $data['Course'];

    if (!$course)
        return array();

    return getDatabase()->all("
SELECT Course, HoleNumber, HoleText, Par, Length
FROM kisakone_Hole
WHERE Course = $course
ORDER BY HoleNumber
");
}


/**
 * Map hole score to proper css color
 *
 * @param int $score hole score
 * @param int $par hole par
 * @return html class with color
 */
function map_score_to_color($score, $par)
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
function calculate_standings($data)
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
 *
 * If year is available in _GET, redirect to real api url
 */
function live_index()
{
    $event = @$_GET['event'];

    if ($event) {
        getRoute()->redirect("/kisakone/live/$event");
        return null;
    }

    html_header("Kisakone Live - Choose event and view to present");

?>
<div class="col-lg-8 col-md-10 col-sm-12">
<strong>Kisakone Live Presentation</strong>
<form method="get">
    <div id="event-selector" class="event-filter"></div>
        <?php echo create_event_select(false); ?>
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
        $rounds = query_rounds($event);
        $round = $rounds[0]['id'];
    }

    output_html_response($event, $round, $class);
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
    $eventdata = get_event_data($event);
    $rows = query_results($round);

    html_header("Kisakone Live - " . $eventdata['Name']);
?>

<div id="header" class="cntr col-lg-10 col-md-12 col-sm-12 col-lg-offset-1">
    <h1><?php echo $eventdata['Name'] ?></h1>

    <form method="get" id="filter-form">
        <div id="round-selector" class="event-filter">
            <?php echo create_round_select($event); ?>
        </div>
        <div id="class-selector" class="event-filter">
            <?php echo create_class_select($event); ?>
        </div>
        <div id="scroll-selector" class="event-filter">
            <?php echo create_scroll_select(); ?>
        </div>
    </form>
</div>

<div class="col-lg-10 col-md-12 col-sm-12 col-lg-offset-1">
<div class="table-responsive">
<table class="table table-stripped">
<tbody>

<?php
    $course = get_course_data($round);
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
                $color = map_score_to_color($score, $par);

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

<footer class="clear cntr" id="footer">Kisakone Live v1.0</footer>
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
?>
<!doctype html>
<html>
<title><?php echo $title ?></title>
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/css/flag-icon/css/flag-icon.min.css" type="text/css" />
<link rel="stylesheet" href="/css/live.css" type="text/css" />

<script>
var scrolltime = 2 * <?php echo @$_GET['presentation'] ?>0 * 100;
var reloadtime = scrolltime*2 + 15*1000;

function autoscroll() {
    $('#filter-form').hide();
    $('html, body').animate({ scrollTop: $('#footer').offset().top }, scrolltime);
    $('html, body').animate({ scrollTop: $('#header').offset().top }, scrolltime);
}

function reload_page() {
    window.location.reload(true);
}

setTimeout(reload_page, reloadtime);
</script>
<body<?php if (@$_GET['presentation']) echo ' onload="autoscroll();"' ?>>
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

