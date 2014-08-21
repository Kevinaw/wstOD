<div class="paypal_feedback">
  <a href="http://www.paypal.com" target="_blank"><img src="ccdata/images/PPLogo.png" align="right" border="0"></a>

<h3><?php echo $ResponseText; ?></h3>
<table align="center">
<tr>
	<td align="right" width="175" valign=top><b><?php echo _T("Amount:"); ?></b></td>
	<td align="left"><?php echo $checkout->resArray['mc_currency'] . ' ' . $checkout->resArray['mc_gross']; ?></td>
</tr>

<tr>
	<td align="right" width="175" valign=top><b><?php echo _T("Transaction ID:"); ?></b></td>
	<td align="left"><?php echo $checkout->resArray['txn_id']; ?></td></tr>
<tr>
	<td>&nbsp;</td>
	<td valign="top"><b><em><?php echo _T("Thank you for your business!") ?></em></b>
	<p class="return_button"><a href="<?php echo $myPage->getFullUrl('index.php'); ?>"><?php echo _T('Done - Return to the Shop'); ?></a></p>
	</td>
</tr>
</table>
</div>