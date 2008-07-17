<ul>

<li>TheyWorkForYou search is case-insensitive, and tries to match all the search terms within a document. </li>

<li>To exclude a word from your search, put a minus ("-") sign in front,
for example to find documents containing the word "representation" but not the word "taxation":<br>
<span class="example-input">representation -taxation</span></li>

<li>To search for an exact phrase, use quotes (""). For example to find only documents contain the exact phrase "Hutton Report":<br>
<span class="example-input">"hutton report"</span></li>

<li>If you want to search for words only when they're used near each other in the text, use "NEAR". For example, to find documents containing the word "elephant" near the word "room":<br>
<span class="example-input">elephant NEAR room</span></li>

<li>If the search phrase matches (part of) an MP or Peer's name, their own page will appear as the top result, but will also search speeches made by them too.</li>

<li>From a person's page, you have the option to search only their speeches. </li>

<li><strong>Advanced Users:</strong> You can perform boolean searches, with brackets, AND, OR, and XOR. There are many prefixes you can use directly instead of the advanced search form, here's a selection:
<ul>
<li>column:123
<li>party:Lab
<li>department:Defence
<li>section:uk section:wms
<li>date:20080716
<li>20080101..20080131
</ul>
</li>

<?php
$user_agent = ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) ? strtolower( $_SERVER['HTTP_USER_AGENT'] ) : '';
if (stristr($user_agent, 'Firefox/')) {
?>
	 <li>You can also add TheyWorkForYou to <a href="http://mycroft.mozdev.org/download.html?name=theyworkforyou">Firefox's search box</a>.</li>
<?php
}
?>

</ul>

