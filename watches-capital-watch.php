<?php
/*
Plugin Name: Watches Capital Watch
Plugin URI: http://www.watchescapital.com/widgets.php
Description: A sidebar widget that adds a beautiful watch to your wordpress blog which shows your visitors local time.
Version: 1.0
Author: Astral Web, Inc
Author URI: http://www.promoteseo.com/
*/

/*	
	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	
*/

$folderaname=dirname(__FILE__);

$fullopena=$folderaname."/optionsmcs.txt";

// We're putting the plugin's functions in one big function we then
// call at 'plugins_loaded' (add_action() at bottom) to ensure the
// required Sidebar Widget functions are available.
function widget_watchescapitalwatch_init() {

	// Check to see required Widget API functions are defined...
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return; // ...and if not, exit gracefully from the script.

	// This function prints the sidebar widget--the cool stuff!
	function widget_watchescapitalwatch($args) {

		// $args is an array of strings which help your widget
		// conform to the active theme: before_widget, before_title,
		// after_widget, and after_title are the array keys.
		extract($args);

		// Collect our widget's options, or define their defaults.
		$options = get_option('widget_watchescapitalwatch');
		$title = empty($options['title']) ? '' : $options['title'];
		$text = empty($options['text']) ? '' : $options['text'];
		$credit = empty($options['credit']) ? 'no' : $options['credit'];


 		// It's important to use the $before_widget, $before_title,
 		// $after_title and $after_widget variables in your output.
		echo $before_widget;
		echo $before_title . $title . $after_title;


$selfa=$_SERVER['PHP_SELF'];
$foldera = dirname($selfa);
if($foldera=='/'){$foldera='';}
echo '<iframe src="'.$foldera.'/wp-content/plugins/watches-capital-watch/watchescapitalwatch.php" frameborder="0" scrolling="no" width="160" height="180"></iframe>';echo "\n";
if(($credit!='no')&&($credit!='')){echo '<div align=center style="font-size:11px;">powered by <a href="http://www.watchescapital.com/widgets.php">Watches Capital</a></div>';echo "\n";}


		echo $text;
		echo $after_widget;
	}

	// This is the function that outputs the form to let users edit
	// the widget's title and so on. It's an optional feature, but
	// we'll use it because we can!
	function widget_watchescapitalwatch_control() {

		// Collect our widget's options.
		$options = get_option('widget_watchescapitalwatch');

		// This is for handing the control form submission.
		if ( $_POST['watchescapitalwatch-submit'] ) {
			// Clean up control form submission options
			$newoptions['title'] = strip_tags(stripslashes($_POST['watchescapitalwatch-title']));
			$newoptions['text'] = strip_tags(stripslashes($_POST['watchescapitalwatch-text']));
			$newoptions['credit'] = strip_tags(stripslashes($_POST['watchescapitalwatch-credit']));
			$formsubmitted=$_POST['watchescapitalwatch-submit'];


if($newoptions['credit']==''){$newoptions['credit']=='0';}

$fh = fopen("./optionsmcs.txt", 'w') or die("can't write file. check permissions");
$stringDataz = $newoptions['title']."^||||^".$newoptions['text']."^||||^".$newoptions['credit']."^||||^".$formsubmitted;
fwrite($fh, $stringDataz);
fclose($fh);

		}
else{

//$fh = fopen($fullopena, 'r');
$fh = fopen("./optionsmcs.txt", 'r');
$theData = fgets($fh);
fclose($fh);
$theData2 = explode('^||||^', $theData);
$newoptions['title']=$theData2[0];
$newoptions['text']=$theData2[1];
$newoptions['credit']=$theData2[2];
update_option('widget_watchescapitalwatch', $newoptions);
}

		// If original widget options do not match control form
		// submission options, update them.
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_watchescapitalwatch', $options);
		}


		// Format options as valid HTML. Hey, why not.
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$text = htmlspecialchars($options['text'], ENT_QUOTES);
		$credit = htmlspecialchars($options['credit'], ENT_QUOTES);
//		$watchescapitalwatch-submit = htmlspecialchars($options['watchescapitalwatch-submit'], ENT_QUOTES);

// The HTML below is the control form for editing options.
?>
		<div>
		<label for="watchescapitalwatch-title" style="line-height:35px;display:block;">Widget title: <input type="text" id="watchescapitalwatch-title" name="watchescapitalwatch-title" value="<?php echo $title; ?>" /></label>
		<label for="watchescapitalwatch-text" style="line-height:35px;display:block;">Widget text: <input type="text" id="watchescapitalwatch-text" name="watchescapitalwatch-text" value="<?php echo $text; ?>" /></label>
		<label for="watchescapitalwatch-credit" style="line-height:35px;display:block;">Give Credit to Author: <input type="checkbox" id="watchescapitalwatch-credit" name="watchescapitalwatch-credit" <?php if(($credit!='')||(!($formsubmitted))){echo 'checked';} ?> /></label>
		<input type="hidden" name="watchescapitalwatch-submit" id="watchescapitalwatch-submit" value="1" />

		</div>
	<?php
	// end of widget_watchescapitalwatch_control()
	}

	// This registers the widget. About time.
	register_sidebar_widget('Watches Capital Watch', 'widget_watchescapitalwatch');

	// This registers the (optional!) widget control form.
	register_widget_control('Watches Capital Watch', 'widget_watchescapitalwatch_control');
}

// Delays plugin execution until Dynamic Sidebar has loaded first.
add_action('plugins_loaded', 'widget_watchescapitalwatch_init');
?>