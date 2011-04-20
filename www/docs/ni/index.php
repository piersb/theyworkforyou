<?php

include_once "../../includes/easyparliament/init.php";
include_once INCLUDESPATH . "easyparliament/glossary.php";

// For displaying all the NIA debates on a day, or a single debate. 

if (get_http_var("d") != "") {
	$this_page = "nidebatesday";
	$args = array (
		'date' => get_http_var('d')
	);
	$LIST = new NILIST;
	$LIST->display('date', $args);
	
} elseif (get_http_var('id') != "") {
	$this_page = "nidebates";
	$args = array (
		'gid' => get_http_var('id'),
		's'	=> get_http_var('s'),	// Search terms to be highlighted.
		'member_id' => get_http_var('m'),	// Member's speeches to be highlighted.
		'glossarise' => 2	// Glossary is on by default
	);

	if (preg_match('/speaker:(\d+)/', get_http_var('s'), $mmm))
		$args['person_id'] = $mmm[1];

	// Glossary can be turned off in the url
	if (get_http_var('ug') == 1) {
		$args['glossarise'] = 0;
	}
	else {
		$args['sort'] = "regexp_replace";
		$GLOSSARY = new GLOSSARY($args);
	}

	$LIST = new NILIST;
	
	$result = $LIST->display('gid', $args);
	// If it is a redirect, change URL
	if (is_string($result)) {
		$URL = new URL('nidebates');
		$URL->insert( array('id'=>$result) );
		header('Location: http://' . DOMAIN . $URL->generate('none'), true, 301);
		exit;
	}

} elseif (get_http_var('y') != '') {
	
	$this_page = 'nidebatesyear';
	if (is_numeric(get_http_var('y'))) {
		$pagetitle = $DATA->page_metadata($this_page, 'title');
		$DATA->set_page_metadata($this_page, 'title', $pagetitle.' '.get_http_var('y'));
	}
	$PAGE->page_start();
	$PAGE->stripe_start();
	$args = array (
		'year' => get_http_var('y')
	);
	$LIST = new NILIST;
	$LIST->display('calendar', $args);
	$PAGE->stripe_end(array(
		array (
			'type' => 'nextprev'
		),
		array (
			'type' => 'include',
			'content' => "nidebates"
		)
	));
	
} elseif (get_http_var('gid') != '') {
	$this_page = 'nidebate';
	$args = array(
		'gid' => get_http_var('gid'),
		's' => get_http_var('s'),	// Search terms to be highlighted.
		'member_id' => get_http_var('m'),	// Member's speeches to be highlighted.
		'glossarise' => 2	// Glossary is on by default
	);
	if (preg_match('/speaker:(\d+)/', get_http_var('s'), $mmm))
		$args['person_id'] = $mmm[1];

	$args['sort'] = "regexp_replace";
	$GLOSSARY = new GLOSSARY($args);

	$NILIST = new NILIST;
	$result = $NILIST->display('gid', $args);
	// If it is a redirect, change URL
	if (is_string($result)) {
		$URL = new URL('nidebate');
		$URL->insert( array('gid'=>$result) );
		header('Location: http://' . DOMAIN . $URL->generate('none'));
		exit;
	}
	if ($NILIST->htype() == '12' || $NILIST->htype() == '13') {
		$PAGE->stripe_start('side', 'comments');
		$COMMENTLIST = new COMMENTLIST;
		$args['user_id'] = get_http_var('u');
		$args['epobject_id'] = $NILIST->epobject_id();
		$COMMENTLIST->display('ep', $args);
		$PAGE->stripe_end();
		$PAGE->stripe_start('side', 'addcomment');
		$commendata = array(
			'epobject_id' => $NILIST->epobject_id(),
			'gid' => get_http_var('gid'),
			'return_page' => $this_page
		);
		$PAGE->comment_form($commendata);
		if ($THEUSER->isloggedin()) {
			$sidebar = array(
				array(
					'type' => 'include',
					'content' => 'comment'
				)
			);
			$PAGE->stripe_end($sidebar);
		} else {
			$PAGE->stripe_end();
		}
	}
} else {
    ni_front_page();
}

$PAGE->page_end();

twfy_debug_timestamp("page end");

# ---

function ni_front_page() {
    global $this_page, $PAGE, $THEUSER, $SEARCHURL;

	$this_page = "nioverview";
	$PAGE->page_start();
	$PAGE->stripe_start('full');
    $SEARCHURL = new URL('search');
?>

<h2>Northern Ireland Assembly</h2>

<div class="welcome_col1">

<div id="welcome_ni" class="welcome_actions">

    <div>
        <h3>Your representative</h3>
            <form action="/postcode/" method="get">
            <p><strong>Find out about your <acronym title="Members of the Legislative Assembly">MLAs</acronym></strong><br>
            <label for="pc">Enter your postcode here:</label>&nbsp; <input type="text" name="pc" id="pc" size="8" maxlength="10" value="<?php echo htmlentities($THEUSER->postcode()); ?>" class="text">&nbsp;&nbsp;<input type="submit" value=" Go " class="submit"></p>
            </form>
        <p>Read debates they&rsquo;ve taken part in, see how they voted, sign up for an email alert, and more.</p>
    </div>
    <!-- Search / alerts -->
    <div id="welcome_search">
        <form action="<?php echo $SEARCHURL->generate(); ?>" method="get">
            <h3><label for="s">Search,  create an alert or RSS feed</label></h3>
            <p>
                <input type="text" name="s" id="s" size="20" maxlength="100" class="text" value="<?=htmlspecialchars(get_http_var("keyEord"))?>">&nbsp;&nbsp;
                <input type="hidden" name="section" value="ni">
                <input type="submit" value="Go" class="submit">
                <br>
                <small>e.g. a <em>word</em>, <em>phrase</em>, or <em>person</em> | <a href="/search/?adv=1">More options</a></small>
            </p>
        </form>
    </div>

    <a class="credit" href="http://www.flickr.com/photos/lyng883/255250716/">Photo by Lyn Gateley</a>

    <br class="clear">
</div>

<?php

$PAGE->include_sidebar_template('nidebates');

?>

</div>

<div class="welcome_col2">

<h3>Recent Northern Ireland Assembly debates</h3>

<?php

$DEBATELIST = new NILIST;
$DEBATELIST->display('recent_debates', array('days' => 30, 'num' => 5));
$MOREURL = new URL('nidebatesfront');

?>
        <p align="right"><strong><a href="<?php echo $MOREURL->generate(); ?>">See more debates</a></strong></p>

</div>

<?php

$PAGE->stripe_end();

}

