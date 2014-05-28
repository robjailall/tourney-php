<?php
include 'functions.php';
validatecookie();
include("header.php");
?>

<script type="text/javascript">

function confirmPathsToVictory(truncate)
{
	var message = "Are you sure you want to calculate paths? \n\n\
ONE sweet 16 game must have already been played or this will time out. \n\n\
If all sweet 16 games or more are left, you must run this from the terminal. \n\n\
	Example: php ./mmm/admin/calculate_paths_to_victory.php\n\n\
Obviously, you can only feasibly calculate this (hours instead of years) after the first round.";

	if( window.confirm(message) )
	{
		window.location.href ="calculate_paths_to_victory.php?truncate="+truncate;
	}
}

</script>

	<div id="main">
		<div class="full">
			<h2>Select a Task</h2>
			<ul>
				<li><a href="install.htm">(Re)Configure the site</a></li>
				<li><a href="paid.php">View Paid List</a></li>
			<?php if($meta['mail'] != 0 ) { ?>
				<li><a href="../code.php">Email Submission Code</a></li>
				<li><a href="contactall.php">Contact all users</a></li>
			<?php } ?>
				<li><a href="start.htm">Initialize the Bracket</a></li>
				<li><a href="bracket.php">Edit Master Bracket</a></li>
				<li><a href="edit.php">Edit a Bracket</a></li>
				<li><a href="paid.php">Edit Paid List</a></li>
				<li><a href="blog.php">Add/Remove Blog Posts</a></li>
				<li><a href="rules.php">Edit Rules</a></li>
				<li><a href="close.php">Close Bracket Submission</a></li>
				<li><a href="score.php">Score All Brackets</a> (performed automatically when editing the master bracket)</li>
				<li><a href="javascript:confirmPathsToVictory(false)">Recalculate Paths To Victory</a> (From sweet 16)</li>
				<li><a href="javascript:confirmPathsToVictory(true)">Recalculate Paths To Victory AND delete previous calculations</a> (From sweet 16)</li>
			</ul>
			<p><b>NOTE on Paths To Victory</b>
			   Paths to vistory should not be run before the final 16 games.  A great deal of information is calculated by this process,
			   it is still possible that this may cause a timeout on your web server, which can
			   cause partially computed results.  If this should happen, the paths can be calculated manually on your server using
			   this command line in your install directory: <br/>
			   &nbsp;&nbsp;&nbsp;&nbsp;<code>php ./admin/calculate_paths_to_victory.php truncate</code><br/>
			   The final 'truncate' keyword is only needed if you have partial results calculated, as they must be cleaned up.<br/>
                           Once 14 or fewer games remain, this function should be able to complete successfully from the browser unless you have a
			   huge number of brackets, in which case the command line will still have to be used.
			</p>
		</div>
	</div>
</div>
</body>
</html>
