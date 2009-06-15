<?php
// This sidebar is on the list of MPs pages

global $MEMBER;

    $SEARCHURL = new URL("search");
	$this->block_start(array('id'=>'mpsearch', 'title'=>"Search by name (including former MPs)"));
	?>

	<div class="mpsearchbox">
		<form action="<?php echo $SEARCHURL->generate(); ?>" method="get">
		<p>
    		<input name="s" size="24" maxlength="200">
    		<input type="submit" class="submit" value="GO">
		</p>
		<small>e.g. <a href="/search/?s=David+Cameron">David Cameron</a> or <a href="/search/?s=Tony+Benn">Tony Benn</a></small>
		</form>
	</div>

<?php
	$this->block_end();
?>
