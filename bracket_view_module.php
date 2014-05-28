<?php

function viewBracket( $meta, $picks, $team_data, $rank, $score_data, $best_data )
{
?>

<script>

function displayNextRoundWinValue( val )
{
	window.status = "A win in the next round for this team is worth " + val;
	return true;
}

function clearStatus()
{
	window.status = "";
	return true;
}

</script>

<style type="text/css">
.content
{
	width:1110px;
}

#main
{
	width:1106px;
}
</style>

<link rel="stylesheet" media="print" href="images/print.css" type="text/css" />
 <div id="main"> 
  <div class="full"> 
     <div id="bracketheader">
     <?php
     	if (isset($_COOKIE['useremail']) == true)
		{
			echo stripslashes($picks['name']) . " (" . stripslashes($picks['person']) . ")";
		}
		else
		{
     		echo stripslashes($picks['name']);
     	}
	?>
		  <table border="0" width="100%">
		 	<tr>
				<?php if( $rank != "" ) { ?> <td>Rank: <?php echo $rank ?></td><?php } ?>
				<?php if( $best_data['score'] != "" ) { ?> <td>Best Score Possible: <?php echo $best_data['score'] ?></td><?php } ?>
			</tr>
			 <tr>
				<?php if( $score_data['score'] != "") { ?><td>Score: <?php echo $score_data['score'] ?></td><?php } ?>
				<?php if( $best_data['score'] != "") { ?><td>Possible Points Remaining: <?php echo $best_data['score']- $score_data['score'] ?></td><?php } ?>
			</tr>
		 </table>
	 </div>
	 <div id="printlink"><h3><a href="#" onclick="window.print();">Printable Version</a></h3></div>
     
     <div name="bracket" class="bracket" id="bracket">
      <table width="1100" border="1" cellspacing="0" cellpadding="0" > 
         <tr> 
          <td width="100"><?php echo $meta['region1']; ?></td>
          <td width="100">Round of 32</td>
          <td width="100">Sweet 16</td>
          <td width="100">Elite 8</td>
          <td width="100">Final 4</td>
          <td width="100" align="center">Champ</td>
          <td width="100" align="right">Final 4</td>
          <td width="100" align="right">Elite 8</td>
          <td width="100" align="right">Sweet 16</td>
          <td width="100" align="right">Round of 32</td>
          <td width="100" align="right"><?php echo $meta['region3']; ?> </td> 
        </tr> 
         <tr> 
          <td width="100"><?php echo $team_data['1']; ?></td> 
          <td width="100" rowspan="2"><?php echo $picks['1']; ?></td> 
          <td width="100" rowspan="4"><?php echo $picks['33']; ?></td> 
          <td width="100" rowspan="8"><?php echo $picks['49']; ?></td> 
          <td width="100" rowspan="16"><?php echo $picks['57']; ?></td> 
          <td width="100" rowspan="12"><?php echo $picks['61']; ?></td> 
          <td width="100" align="right" rowspan="16"><?php echo $picks['59']; ?></td> 
          <td width="100" align="right" rowspan="8"><?php echo $picks['53']; ?></td> 
          <td width="100" align="right" rowspan="4"><?php echo $picks['41']; ?></td> 
          <td width="100" align="right" rowspan="2"><?php echo $picks['17']; ?></td> 
          <td width="100" align="right"><?php echo $team_data['33']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['2']; ?></td> 
          <td align="right"><?php echo $team_data['34']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['3']; ?></td> 
          <td rowspan="2"><?php echo $picks['2']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['18']; ?></td> 
          <td align="right"><?php echo $team_data['35']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['4']; ?></td> 
          <td align="right"><?php echo $team_data['36']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['5']; ?></td> 
          <td rowspan="2"><?php echo $picks['3']; ?></td> 
          <td rowspan="4"><?php echo $picks['34']; ?></td> 
          <td align="right" rowspan="4"><?php echo $picks['42']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['19']; ?></td> 
          <td align="right"><?php echo $team_data['37']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['6']; ?></td> 
          <td align="right"><?php echo $team_data['38']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['7']; ?></td> 
          <td rowspan="2"><?php echo $picks['4']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['20']; ?></td> 
          <td align="right"><?php echo $team_data['39']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['8']; ?></td> 
          <td align="right"><?php echo $team_data['40']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['9']; ?></td> 
          <td rowspan="2"><?php echo $picks['5']; ?></td> 
          <td rowspan="4"><?php echo $picks['35']; ?></td> 
          <td rowspan="8"><?php echo $picks['50']; ?></td> 
          <td align="right" rowspan="8"><?php echo $picks['54']; ?></td> 
          <td align="right" rowspan="4"><?php echo $picks['43']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['21']; ?></td> 
          <td align="right"><?php echo $team_data['41']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['10']; ?></td> 
          <td align="right"><?php echo $team_data['42']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['11']; ?></td> 
          <td rowspan="2"><?php echo $picks['6']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['22']; ?></td> 
          <td align="right"><?php echo $team_data['43']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['12']; ?></td> 
          <td align="right"><?php echo $team_data['44']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['13']; ?></td> 
          <td rowspan="2"><?php echo $picks['7']; ?></td> 
          <td rowspan="4"><?php echo $picks['36']; ?></td> 
          <td rowspan="8" align="center"><?php echo $picks['63']; ?>
          <?php if( $picks['tiebreaker'] ) { ?><p>Tiebreaker: <?php echo $picks['tiebreaker']; } ?>
          </td> 
          <td align="right" rowspan="4"><?php echo $picks['44']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['23']; ?></td> 
          <td align="right"><?php echo $team_data['45']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['14']; ?></td> 
          <td align="right"><?php echo $team_data['46']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['15']; ?></td> 
          <td rowspan="2"><?php echo $picks['8']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['24']; ?></td> 
          <td align="right"><?php echo $team_data['47']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['16']; ?></td> 
          <td align="right"><?php echo $team_data['48']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['17']; ?></td> 
          <td rowspan="2"><?php echo $picks['9']; ?></td> 
          <td rowspan="4"><?php echo $picks['37']; ?></td> 
          <td rowspan="8"><?php echo $picks['51']; ?></td> 
          <td rowspan="16"><?php echo $picks['58']; ?></td> 
          <td align="right" rowspan="16"><?php echo $picks['60']; ?></td> 
          <td align="right" rowspan="8"><?php echo $picks['55']; ?></td> 
          <td align="right" rowspan="4"><?php echo $picks['45']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['25']; ?></td> 
          <td align="right"><?php echo $team_data['49']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['18']; ?></td> 
          <td align="right"><?php echo $team_data['50']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['19']; ?></td> 
          <td rowspan="2"><?php echo $picks['10']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['26']; ?></td> 
          <td align="right"><?php echo $team_data['51']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['20']; ?></td> 
          <td align="right"><?php echo $team_data['52']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['21']; ?></td> 
          <td rowspan="2"><?php echo $picks['11']; ?></td> 
          <td rowspan="4"><?php echo $picks['38']; ?></td> 
          <td rowspan="12" align="right"><?php echo $picks['62']; ?></td> 
          <td align="right" rowspan="4"><?php echo $picks['46']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['27']; ?></td> 
          <td align="right"><?php echo $team_data['53']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['22']; ?></td> 
          <td align="right"><?php echo $team_data['54']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['23']; ?></td> 
          <td rowspan="2"><?php echo $picks['12']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['28']; ?></td> 
          <td align="right"><?php echo $team_data['55']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['24']; ?></td> 
          <td align="right"><?php echo $team_data['56']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['25']; ?></td> 
          <td rowspan="2"><?php echo $picks['13']; ?></td> 
          <td rowspan="4"><?php echo $picks['39']; ?></td> 
          <td rowspan="8"><?php echo $picks['52']; ?></td> 
          <td align="right" rowspan="8"><?php echo $picks['56']; ?></td> 
          <td align="right" rowspan="4"><?php echo $picks['47']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['29']; ?></td> 
          <td align="right"><?php echo $team_data['57']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['26']; ?></td> 
          <td align="right"><?php echo $team_data['58']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['27']; ?></td> 
          <td rowspan="2"><?php echo $picks['14']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['30']; ?></td> 
          <td align="right"><?php echo $team_data['59']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['28']; ?></td> 
          <td align="right"><?php echo $team_data['60']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['29']; ?></td> 
          <td rowspan="2"><?php echo $picks['15']; ?></td> 
          <td rowspan="4"><?php echo $picks['40']; ?></td> 
          <td align="right" rowspan="4"><?php echo $picks['48']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['31']; ?></td> 
          <td align="right"><?php echo $team_data['61']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['30']; ?></td> 
          <td align="right"><?php echo $team_data['62']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['31']; ?></td> 
          <td rowspan="2"><?php echo $picks['16']; ?></td> 
          <td align="right" rowspan="2"><?php echo $picks['32']; ?></td> 
          <td align="right"><?php echo $team_data['63']; ?></td> 
        </tr> 
         <tr> 
          <td><?php echo $team_data['32']; ?></td> 
          <td align="right"><?php echo $team_data['64']; ?></td> 
        </tr> 
         <tr> 
          <td width="100"><?php echo $meta['region2']; ?></td> 
          <td width="100">Round of 32</td>
          <td width="100">Sweet 16</td>
          <td width="100">Elite 8</td>
          <td width="100">Final 4</td>
          <td width="100" align="center">Champ</td>
          <td width="100" align="right">Final 4</td>
          <td width="100" align="right">Elite 8</td>
          <td width="100" align="right">Sweet 16</td>
          <td width="100" align="right">Round of 32</td>
          <td width="100" align="right"><?php echo $meta['region4']; ?> </td> 
        </tr> 
       </table> 
    </div> 
   </div> 
</div> 


<?php

}

?>
